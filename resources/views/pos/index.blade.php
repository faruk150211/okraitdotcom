@extends('layouts.adminlte')

@section('title', 'Point of Sale (POS)')
@section('page-title', 'Point of Sale')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .qty-input { width: 80px; }
    </style>
@endsection

@section('content')
<form action="{{ route('pos.checkout') }}" method="POST" id="pos-form">
    @csrf
    <input type="hidden" name="cart" id="cartPayload" value="[]">
    
    <div class="row">
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
                            <i class="bi bi-person-plus me-1"></i> Walk-in / New Customer
                        </button>
                        <button type="button" id="btn-search-customer" class="btn btn-sm btn-outline-primary d-none">
                            <i class="bi bi-search me-1"></i> Search Existing
                        </button>
                    </div>

                    <!-- SEARCH MODE: Select2 AJAX mobile lookup -->
                    <div id="search-mode-fields" class="row">
                        <div class="col-md-6 mb-3">
                            <label for="mobile_search" class="form-label fw-bold">Search by Mobile (Optional)</label>
                            <select id="mobile_search" class="form-select" style="width:100%"></select>
                            <small class="text-muted">Type mobile digits to search past customers</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Customer Name</label>
                            <input type="text" id="display_customer_name" class="form-control bg-light" placeholder="Auto-filled on selection" readonly>
                        </div>
                    </div>

                    <!-- NEW CUSTOMER MODE: plain editable fields -->
                    <div id="new-mode-fields" class="row d-none">
                        <div class="col-md-6 mb-3">
                            <label for="new_customer_mobile" class="form-label fw-bold">Customer Mobile (Optional)</label>
                            <input type="text" id="new_customer_mobile" class="form-control" placeholder="e.g. 017XXXXXXXX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="new_customer_name" class="form-label fw-bold">Customer Name</label>
                            <input type="text" id="new_customer_name" class="form-control" placeholder="Walk-in Customer">
                        </div>
                    </div>

                    <!-- Hidden fields submitted with the form -->
                    <input type="hidden" name="customer_mobile" id="customer_mobile">
                    <input type="hidden" name="customer_name" id="customer_name">
                </div>
            </div>
        </div>

        <!-- Product Selector and Items Grid -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title text-dark mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Cart Items</h5>
                </div>
                <div class="card-body">
                    <!-- Product Dropdown Row -->
                    <div class="row align-items-end mb-4">
                        <div class="col-md-9 mb-3 mb-md-0">
                            <label for="product_select" class="form-label fw-bold">Select Product</label>
                            <select id="product_select" class="form-select">
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-name="{{ $product->name }}" 
                                        data-model="{{ $product->model }}" 
                                        data-price="{{ $product->selling_price }}">
                                    {{ $product->name }} {{ $product->model ? '- ' . $product->model : '' }} — Tk. {{ number_format($product->selling_price, 2) }}
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
                                    <th style="width: 200px;">Team Member</th>
                                    <th style="width: 100px;">Qty</th>
                                    <th style="width: 130px;">Price (tk)</th>
                                    <th class="text-end" style="width: 120px;">Total (tk)</th>
                                    <th class="text-end" style="width: 60px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                                <tr id="no-items-row">
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x fs-2 d-block mb-2"></i>
                                        No items in cart. Select a product above.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary & Checkout Card -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100 d-flex flex-column justify-content-between">
                <div>
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title text-dark mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Checkout</h5>
                    </div>
                    <div class="card-body">
                        <!-- Sub Total Row -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary fw-semibold">Sub Total:</span>
                            <span class="fs-5 fw-bold text-dark">Tk. <span id="sub-total-span">0.00</span></span>
                        </div>

                        <!-- Grand Total Row -->
                        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded">
                            <span class="fs-6 fw-bold text-secondary">Payable:</span>
                            <span class="fs-3 fw-bold text-success">Tk. <span id="grand-total-span">0.00</span></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Amount Paid (Tk.)</label>
                            <input type="number" name="paid_amount" id="paid_amount" class="form-control form-control-lg fw-bold text-success" value="0.00" min="0" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <select name="payment_method" class="form-select">
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank/Card</option>
                                <option value="Mobile Banking">bKash/Nagad</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top py-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> Complete Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Store locations data for dynamic rows -->
<script>
    const availableLocations = @json($locations);
</script>

@if(session('print_sale_id'))
<script>
    window.open("{{ route('sales.show', session('print_sale_id')) }}?print=true", "_blank", "width=800,height=600");
</script>
@endif

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // ─── Customer Lookup ──────────────────────────────────────────────────────
    const SEARCH_URL = '{{ route("customers.search") }}';

    // Hidden real form fields
    const $hMobile  = $('#customer_mobile');
    const $hName    = $('#customer_name');
    
    // Display fields for Search mode
    const $displayName = $('#display_customer_name');

    // New-customer fields
    const $newName   = $('#new_customer_name');
    const $newMobile = $('#new_customer_mobile');

    // Init Select2 AJAX
    $('#mobile_search').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search by mobile...',
        allowClear: true,
        ajax: {
            url: SEARCH_URL,
            dataType: 'json',
            delay: 300,
            data: params => ({ q: params.term || '' }),
            processResults: data => ({
                results: (data || []).map(c => ({
                    id: c.mobile,
                    text: c.mobile + ' — ' + c.name,
                    name: c.name
                }))
            }),
            cache: false
        }
    });

    $('#mobile_search').on('select2:select', function(e) {
        const d = e.params.data;
        $hMobile.val(d.id);
        $hName.val(d.name);
        $displayName.val(d.name);
    });

    $('#mobile_search').on('select2:clear', function() {
        $hMobile.val('');
        $hName.val('');
        $displayName.val('');
    });

    // Toggle Modes
    $('#btn-new-customer').on('click', function() {
        $('#search-mode-fields').addClass('d-none');
        $('#new-mode-fields').removeClass('d-none');
        $('#customer-mode-badge').text('Walk-in / New Customer').removeClass('bg-primary').addClass('bg-success');
        $('#btn-new-customer').addClass('d-none');
        $('#btn-search-customer').removeClass('d-none');

        // Clear search data
        $('#mobile_search').val(null).trigger('change');
        $displayName.val('');
        
        // Sync hidden with new-mode inputs (they might be blank initially)
        $hMobile.val($newMobile.val());
        $hName.val($newName.val());
    });

    $('#btn-search-customer').on('click', function() {
        $('#new-mode-fields').addClass('d-none');
        $('#search-mode-fields').removeClass('d-none');
        $('#customer-mode-badge').text('Search Existing Customer').removeClass('bg-success').addClass('bg-primary');
        $('#btn-search-customer').addClass('d-none');
        $('#btn-new-customer').removeClass('d-none');

        // Clear new-mode data
        $newMobile.val('');
        $newName.val('');

        // Sync hidden with search data (blank initially on switch)
        $hMobile.val('');
        $hName.val('');
    });

    // Keep hidden fields updated when typing in New Customer mode
    $newMobile.on('input', () => $hMobile.val($newMobile.val()));
    $newName.on('input',   () => $hName.val($newName.val()));

    // Product Selector
    $('#product_select').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Choose Product --',
        allowClear: true
    });

    const addItemBtn = document.getElementById("add-item-btn");
    const itemsTbody = document.getElementById("items-tbody");
    const noItemsRow = document.getElementById("no-items-row");
    
    // Generate location options HTML
    let locationOptionsHtml = '<option value="">-- Select Team Member --</option>';
    availableLocations.forEach(loc => {
        locationOptionsHtml += `<option value="${loc.id}">${loc.name}</option>`;
    });

    let itemIndex = 0;

    addItemBtn.addEventListener("click", function() {
        const selectedOpt = $('#product_select').find(':selected')[0];
        if (!selectedOpt || !selectedOpt.value) {
            Swal.fire({
                icon: 'warning',
                title: 'Select a Product',
                text: 'Please choose a product from the list.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        const productId = selectedOpt.value;
        const productName = selectedOpt.getAttribute("data-name");
        const productPrice = parseFloat(selectedOpt.getAttribute("data-price")) || 0;

        // Check if already added
        const existingRow = document.querySelector(`tr[data-product-id="${productId}"]`);
        if (existingRow) {
            const qtyInput = existingRow.querySelector(".qty-input");
            qtyInput.value = parseInt(qtyInput.value) + 1;
            triggerEvent(qtyInput, "input");
            $('#product_select').val('').trigger('change');
            return;
        }

        if (noItemsRow) noItemsRow.style.display = "none";

        const newRow = document.createElement("tr");
        newRow.setAttribute("data-product-id", productId);
        newRow.setAttribute("data-price", productPrice);
        newRow.innerHTML = `
            <td class="sl-cell fw-bold text-secondary"></td>
            <td class="fw-bold text-dark">${productName}</td>
            <td>
                <select class="form-select form-select-sm location-select" style="width:100%" required>
                    ${locationOptionsHtml}
                </select>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm qty-input" min="1" value="1" required>
            </td>
            <td class="text-secondary">
                Tk. ${productPrice.toFixed(2)}
            </td>
            <td class="text-end fw-bold text-dark">
                Tk. <span class="row-total">${productPrice.toFixed(2)}</span>
            </td>
            <td class="text-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn"><i class="bi bi-trash"></i></button>
            </td>
        `;

        itemsTbody.appendChild(newRow);
        itemIndex++;
        $('#product_select').val('').trigger('change');

        // Apply Select2 to the new location dropdown
        $(newRow.querySelector('.location-select')).select2({ theme: 'bootstrap-5' });

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
        const qtyInput = row.querySelector(".qty-input");
        const rowTotalSpan = row.querySelector(".row-total");
        const removeBtn = row.querySelector(".remove-row-btn");
        const price = parseFloat(row.getAttribute("data-price"));

        qtyInput.addEventListener("input", () => {
            const qty = parseInt(qtyInput.value) || 0;
            rowTotalSpan.textContent = (qty * price).toFixed(2);
            updateTotals();
        });

        removeBtn.addEventListener("click", () => {
            $(row.querySelector('.location-select')).select2('destroy');
            row.remove();
            updateSerialNumbers();
            updateTotals();
            if (document.querySelectorAll("#items-tbody tr:not(#no-items-row)").length === 0) {
                noItemsRow.style.display = "";
            }
        });
    }

    function updateSerialNumbers() {
        document.querySelectorAll("#items-tbody tr:not(#no-items-row)").forEach((row, i) => {
            row.querySelector(".sl-cell").textContent = i + 1;
        });
    }

    function updateTotals() {
        let total = 0;
        document.querySelectorAll("#items-tbody tr:not(#no-items-row)").forEach(row => {
            const qty = parseInt(row.querySelector(".qty-input").value) || 0;
            const price = parseFloat(row.getAttribute("data-price"));
            total += qty * price;
        });

        $('#sub-total-span').text(total.toFixed(2));
        $('#grand-total-span').text(total.toFixed(2));
        $('#paid_amount').val(total.toFixed(2)); // Auto-fill paid amount
    }

    $('#pos-form').on('submit', function(e) {
        const rows = document.querySelectorAll("#items-tbody tr:not(#no-items-row)");
        if (rows.length === 0) {
            e.preventDefault();
            Swal.fire('Empty Cart', 'Please add at least one product.', 'error');
            return;
        }

        let cartData = [];
        let missingLocation = false;

        rows.forEach(row => {
            const id = row.getAttribute("data-product-id");
            const price = parseFloat(row.getAttribute("data-price"));
            const qty = parseInt(row.querySelector(".qty-input").value);
            const location_id = row.querySelector(".location-select").value;

            if (!location_id) missingLocation = true;

            cartData.push({
                id: id,
                price: price,
                quantity: qty,
                location_id: location_id
            });
        });

        if (missingLocation) {
            e.preventDefault();
            Swal.fire('Team Member Required', 'Please assign a Team Member for every product in the cart.', 'warning');
            return;
        }

        $('#cartPayload').val(JSON.stringify(cartData));
    });
});
</script>
@endsection
