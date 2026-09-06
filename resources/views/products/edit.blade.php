@extends('layouts.adminlte')

@section('title', 'Edit Product')
@section('page-title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-lg-10">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="card-title text-dark mb-0">Product Information</h5>
            </div>
            
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="card-body row">
                    <!-- Name Input -->
                    <div class="col-md-4 mb-3">
                        <label for="name" class="form-label fw-bold">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. ThinkPad X1 Carbon" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug Input -->
                    <div class="col-md-4 mb-3">
                        <label for="slug" class="form-label fw-bold">Slug (SEO URL)</label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="e.g. thinkpad-x1-carbon" value="{{ old('slug', $product->slug) }}" required>
                        @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Model Input -->
                    <div class="col-md-4 mb-3">
                        <label for="model" class="form-label fw-bold">Model (Optional)</label>
                        <input type="text" name="model" id="model" class="form-control @error('model') is-invalid @enderror" placeholder="e.g. DS-2CD2043G2-I" value="{{ old('model', $product->model) }}">
                        @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Brand Input -->
                    <div class="col-md-6 mb-3">
                        <label for="brand_id" class="form-label fw-bold">Brand</label>
                        <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category Input -->
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label fw-bold">Category</label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" placeholder="Search category...">
                            <option value="">Select Category (Optional)</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Base Price -->
                    <div class="col-md-4 mb-3">
                        <label for="base_price" class="form-label fw-bold">Base Price ($)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" name="base_price" id="base_price" class="form-control @error('base_price') is-invalid @enderror" placeholder="e.g. 800.00" value="{{ old('base_price', $product->base_price) }}" required>
                            @error('base_price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Selling Price -->
                    <div class="col-md-4 mb-3">
                        <label for="selling_price" class="form-label fw-bold">Selling Price ($)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" name="selling_price" id="selling_price" class="form-control @error('selling_price') is-invalid @enderror" placeholder="e.g. 1000.00" value="{{ old('selling_price', $product->selling_price) }}" required>
                            @error('selling_price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Quotation Price -->
                    <div class="col-md-4 mb-3">
                        <label for="quotation_price" class="form-label fw-bold">Quotation Price ($)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" name="quotation_price" id="quotation_price" class="form-control @error('quotation_price') is-invalid @enderror" placeholder="e.g. 950.00" value="{{ old('quotation_price', $product->quotation_price) }}" required>
                            @error('quotation_price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description Input -->
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="Describe the product specifications...">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Specifications -->
                    <div class="col-12 mt-2">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold mb-0">
                                <i class="bi bi-list-check me-1 text-primary"></i> Specifications
                            </label>
                            <button type="button" id="add-spec-btn" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i> Add Specification
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle mb-0" id="specs-table">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%">Label</th>
                                        <th>Value</th>
                                        <th style="width: 60px;" class="text-center">Remove</th>
                                    </tr>
                                </thead>
                                <tbody id="specs-body">
                                    <!-- Rows added by JS -->
                                </tbody>
                            </table>
                        </div>
                        <p class="text-muted small mt-1 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Add any label–value pairs e.g. Brand → Hikvision, Usage → Outdoor
                        </p>
                    </div>

                    <!-- FAQs -->
                    <div class="col-12 mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-bold mb-0">
                                <i class="bi bi-question-circle me-1 text-warning"></i> Frequently Asked Questions (FAQ)
                            </label>
                            <button type="button" id="add-faq-btn" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-plus-circle me-1"></i> Add FAQ
                            </button>
                        </div>
                        <div id="faqs-container">
                            <!-- FAQ cards added by JS -->
                        </div>
                        <p class="text-muted small mt-1 mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            e.g. Q: What is the resolution? A: 2MP Full HD
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-white border-top py-3 d-flex justify-content-end gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Tom Select -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
<style>
    .ck-editor__editable_inline {
        min-height: 250px;
    }

    /* Tom Select tweaks */
    .ts-wrapper.single .ts-control {
        padding: 0.375rem 2.5rem 0.375rem 0.75rem;
        font-size: 1rem;
        border-radius: 0.375rem;
    }
    .ts-wrapper.single.input-active .ts-control,
    .ts-wrapper.single .ts-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, .25);
    }
    .ts-wrapper .ts-dropdown {
        border-radius: 0.375rem;
        font-size: 0.9rem;
    }
    .ts-wrapper.is-invalid .ts-control {
        border-color: #dc3545;
    }
</style>
@endsection

@section('scripts')
<!-- Tom Select -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Searchable category select
        new TomSelect('#category_id', {
            placeholder: 'Search category...',
            allowEmptyOption: true,
            maxOptions: null,
        });

        const nameInput = document.getElementById("name");
        const slugInput = document.getElementById("slug");

        nameInput.addEventListener("input", function() {
            const slugValue = nameInput.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, "") // Remove non-word chars
                .replace(/[\s_-]+/g, "-") // Replace spaces/underscores with single dash
                .replace(/^-+|-+$/g, ""); // Trim leading/trailing dashes
            slugInput.value = slugValue;
        });

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });

        // ── Specifications dynamic rows ──
        let specIndex = 0;

        function addSpecRow(label = '', value = '') {
            const tbody = document.getElementById('specs-body');
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <input type="text" name="specs[${specIndex}][label]"
                           class="form-control form-control-sm"
                           placeholder="e.g. Brand, Usage, Resolution"
                           value="${label.replace(/"/g, '&quot;')}" required>
                </td>
                <td>
                    <input type="text" name="specs[${specIndex}][value]"
                           class="form-control form-control-sm"
                           placeholder="e.g. Hikvision, Outdoor, 2MP"
                           value="${value.replace(/"/g, '&quot;')}">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-spec-btn" title="Remove">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(tr);
            tr.querySelector('.remove-spec-btn').addEventListener('click', () => tr.remove());
            specIndex++;
        }

        document.getElementById('add-spec-btn').addEventListener('click', () => addSpecRow());

        // Pre-fill existing specifications from database
        const existingSpecs = @json($product->specifications->map(fn($s) => ['label' => $s->label, 'value' => $s->value]));
        if (existingSpecs.length > 0) {
            existingSpecs.forEach(spec => addSpecRow(spec.label, spec.value));
        } else {
            addSpecRow(); // one blank row if no specs exist
        }

        // ── FAQ dynamic blocks ──
        let faqIndex = 0;

        function addFaqBlock(question = '', answer = '') {
            const container = document.getElementById('faqs-container');
            const div = document.createElement('div');
            div.className = 'card border mb-2';
            div.innerHTML = `
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="fw-semibold small text-warning"><i class="bi bi-question-circle me-1"></i>FAQ #${faqIndex + 1}</span>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-faq-btn" title="Remove">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                    <div class="mb-2">
                        <input type="text" name="faqs[${faqIndex}][question]"
                               class="form-control form-control-sm"
                               placeholder="Question e.g. What is the IR range?"
                               value="${question.replace(/"/g, '&quot;')}" required>
                    </div>
                    <div>
                        <textarea name="faqs[${faqIndex}][answer]"
                                  class="form-control form-control-sm" rows="2"
                                  placeholder="Answer e.g. Up to 60 metres in complete darkness">${answer}</textarea>
                    </div>
                </div>
            `;
            container.appendChild(div);
            div.querySelector('.remove-faq-btn').addEventListener('click', () => div.remove());
            faqIndex++;
        }

        document.getElementById('add-faq-btn').addEventListener('click', () => addFaqBlock());

        // Pre-fill existing FAQs from database
        const existingFaqs = @json($product->faqs->map(fn($f) => ['question' => $f->question, 'answer' => $f->answer]));
        if (existingFaqs.length > 0) {
            existingFaqs.forEach(faq => addFaqBlock(faq.question, faq.answer));
        }
    });
</script>
@endsection
