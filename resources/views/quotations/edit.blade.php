@extends('layouts.adminlte')

@section('title', 'Edit Quotation')
@section('page-title', 'Edit Quotation')

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
        /* Tint on auto-filled fields */
        .field-autofilled {
            background-color: #f0f7ff !important;
            border-color: #86b7fe !important;
        }
    </style>
@endsection

@section('content')
<form action="{{ route('quotations.update', $quotation->id) }}" method="POST" id="quotation-form">
    @csrf
    @method('PATCH')
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
                        <span id="customer-mode-badge" class="badge bg-primary">Existing Customer</span>
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
                                {{-- Pre-load the existing customer as the selected option --}}
                                <option value="{{ $quotation->customer_mobile }}"
                                        data-name="{{ $quotation->customer_name }}"
                                        data-address="{{ $quotation->customer_address }}"
                                        selected>
                                    {{ $quotation->customer_mobile }} — {{ $quotation->customer_name }}
                                </option>
                            </select>
                            <small class="text-muted">Type mobile digits to search or change customer</small>
                        </div>

                        <!-- Name (auto-filled, still editable) -->
                        <div class="col-md-4 mb-3">
                            <label for="customer_name" class="form-label fw-bold">Customer Name</label>
                            <input type="text" name="customer_name" id="customer_name"
                                   class="form-control @error('customer_name') is-invalid @enderror field-autofilled"
                                   value="{{ old('customer_name', $quotation->customer_name) }}" required>
                            @error('customer_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Quotation No -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Quotation No</label>
                            <input type="text" class="form-control bg-light fw-bold text-secondary" value="{{ $quotation->quotation_no }}" readonly>
                        </div>

                        <!-- Address (auto-filled, still editable) -->
                        <div class="col-md-8 mb-3">
                            <label for="customer_address" class="form-label fw-bold">Customer Address</label>
                            <textarea name="customer_address" id="customer_address" rows="1"
                                      class="form-control @error('customer_address') is-invalid @enderror field-autofilled">{{ old('customer_address', $quotation->customer_address) }}</textarea>
                            @error('customer_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Hidden mobile field (submitted with form) -->
                        <input type="hidden" name="customer_mobile" id="customer_mobile"
                               value="{{ old('customer_mobile', $quotation->customer_mobile) }}">

                        <!-- Quotation Date -->
                        <div class="col-md-4 mb-3">
                            <label for="quotation_date" class="form-label fw-bold">Quotation Date</label>
                            <input type="date" name="quotation_date" id="quotation_date"
                                   class="form-control @error('quotation_date') is-invalid @enderror"
                                   value="{{ old('quotation_date', $quotation->quotation_date->format('Y-m-d')) }}" required>
                            @error('quotation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- NEW CUSTOMER MODE: plain editable fields -->
                    <div id="new-mode-fields" class="row d-none">
                        <!-- Customer Name -->
                        <div class="col-md-4 mb-3">
                            <label for="new_customer_name" class="form-label fw-bold">Customer Name</label>
                            <input type="text" id="new_customer_name"
                                   class="form-control" placeholder="e.g. John Doe">
                        </div>

                        <!-- Mobile -->
                        <div class="col-md-4 mb-3">
                            <label for="new_customer_mobile" class="form-label fw-bold">Customer Mobile</label>
                            <input type="text" id="new_customer_mobile"
                                   class="form-control" placeholder="e.g. 017XXXXXXXX">
                        </div>

                        <!-- Quotation No -->
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Quotation No</label>
                            <input type="text" class="form-control bg-light fw-bold text-secondary" value="{{ $quotation->quotation_no }}" readonly>
                        </div>

                        <!-- Address -->
                        <div class="col-md-8 mb-3">
                            <label for="new_customer_address" class="form-label fw-bold">Customer Address</label>
                            <textarea id="new_customer_address" rows="1"
                                      class="form-control" placeholder="e.g. Road-1, Sector-3, Uttara, Dhaka"></textarea>
                        </div>

                        <!-- Quotation Date -->
                        <div class="col-md-4 mb-3">
                            <label for="quotation_date_new" class="form-label fw-bold">Quotation Date</label>
                            <input type="date" id="quotation_date_new"
                                   class="form-control"
                                   value="{{ old('quotation_date', $quotation->quotation_date->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Selector and Items Grid -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-dark mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Quotation Items</h5>
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
                                        data-price="{{ $product->quotation_price }}"
                                        data-brand="{{ $product->brand->name }}">
                                    {{ $product->name }}{{ $product->model ? ' · ' . $product->model : '' }} ({{ $product->brand->name }}) — {{ number_format($product->quotation_price, 2) }}
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
                                    <th style="width: 120px;">Qty</th>
                                    <th style="width: 140px;">Price (tk)</th>
                                    <th class="text-end" style="width: 140px;">Total (tk)</th>
                                    <th class="text-end" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                                @php
                                    $itemIndex = 0;
                                @endphp
                                @foreach($quotation->items as $item)
                                <tr data-product-id="{{ $item->product_id }}">
                                    <td class="sl-cell fw-bold text-secondary">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $item->product_name }}</div>
                                        @if($item->model)
                                        <code class="bg-light text-secondary px-2 py-0.5 rounded fw-bold small">{{ $item->model }}</code>
                                        @endif
                                        <input type="hidden" name="items[{{ $itemIndex }}][product_id]" value="{{ $item->product_id }}">
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $itemIndex }}][quantity]" class="form-control quantity-input" min="1" value="{{ $item->quantity }}" required style="width: 90px;">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" step="0.01" name="items[{{ $itemIndex }}][price]" class="form-control price-input" min="0" value="{{ number_format($item->price, 2, '.', '') }}" required>
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold text-dark fs-6">
                                        $<span class="row-total">{{ number_format($item->total, 2, '.', '') }}</span>
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @php
                                    $itemIndex++;
                                @endphp
                                @endforeach

                                <tr id="no-items-row" style="{{ $quotation->items->count() > 0 ? 'display: none;' : '' }}">
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-cart-x fs-2 d-block mb-2"></i>
                                        No items added. Select a product above and click "Add Item".
                                    </td>
                                </tr>
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
                        <!-- Sub Total Row -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary fw-semibold">Sub Total:</span>
                            <span class="fs-5 fw-bold text-dark">tk<span id="sub-total-span">{{ number_format($quotation->sub_total, 2, '.', '') }}</span></span>
                        </div>

                        <!-- Discount Row -->
                        <div class="mb-4">
                            <label for="discount" class="form-label fw-bold text-secondary">Discount (tk)</label>
                            <div class="input-group">
                                <span class="input-group-text">tk</span>
                                <input type="number" step="0.01" min="0" name="discount" id="discount" class="form-control form-control-lg fw-bold text-danger" value="{{ number_format($quotation->discount, 2, '.', '') }}" required>
                            </div>
                            @error('discount')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Grand Total Row -->
                        <div class="d-flex justify-content-between align-items-center mt-3 p-3 bg-light rounded">
                            <span class="fs-6 fw-bold text-secondary">Grand Total:</span>
                            <span class="fs-3 fw-bold text-success">tk<span id="grand-total-span">{{ number_format($quotation->grand_total, 2, '.', '') }}</span></span>
                        </div>

                        <!-- Notes Field -->
                        <div class="mt-4">
                            <label for="notes" class="form-label fw-bold text-secondary">Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Add payment terms, valid date, or delivery details...">{{ $quotation->notes }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top py-3 d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-save me-1"></i> Update Quotation
                    </button>
                    <a href="{{ route('quotations.index') }}" class="btn btn-outline-secondary w-100">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
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
    const $hDate    = $('#quotation_date');

    // New-customer UI fields
    const $newName    = $('#new_customer_name');
    const $newMobile  = $('#new_customer_mobile');
    const $newAddress = $('#new_customer_address');
    const $newDate    = $('#quotation_date_new');

    // Init Select2 AJAX for mobile search (existing customer pre-selected)
    $('#mobile_search').select2({
        theme: 'bootstrap-5',
        placeholder: 'Type mobile number…',
        allowClear: true,
        minimumInputLength: 1,
        ajax: {
            url: SEARCH_URL,
            dataType: 'json',
            delay: 300,
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(c => ({
                    id:      c.mobile,
                    text:    c.mobile + ' — ' + c.name,
                    name:    c.name,
                    address: c.address
                }))
            }),
            cache: true
        }
    });

    // When a customer is selected/changed in the dropdown
    $('#mobile_search').on('select2:select', function(e) {
        const d = e.params.data;
        $hMobile.val(d.id);
        $hName.val(d.name || d.text).removeClass('is-invalid');
        $hAddress.val(d.address || '');
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

        $hMobile.val('');
        $hName.val('');
        $hAddress.val('');
        $newDate.val($hDate.val());
        $newName.focus();
    });

    // Switch back to Search mode
    $('#btn-search-customer').on('click', function() {
        $('#new-mode-fields').addClass('d-none');
        $('#search-mode-fields').removeClass('d-none');
        $('#customer-mode-badge').text('Existing Customer').removeClass('bg-success').addClass('bg-primary');
        $('#btn-search-customer').addClass('d-none');
        $('#btn-new-customer').removeClass('d-none');

        $newName.val(''); $newMobile.val(''); $newAddress.val('');

        // Restore the original customer mobile from the hidden field default
        $hMobile.val('{{ old("customer_mobile", $quotation->customer_mobile) }}');
        $hName.val('{{ old("customer_name", $quotation->customer_name) }}').prop('readonly', false).addClass('field-autofilled');
        $hAddress.val('{{ old("customer_address", $quotation->customer_address) }}').prop('readonly', false).addClass('field-autofilled');
    });

    // Keep hidden form fields in sync with new-customer inputs
    $newName.on('input',    () => $hName.val($newName.val()));
    $newMobile.on('input',  () => $hMobile.val($newMobile.val()));
    $newAddress.on('input', () => $hAddress.val($newAddress.val()));
    $newDate.on('change',   () => $hDate.val($newDate.val()));

    // Form submit guard
    $('#quotation-form').on('submit', function(e) {
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
                    : 'Please search and select a customer, or switch to New Customer mode.',
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
                text: 'Please add at least one product before saving the quotation.'
            });
        }
    });

    // ─── Product Select2 ─────────────────────────────────────────────────────
    $('#product_select').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Choose Product --',
        allowClear: true
    });

    // ─── Items table ──────────────────────────────────────────────────────────
    $(document).ready(function() {

        const productSelect = document.getElementById("product_select");
        const addItemBtn = document.getElementById("add-item-btn");
        const itemsTbody = document.getElementById("items-tbody");
        const noItemsRow = document.getElementById("no-items-row");
        const subTotalSpan = document.getElementById("sub-total-span");
        const discountInput = document.getElementById("discount");
        const grandTotalSpan = document.getElementById("grand-total-span");
        const quotationForm = document.getElementById("quotation-form");

        let itemIndex = {{ $itemIndex }};

        // Bind events to pre-existing rows on load
        document.querySelectorAll("#items-tbody tr:not(#no-items-row)").forEach(function(row) {
            bindRowEvents(row);
        });

        // Add Product Row
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
            const productBrand = selectedOpt.getAttribute("data-brand") || "";

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
                    ${productModel ? `<code class="bg-light text-secondary px-2 py-0.5 rounded fw-bold small">${productModel}</code> ` : ''}
                    <span class="badge bg-secondary">${productBrand}</span>
                    <input type="hidden" name="items[${itemIndex}][product_id]" value="${productId}">
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity-input" min="1" value="1" required style="width: 90px;">
                </td>
                <td>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" name="items[${itemIndex}][price]" class="form-control price-input" min="0" value="${productPrice.toFixed(2)}" required>
                    </div>
                </td>
                <td class="text-end fw-bold text-dark fs-6">
                    $<span class="row-total">${productPrice.toFixed(2)}</span>
                </td>
                <td class="text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;

            itemsTbody.appendChild(newRow);
            itemIndex++;

            // Clear select option
            $('#product_select').val('').trigger('change');

            // Bind calculations & removal events
            bindRowEvents(newRow);
            updateSerialNumbers();
            updateTotals();
        });

        // Trigger manual event helper
        function triggerEvent(el, type) {
            const e = document.createEvent("HTMLEvents");
            e.initEvent(type, true, true);
            el.dispatchEvent(e);
        }

        // Bind events to a single row
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
                
                // Show empty row if no items left
                if (document.querySelectorAll("#items-tbody tr:not(#no-items-row)").length === 0) {
                    noItemsRow.style.display = "";
                }
            });
        }

        // Update SL column counts
        function updateSerialNumbers() {
            const rows = document.querySelectorAll("#items-tbody tr:not(#no-items-row)");
            rows.forEach((row, i) => {
                row.querySelector(".sl-cell").textContent = i + 1;
            });
        }

        // Update overall Sub Total, Discount, and Grand Total
        function updateTotals() {
            const rows = document.querySelectorAll("#items-tbody tr:not(#no-items-row)");
            let subTotal = 0;

            rows.forEach(row => {
                const qty = parseInt(row.querySelector(".quantity-input").value) || 0;
                const price = parseFloat(row.querySelector(".price-input").value) || 0;
                subTotal += qty * price;
            });

            const discount = parseFloat(discountInput.value) || 0;
            const grandTotal = Math.max(0, subTotal - discount);

            subTotalSpan.textContent = subTotal.toFixed(2);
            grandTotalSpan.textContent = grandTotal.toFixed(2);
        }

        discountInput.addEventListener("input", updateTotals);

        // Form submit handled by the jQuery block above
    });
});
</script>
@endsection
