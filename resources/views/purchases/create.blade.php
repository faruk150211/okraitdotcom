@extends('layouts.adminlte')

@section('title', 'New Purchase')
@section('page-title', 'New Purchase')

@section('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endsection

@section('content')
<form action="{{ route('purchases.store') }}" method="POST" id="purchaseForm">
    @csrf
    <div class="row">
        <!-- Supplier & Purchase Details Card -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title text-dark mb-0"><i class="bi bi-truck me-2 text-primary"></i>Purchase Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Supplier -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Supplier <span class="text-danger">*</span></label>
                            <select name="supplier_id" class="form-select select2" required>
                                <option value="">-- Select Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Location -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Receive To (Location) <span class="text-danger">*</span></label>
                            <select name="location_id" class="form-select select2" required>
                                <option value="">-- Select Team Member / Storage --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Ref -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Reference / Invoice No.</label>
                            <input type="text" name="reference_no" class="form-control" placeholder="e.g. INV-2023-01">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Selector and Items Grid -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-dark mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Purchase Items</h5>
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
                                        data-price="{{ $product->base_price }}"
                                        data-brand="{{ $product->brand->name ?? 'No Brand' }}">
                                    {{ $product->name }}{{ $product->model ? ' · ' . $product->model : '' }} ({{ $product->brand->name ?? 'No Brand' }})
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
                                    <th style="width: 140px;">Unit Price (Tk.)</th>
                                    <th class="text-end" style="width: 140px;">Total (Tk.)</th>
                                    <th class="text-end" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                                <tr id="no-items-row">
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
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <span class="fs-6 fw-bold text-secondary">Grand Total:</span>
                            <span class="fs-4 fw-bold text-dark">Tk. <span id="grand-total-span">0.00</span></span>
                        </div>

                        <!-- Paid Amount -->
                        <div class="mb-4 mt-4">
                            <label for="paid_amount" class="form-label fw-bold text-success">Amount Paid Now (Tk.) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-success-subtle text-success border-success">Tk.</span>
                                <input type="number" step="0.01" min="0" name="paid_amount" id="paid_amount" class="form-control form-control-lg fw-bold border-success text-success" value="0.00" required>
                            </div>
                            <small class="text-muted mt-1 d-block">This will be recorded as an Expense.</small>
                        </div>

                        <!-- Notes Field -->
                        <div class="mt-4">
                            <label for="notes" class="form-label fw-bold text-secondary">Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Additional details about this purchase..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white border-top py-3 d-flex flex-column gap-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-save me-1"></i> Confirm Purchase
                    </button>
                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary w-100">Cancel</a>
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

    // Initialize Select2 for all generic selects
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    const productSelect = document.getElementById("product_select");
    const addItemBtn = document.getElementById("add-item-btn");
    const itemsTbody = document.getElementById("items-tbody");
    const noItemsRow = document.getElementById("no-items-row");
    const grandTotalSpan = document.getElementById("grand-total-span");

    let itemIndex = 0;

    // Form submit guard
    $('#purchaseForm').on('submit', function(e) {
        const rowCount = document.querySelectorAll('#items-tbody tr:not(#no-items-row)').length;
        if (rowCount === 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'No Items Added',
                text: 'Please add at least one product before confirming the purchase.'
            });
        }
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
                    <input type="number" step="0.01" name="items[${itemIndex}][unit_price]" class="form-control price-input" min="0" value="${productPrice.toFixed(2)}" required>
                </div>
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

    // Update overall Grand Total
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

});
</script>
@endsection
