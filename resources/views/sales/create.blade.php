@extends('layouts.adminlte')

@section('title', 'New Sale / Invoice')
@section('page-title', 'New Sale / Invoice')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        /* Customer mode badge */
        #customer-mode-badge {
            font-size: 0.72rem;
            letter-spacing: 0.04em;
        }
        /* Lock icon on auto-filled fields */
        .field-autofilled {
            background-color: #f0f7ff !important;
            border-color: #86b7fe !important;
        }
    </style>
@endsection

@section('content')
<form action="{{ route('sales.store') }}" method="POST" id="sale-form">
    @csrf
    
    @if($quotation)
        <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
        <div class="alert alert-info border-0 shadow-sm rounded-3 mb-4">
            <i class="bi bi-info-circle-fill me-2"></i> Converting Quotation <strong>{{ $quotation->quotation_no }}</strong> into a Final Sale.
        </div>
    @endif

    <div class="row">
        <!-- Customer Info Card -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title text-dark mb-0"><i class="bi bi-person-badge me-2 text-primary"></i>Customer Information</h5>
                </div>
                <div class="card-body">
                    <!-- Mode toggle row -->
                    <div class="col-12 mb-3 d-flex align-items-center gap-2">
                        <span class="fw-bold text-secondary small">Mode:</span>
                        <span id="customer-mode-badge" class="badge bg-primary">Search Existing Customer</span>
                        <button type="button" id="btn-new-customer" class="btn btn-sm btn-outline-success ms-auto">
                            <i class="bi bi-person-plus me-1"></i> New Customer
                        </button>
                        <button type="button" id="btn-search-customer" class="btn btn-sm btn-outline-primary d-none">
                            <i class="bi bi-search me-1"></i> Search Existing
                        </button>
                    </div>

                    <!-- SEARCH MODE: Select2 AJAX mobile lookup -->
                    <div id="search-mode-fields" class="row">
                        <!-- Mobile Search -->
                        <div class="col-md-4 mb-3">
                            <label for="mobile_search" class="form-label fw-bold">Search by Mobile</label>
                            <select id="mobile_search" class="form-select" style="width:100%">
                                <option value=""></option>
                                @if($quotation && $quotation->customer_mobile)
                                    <option value="{{ $quotation->customer_mobile }}" selected>{{ $quotation->customer_mobile }}</option>
                                @endif
                            </select>
                            <small class="text-muted">Type mobile digits to search past customers</small>
                        </div>

                        <!-- Name (auto-filled, still editable) -->
                        <div class="col-md-4 mb-3">
                            <label for="customer_name" class="form-label fw-bold">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name" id="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror {{ $quotation ? '' : 'field-autofilled' }}"
                                   placeholder="Auto-filled on selection" value="{{ old('customer_name', $quotation->customer_name ?? '') }}" required {{ $quotation ? '' : 'readonly' }}>
                            @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Invoice No -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Invoice No (Auto)</label>
                            <input type="text" name="invoice_no" class="form-control bg-light fw-bold text-secondary" placeholder="Auto-generated if blank">
                        </div>

                        <!-- Address (auto-filled, still editable) -->
                        <div class="col-md-8 mb-3">
                            <label for="customer_address" class="form-label fw-bold">Customer Address</label>
                            <textarea name="customer_address" id="customer_address" rows="1"
                                      class="form-control @error('customer_address') is-invalid @enderror {{ $quotation ? '' : 'field-autofilled' }}"
                                      placeholder="Auto-filled on selection" {{ $quotation ? '' : 'readonly' }}>{{ old('customer_address', $quotation->customer_address ?? '') }}</textarea>
                            @error('customer_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hidden mobile field (submitted with form) -->
                        <input type="hidden" name="customer_mobile" id="customer_mobile" value="{{ old('customer_mobile', $quotation->customer_mobile ?? '') }}">

                        <!-- Sale Date -->
                        <div class="col-md-4 mb-3">
                            <label for="sale_date" class="form-label fw-bold">Sale Date <span class="text-danger">*</span></label>
                            <input type="date" name="sale_date" id="sale_date"
                                   class="form-control @error('sale_date') is-invalid @enderror"
                                   value="{{ old('sale_date', date('Y-m-d')) }}" required>
                            @error('sale_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- NEW CUSTOMER MODE: plain editable fields -->
                    <div id="new-mode-fields" class="row d-none">
                        <!-- Customer Name -->
                        <div class="col-md-4 mb-3">
                            <label for="new_customer_name" class="form-label fw-bold">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" id="new_customer_name"
                                   class="form-control" placeholder="e.g. John Doe">
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-4 mb-3">
                            <label for="new_customer_mobile" class="form-label fw-bold">Customer Mobile <span class="text-danger">*</span></label>
                            <input type="text" id="new_customer_mobile"
                                   class="form-control" placeholder="e.g. 017XXXXXXXX">
                        </div>

                        <!-- Invoice No -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Invoice No (Auto)</label>
                            <input type="text" class="form-control bg-light fw-bold text-secondary" placeholder="Auto-generated if blank" readonly>
                        </div>

                        <!-- Address -->
                        <div class="col-md-8 mb-3">
                            <label for="new_customer_address" class="form-label fw-bold">Customer Address</label>
                            <textarea id="new_customer_address" rows="1"
                                      class="form-control" placeholder="e.g. Road-1, Sector-3, Uttara, Dhaka"></textarea>
                        </div>

                        <!-- Sale Date -->
                        <div class="col-md-4 mb-3">
                            <label for="sale_date_new" class="form-label fw-bold">Sale Date <span class="text-danger">*</span></label>
                            <input type="date" id="sale_date_new"
                                   class="form-control"
                                   value="{{ old('sale_date', date('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Selector and Items Grid -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-dark mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Sale Items</h5>
                </div>
                
                <div class="card-body">
                    <!-- Product Dropdown Row -->
                    <div class="row align-items-end mb-4">
                        <div class="col-md-9 mb-3 mb-md-0">
                            <label for="product_select" class="form-label fw-bold">Select Product</label>
                            <select id="product_select" class="form-select select2">
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-name="{{ $product->name }}" 
                                        data-model="{{ $product->model }}" 
                                        data-price="{{ $product->selling_price }}"
                                        data-brand="{{ $product->brand->name ?? 'No Brand' }}">
                                    {{ $product->name }}{{ $product->model ? ' · ' . $product->model : '' }} ({{ $product->brand->name ?? 'No Brand' }}) — {{ number_format($product->selling_price, 2) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="add-item-btn" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle me-1"></i> Add Item
                            </button>
                        </div>
                    </div>

                    <!-- Items Grid Table -->
                    <div class="table-responsive">
                        <table class="table align-middle" id="items-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">SL</th>
                                    <th>Product Name</th>
                                    <th style="width: 150px;">Team Member</th>
                                    <th style="width: 90px;">Qty</th>
                                    <th style="width: 120px;">Price (Tk.)</th>
                                    <th class="text-end" style="width: 120px;">Total (Tk.)</th>
                                    <th class="text-end" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                                <!-- Pre-fill quotation items if any -->
                                @if($quotation && $quotation->items)
                                    @foreach($quotation->items as $i => $item)
                                    <tr data-product-id="{{ $item->product_id }}">
                                        <td class="sl-cell fw-bold text-secondary">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <input type="hidden" name="items[{{ $i }}][product_id]" value="{{ $item->product_id }}">
                                        </td>
                                        <td>
                                            <select name="items[{{ $i }}][location_id]" class="form-select form-select-sm" required>
                                                <option value="">-- Select --</option>
                                                @foreach($locations as $loc)
                                                    <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $i }}][quantity]" class="form-control form-control-sm quantity-input" min="1" value="{{ $item->quantity }}" required>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" name="items[{{ $i }}][unit_price]" class="form-control form-control-sm price-input" min="0" value="{{ $item->price }}" required>
                                        </td>
                                        <td class="text-end fw-bold text-dark fs-6">
                                            Tk. <span class="row-total">{{ number_format($item->total, 2) }}</span>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr id="no-items-row">
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-cart-x fs-2 d-block mb-2"></i>
                                            No items added. Select a product above and click "Add Item".
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary & Actions Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Financial Summary</h5>
                    </div>
                    <div class="card-body">
                        <!-- Grand Total Row -->
                        <div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded mb-4">
                            <span class="fs-6 fw-bold text-secondary">Grand Total:</span>
                            <span class="fs-3 fw-bold text-success">Tk. <span id="grand-total-span">0.00</span></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-success">Amount Paid Now (Tk.) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control form-control-lg fw-bold text-success" value="0" min="0" required>
                            <small class="text-muted mt-1 d-block">This adds to Revenue in financial reports.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank Transfer</option>
                                <option value="Mobile Banking">Mobile Banking (bKash/Nagad)</option>
                            </select>
                        </div>

                        <!-- Notes Field -->
                        <div class="mt-4">
                            <label for="notes" class="form-label fw-bold text-secondary">Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Add payment terms, valid date, or delivery details..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top py-3 d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-save me-1"></i> Finalize Sale
                    </button>
                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary w-100">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Store locations data in JS to populate dynamically -->
<script>
    const locationsList = @json($locations);
</script>
@endsection

@section('scripts')
<!-- jQuery and Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    // ─── Customer Lookup ──────────────────────────────────────────────────────
    const SEARCH_URL = '{{ route("customers.search") }}';

    // Hidden real form fields (always submitted)
    const $hMobile  = $('#customer_mobile');
    const $hName    = $('#customer_name');
    const $hAddress = $('#customer_address');
    const $hDate    = $('#sale_date');

    // New-customer UI fields
    const $newName    = $('#new_customer_name');
    const $newMobile  = $('#new_customer_mobile');
    const $newAddress = $('#new_customer_address');
    const $newDate    = $('#sale_date_new');

    // Init Select2 AJAX for mobile search
    $('#mobile_search').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search by mobile...',
        allowClear: true,
        ajax: {
            url: SEARCH_URL,
            dataType: 'json',
            delay: 300,
            data: params => ({ search_query: params.term || '' }),
            processResults: data => ({
                results: (data || []).map(c => ({
                    id: c.mobile,
                    text: c.mobile + ' — ' + c.name,
                    name: c.name,
                    address: c.address
                }))
            }),
            cache: false
        }
    });

    // When a customer is selected from the dropdown
    $('#mobile_search').on('select2:select', function(e) {
        const d = e.params.data;
        $hMobile.val(d.id);
        $hName.val(d.name).removeClass('is-invalid');
        $hAddress.val(d.address);
        $hName.addClass('field-autofilled');
        $hAddress.addClass('field-autofilled');
        $hName.prop('readonly', false);
        $hAddress.prop('readonly', false);
    });

    // When the selection is cleared
    $('#mobile_search').on('select2:clear', function() {
        $hMobile.val('');
        $hName.val('').prop('readonly', true).removeClass('field-autofilled');
        $hAddress.val('').prop('readonly', true).removeClass('field-autofilled');
    });

    // Switch to New Customer mode
    $('#btn-new-customer').on('click', function() {
        $('#search-mode-fields').addClass('d-none');
        $('#new-mode-fields').removeClass('d-none');
        $('#customer-mode-badge').text('New Customer').removeClass('bg-primary').addClass('bg-success');
        $('#btn-new-customer').addClass('d-none');
        $('#btn-search-customer').removeClass('d-none');

        // Clear hidden fields so validation doesn't use stale data
        $hMobile.val('');
        $hName.val('');
        $hAddress.val('');

        // Sync new-mode date with hidden date
        $newDate.val($hDate.val());
        $newName.focus();
    });

    // Switch back to Search mode
    $('#btn-search-customer').on('click', function() {
        $('#new-mode-fields').addClass('d-none');
        $('#search-mode-fields').removeClass('d-none');
        $('#customer-mode-badge').text('Search Existing Customer').removeClass('bg-success').addClass('bg-primary');
        $('#btn-search-customer').addClass('d-none');
        $('#btn-new-customer').removeClass('d-none');

        // Clear new-mode inputs
        $newName.val(''); $newMobile.val(''); $newAddress.val('');

        // Reset hidden fields
        $hMobile.val('');
        $hName.val('').prop('readonly', true).addClass('field-autofilled');
        $hAddress.val('').prop('readonly', true).addClass('field-autofilled');
        $('#mobile_search').val(null).trigger('change');
    });

    // Keep hidden form fields in sync with new-customer inputs
    $newName.on('input',    () => $hName.val($newName.val()));
    $newMobile.on('input',  () => $hMobile.val($newMobile.val()));
    $newAddress.on('input', () => $hAddress.val($newAddress.val()));
    $newDate.on('change',   () => $hDate.val($newDate.val()));

    // Form submit guard
    $('#sale-form').on('submit', function(e) {
        const isNewMode = !$('#new-mode-fields').hasClass('d-none');

        if (isNewMode) {
            $hName.val($newName.val());
            $hMobile.val($newMobile.val());
            $hAddress.val($newAddress.val());
            $hDate.val($newDate.val());
        }

        if (!$hMobile.val().trim() || !$hName.val().trim()) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Customer Required',
                text: isNewMode
                    ? 'Please fill in the Customer Name and Mobile.'
                    : 'Please search and select a customer first, or switch to New Customer mode.',
                confirmButtonColor: '#0d6efd'
            });
            return;
        }

        const rowCount = document.querySelectorAll('#items-tbody tr:not(#no-items-row)').length;
        if (rowCount === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'No Items Added',
                text: 'Please add at least one product before saving.'
            });
        }
    });

    // ─── Product Select2 & Items Logic ────────────────────────────────────────
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    const addItemBtn = document.getElementById("add-item-btn");
    const itemsTbody = document.getElementById("items-tbody");
    const noItemsRow = document.getElementById("no-items-row");
    const grandTotalSpan = document.getElementById("grand-total-span");

    let itemIndex = {{ $quotation ? count($quotation->items) : 0 }};

    // Helper: generate options for locations
    let locationOptions = '<option value="">-- Select --</option>';
    locationsList.forEach(loc => {
        locationOptions += `<option value="${loc.id}">${loc.name}</option>`;
    });

    addItemBtn.addEventListener("click", function() {
        const selectedOpt = $('#product_select').find(':selected')[0];
        if (!selectedOpt.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Select a Product',
                text: 'Please choose a product from the list before adding.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        const productId = selectedOpt.value;
        const productName = selectedOpt.getAttribute("data-name");
        const productModel = selectedOpt.getAttribute("data-model") || "";
        const productPrice = parseFloat(selectedOpt.getAttribute("data-price")) || 0;

        // Check if product is already added
        const existingRow = document.querySelector(`tr[data-product-id="${productId}"]`);
        if (existingRow) {
            const qtyInput = existingRow.querySelector(".quantity-input");
            qtyInput.value = parseInt(qtyInput.value) + 1;
            triggerEvent(qtyInput, "input");
            
            // Clear selection
            $('#product_select').val('').trigger('change');
            return;
        }

        // Hide empty row
        if (noItemsRow) {
            noItemsRow.style.display = "none";
        }

        // Insert new product row
        const newRow = document.createElement("tr");
        newRow.setAttribute("data-product-id", productId);
        newRow.innerHTML = `
            <td class="sl-cell fw-bold text-secondary"></td>
            <td>
                <div class="fw-bold">${productName}</div>
                <input type="hidden" name="items[${itemIndex}][product_id]" value="${productId}">
            </td>
            <td>
                <select name="items[${itemIndex}][location_id]" class="form-select form-select-sm" required>
                    ${locationOptions}
                </select>
            </td>
            <td>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control form-control-sm quantity-input" min="1" value="1" required>
            </td>
            <td>
                <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control form-control-sm price-input" min="0" value="${productPrice.toFixed(2)}" required>
            </td>
            <td class="text-end fw-bold text-dark fs-6">
                Tk. <span class="row-total">${productPrice.toFixed(2)}</span>
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        `;

        itemsTbody.appendChild(newRow);
        itemIndex++;

        $('#product_select').val('').trigger('change');

        bindRowEvents(newRow);
        updateSerialNumbers();
        updateTotals();
    });

    function triggerEvent(el, type) {
        const e = document.createEvent("HTMLEvents");
        e.initEvent(type, true, true);
        el.dispatchEvent(e);
    }

    function bindRowEvents(row) {
        const qtyInput = row.querySelector(".quantity-input");
        const priceInput = row.querySelector(".price-input");
        const rowTotalSpan = row.querySelector(".row-total");
        const removeBtn = row.querySelector(".remove-row-btn");

        const recalculateRow = () => {
            const qty = parseInt(qtyInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const total = qty * price;
            rowTotalSpan.textContent = total.toFixed(2);
            updateTotals();
        };

        qtyInput.addEventListener("input", recalculateRow);
        priceInput.addEventListener("input", recalculateRow);

        removeBtn.addEventListener("click", function() {
            row.remove();
            updateSerialNumbers();
            updateTotals();
            
            if (document.querySelectorAll("#items-tbody tr:not(#no-items-row)").length === 0) {
                if (noItemsRow) noItemsRow.style.display = "";
            }
        });
    }

    function updateSerialNumbers() {
        const rows = document.querySelectorAll("#items-tbody tr:not(#no-items-row)");
        rows.forEach((row, i) => {
            row.querySelector(".sl-cell").textContent = i + 1;
        });
    }

    function updateTotals() {
        const rows = document.querySelectorAll("#items-tbody tr:not(#no-items-row)");
        let subTotal = 0;

        rows.forEach(row => {
            const qty = parseInt(row.querySelector(".quantity-input").value) || 0;
            const price = parseFloat(row.querySelector(".price-input").value) || 0;
            subTotal += qty * price;
        });

        grandTotalSpan.textContent = subTotal.toLocaleString('en-BD', {minimumFractionDigits:2, maximumFractionDigits:2});
    }

    // Bind pre-existing quotation rows
    document.querySelectorAll("#items-tbody tr:not(#no-items-row)").forEach(row => {
        bindRowEvents(row);
    });

    updateTotals();
    updateSerialNumbers();
});
</script>
@endsection
