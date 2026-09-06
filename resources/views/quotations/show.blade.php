@extends('layouts.adminlte')

@section('title', 'Quotation Detail - ' . $quotation->quotation_no)
@section('page-title', 'Quotation Detail')

@section('styles')
<style>
    /* Printing Layout Rules */
    @media print {
        /* Hide everything that shouldn't be printed */
        .app-header, 
        .app-sidebar, 
        .app-footer, 
        .no-print, 
        .btn {
            display: none !important;
        }
        
        /* Enforce body and main wrapper to occupy full width and have no margin/padding constraints */
        html, body, .app-wrapper, .app-main, .app-content, .container-fluid {
            background-color: #fff !important;
            color: #000 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            height: auto !important;
            position: static !important;
            overflow: visible !important;
        }
        
        /* Make content wrapper take full space */
        .app-main {
            margin-left: 0 !important;
            padding-top: 0 !important;
        }

        /* Remove borders and shadows from printable invoice card */
        .print-container {
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            position: static !important;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse !important;
        }

        .table th, .table td {
            border: 1px solid #dee2e6 !important;
            padding: 8px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="row no-print mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="{{ route('quotations.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a href="{{ route('sales.create', ['quotation_id' => $quotation->id]) }}" class="btn btn-success">
                <i class="bi bi-check-circle me-1"></i> Convert to Sale
            </a>
            <button onclick="downloadPDF()" class="btn btn-outline-success">
                <i class="bi bi-download me-1"></i> Download PDF
            </button>
            <button onclick="printQuotation()" class="btn btn-primary">
                <i class="bi bi-printer me-1"></i> Print
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <!-- Printable Invoice Container -->
        <div class="card shadow-sm border-0 print-container">
            <div class="card-body p-4 p-md-5">
                <!-- Quotation Header -->
                <div class="row mb-5">
                    <div class="col-6">
                        <h2 class="text-primary fw-bold mb-1">OKRA IT</h2>
                        <p class="text-secondary mb-0">
                            Professional IT & Surveillance Systems provider<br>
                            18, Sayed Abul Hossain Sarak, Seikh Para Main Road, Khulna<br>
                            Mobile: +8801401-994575 | Email: okrait@yahoo.com
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <h1 class="text-uppercase fw-bold text-secondary mb-2" style="font-size: 2.2rem;">Quotation</h1>
                        <p class="mb-1 fw-bold text-dark">Quotation No: <span class="text-primary">{{ $quotation->quotation_no }}</span></p>
                        <p class="text-muted mb-0">Date: {{ $quotation->quotation_date->format('Y-m-d') }}</p>
                    </div>
                </div>

                <hr class="mb-4">

                <!-- Customer Details Grid -->
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h5 class="fw-bold text-secondary mb-2">QUOTED TO:</h5>
                        <h4 class="fw-bold text-dark mb-1">{{ $quotation->customer_name }}</h4>
                        @if($quotation->customer_address)
                            <p class="text-secondary mb-1"><strong>Address:</strong> {{ $quotation->customer_address }}</p>
                        @endif
                        <p class="text-secondary mb-0"><strong>Mobile:</strong> {{ $quotation->customer_mobile }}</p>
                    </div>
                    <!-- <div class="col-md-6 text-md-end">
                        <h5 class="fw-bold text-secondary mb-2">STATUS:</h5>
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6 fw-semibold">Generated</span>
                    </div> -->
                </div>

                <!-- Items Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">SL</th>
                                <th>Product Details</th>
                                <th class="text-center" style="width: 100px;">Qty</th>
                                <th class="text-end" style="width: 140px;">Unit Price</th>
                                <th class="text-end" style="width: 160px;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $item->product_name }}</div>
                                    @if($item->model)
                                    <code class="bg-light text-secondary px-2 py-0.5 rounded fw-bold small">{{ $item->model }}</code>
                                    @endif
                                </td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-end">{{ number_format($item->price, 2) }}</td>
                                <td class="text-end fw-bold text-dark">{{ number_format($item->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Financial Calculations Summary -->
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-secondary fw-semibold">Sub Total:</td>
                                    <td class="text-end fw-bold text-dark">{{ number_format($quotation->sub_total, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold text-danger">Discount:</td>
                                    <td class="text-end fw-bold text-danger">-{{ number_format($quotation->discount, 2) }}</td>
                                </tr>
                                <tr class="border-top border-dark">
                                    <td class="fs-5 fw-bold text-dark pt-2">Grand Total:</td>
                                    <td class="text-end fs-4 fw-bold text-success pt-2">Tk. {{ number_format($quotation->grand_total, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Notes & Terms -->
                @if($quotation->notes)
                <div class="row mt-5 pt-3 border-top">
                    <div class="col-12">
                        <h6 class="fw-bold text-secondary mb-2">Terms & Notes:</h6>
                        <p class="text-secondary mb-0" style="white-space: pre-line;">{{ $quotation->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Signature Section -->
                <div class="row mt-5 pt-5 text-center">
                    <div class="col-4 offset-8">
                        <div class="border-top border-dark pt-2">
                            <p class="fw-bold text-dark mb-0">Authorized Signature</p>
                            <p class="text-muted small mb-0">OKRA IT Operations</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- html2pdf JS Dependency -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        // Inject compact styles temporarily so html2canvas captures them
        const styleEl = document.createElement('style');
        styleEl.id = 'pdf-compact-styles';
        styleEl.textContent = `
            .print-container .card-body, .print-container .p-4, .print-container .p-md-5 { padding: 12px !important; }
            .print-container .mb-5 { margin-bottom: 8px !important; }
            .print-container .mb-4 { margin-bottom: 6px !important; }
            .print-container .mb-3 { margin-bottom: 5px !important; }
            .print-container .mb-2 { margin-bottom: 3px !important; }
            .print-container .mb-1 { margin-bottom: 2px !important; }
            .print-container .mt-5 { margin-top: 8px !important; }
            .print-container .pt-5 { padding-top: 8px !important; }
            .print-container .pt-3 { padding-top: 5px !important; }
            .print-container .pt-2 { padding-top: 3px !important; }
            .print-container h1 { font-size: 18px !important; margin-bottom: 4px !important; }
            .print-container h2 { font-size: 14px !important; margin-bottom: 4px !important; }
            .print-container h4 { font-size: 12px !important; margin-bottom: 3px !important; }
            .print-container h5 { font-size: 11px !important; margin-bottom: 3px !important; }
            .print-container h6 { font-size: 10px !important; margin-bottom: 2px !important; }
            .print-container p  { font-size: 10px !important; margin-bottom: 2px !important; line-height: 1.3 !important; }
            .print-container code { font-size: 9.5px !important; }
            .print-container .card, .print-container.shadow-sm { box-shadow: none !important; }
            .print-container .table { border-collapse: collapse !important; font-size: 10.5px !important; }
            .print-container .table th, .print-container .table td { border: 1px solid #adb5bd !important; padding: 3px 6px !important; vertical-align: middle !important; font-size: 10.5px !important; }
            .print-container .table thead th { background-color: #f8f9fa !important; font-weight: 700 !important; font-size: 10px !important; }
            .print-container .table-borderless th, .print-container .table-borderless td { border: none !important; padding: 2px 4px !important; font-size: 10.5px !important; }
            .print-container .badge { font-size: 10px !important; padding: 2px 6px !important; }
            .print-container hr { margin: 5px 0 !important; }
        `;
        document.head.appendChild(styleEl);

        const element = document.querySelector('.print-container');

        const opt = {
            margin:      [10, 12, 10, 12],
            filename:    'Quotation_{{ $quotation->quotation_no }}.pdf',
            image:       { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        html2pdf().set(opt).from(element).save().finally(() => {
            // Remove the temporary compact styles after PDF generation
            const injected = document.getElementById('pdf-compact-styles');
            if (injected) injected.remove();
        });
    }

    function printQuotation() {
        const printContents = document.querySelector('.print-container').innerHTML;

        // Collect all existing stylesheets from the page
        const links = Array.from(document.querySelectorAll('link[rel="stylesheet"]'))
            .map(link => `<link rel="stylesheet" href="${link.href}">`)
            .join('\n');

        const printWindow = window.open('', '_blank', 'width=900,height=700');
        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Quotation {{ $quotation->quotation_no }}</title>
                ${links}
                <style>
                    /* ── A4 compact layout: fits 10-15 line items ── */
                    * { box-sizing: border-box; }

                    @page {
                        size: A4 portrait;
                        margin: 10mm 12mm 10mm 12mm;

                        /* Remove browser-injected URL, title, date, page number */
                        @top-left   { content: none; }
                        @top-center { content: none; }
                        @top-right  { content: none; }
                        @bottom-left   { content: none; }
                        @bottom-center { content: none; }
                        @bottom-right  { content: none; }
                    }

                    body {
                        background: #fff !important;
                        color: #000 !important;
                        font-size: 11px !important;
                        line-height: 1.3 !important;
                        margin: 0 !important;
                        padding: 0 !important;
                    }

                    /* Shrink card padding */
                    .card-body {
                        padding: 12px !important;
                    }

                    /* Tighten header block */
                    .mb-5 { margin-bottom: 8px !important; }
                    .mb-4 { margin-bottom: 6px !important; }
                    .mb-3 { margin-bottom: 5px !important; }
                    .mb-2 { margin-bottom: 3px !important; }
                    .mb-1 { margin-bottom: 2px !important; }
                    .mt-5 { margin-top: 8px !important; }
                    .pt-5 { padding-top: 8px !important; }
                    .pt-3 { padding-top: 5px !important; }
                    .pt-2 { padding-top: 3px !important; }
                    .p-4, .p-md-5 { padding: 10px !important; }

                    /* Company name & quotation title */
                    h1 { font-size: 18px !important; margin-bottom: 4px !important; }
                    h2 { font-size: 14px !important; margin-bottom: 4px !important; }
                    h4 { font-size: 12px !important; margin-bottom: 3px !important; }
                    h5 { font-size: 11px !important; margin-bottom: 3px !important; }
                    h6 { font-size: 10px !important; margin-bottom: 2px !important; }
                    p  { font-size: 10px !important; margin-bottom: 2px !important; }

                    /* Items table — compact rows */
                    .table {
                        width: 100% !important;
                        border-collapse: collapse !important;
                        font-size: 10.5px !important;
                    }
                    .table th, .table td {
                        border: 1px solid #adb5bd !important;
                        padding: 3px 6px !important;
                        vertical-align: middle !important;
                    }
                    .table thead th {
                        background-color: #f8f9fa !important;
                        font-weight: 700 !important;
                        font-size: 10px !important;
                    }

                    /* Totals summary table */
                    .table-borderless th,
                    .table-borderless td {
                        border: none !important;
                        padding: 2px 4px !important;
                        font-size: 10.5px !important;
                    }

                    /* Signature row */
                    .row.mt-5.pt-5 {
                        margin-top: 10px !important;
                        padding-top: 5px !important;
                    }

                    /* Badge */
                    .badge { font-size: 10px !important; padding: 2px 6px !important; }

                    /* Remove shadows & borders from card */
                    .card, .shadow-sm {
                        box-shadow: none !important;
                        border: none !important;
                    }

                    /* code tag (model number) */
                    code { font-size: 9.5px !important; }

                    /* HR */
                    hr { margin: 5px 0 !important; }
                </style>
            </head>
            <body>
                ${printContents}
            </body>
            </html>
        `);
        printWindow.document.close();

        // Wait for stylesheets to load before printing
        printWindow.onload = function () {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        };
    }
</script>
@endsection
