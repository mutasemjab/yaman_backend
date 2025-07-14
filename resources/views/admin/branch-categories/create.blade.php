@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('messages.Add Categories and Products to Branch') }}</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('branch-categories.store') }}">
                        @csrf

                        <!-- Branch Selection -->
                        <div class="form-group mb-3">
                            <label for="branch_id" class="form-label">{{ __('messages.Select Branch') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('branch_id') is-invalid @enderror" 
                                    id="branch_id" 
                                    name="branch_id" 
                                    required>
                                <option value="">{{ __('messages.Choose Branch') }}</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}" 
                                            {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Categories Selection with Ordering -->
                        <div class="form-group mb-3">
                            <label for="categories" class="form-label">{{ __('messages.Select Categories') }} <span class="text-danger">*</span></label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> {{ __('messages.Drag categories to reorder them') }}
                            </div>
                            <div class="categories-container border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <ul id="sortable-categories" class="list-unstyled">
                                    @foreach($categories as $category)
                                        <li class="category-item border rounded p-2 mb-2 bg-light" data-category-id="{{ $category->id }}">
                                            <div class="form-check d-flex align-items-center">
                                                <i class="fas fa-grip-vertical text-muted me-2 drag-handle"></i>
                                                <input class="form-check-input category-checkbox me-2" 
                                                       type="checkbox" 
                                                       name="categories[]" 
                                                       value="{{ $category->id }}" 
                                                       id="category_{{ $category->id }}"
                                                       {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label flex-grow-1" for="category_{{ $category->id }}">
                                                    {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                                                    <small class="text-muted">({{ $category->products->count() }} {{ __('messages.products') }})</small>
                                                </label>
                                                <span class="order-number badge bg-primary ms-2">1</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @error('categories')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Products Selection with Ordering -->
                        <div class="form-group mb-3">
                            <label for="products" class="form-label">{{ __('messages.Select Products') }} <small class="text-muted">({{ __('messages.optional') }})</small></label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> {{ __('messages.Drag products to reorder them within each category') }}
                            </div>
                            <div class="products-container border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <div id="products-list">
                                    <p class="text-muted">{{ __('messages.Select categories first to see products') }}</p>
                                </div>
                            </div>
                            @error('products')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Hidden inputs for ordering -->
                        <div id="category-order-inputs"></div>
                        <div id="product-order-inputs"></div>

                        <!-- Submit Buttons -->
                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('branch-categories.index') }}" class="btn btn-secondary">
                                {{ __('messages.Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ __('messages.Save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const productsContainer = document.getElementById('products-list');
    const categoryOrderContainer = document.getElementById('category-order-inputs');
    const productOrderContainer = document.getElementById('product-order-inputs');
    
    // All products grouped by category
    const allProducts = @json($products->groupBy('category_id'));
    
    // Initialize category sorting
    const categoryList = document.getElementById('sortable-categories');
    const categorySortable = new Sortable(categoryList, {
        handle: '.drag-handle',
        animation: 150,
        onUpdate: function() {
            updateCategoryOrder();
        }
    });
    
    function updateCategoryOrder() {
        const categoryItems = document.querySelectorAll('.category-item');
        
        // Clear existing hidden inputs
        categoryOrderContainer.innerHTML = '';
        
        categoryItems.forEach((item, index) => {
            const categoryId = item.getAttribute('data-category-id');
            const checkbox = item.querySelector('.category-checkbox');
            const order = index + 1;
            
            // Update order number display
            const orderBadge = item.querySelector('.order-number');
            orderBadge.textContent = order;
            
            // Only create hidden input if category is checked
            if (checkbox && checkbox.checked) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `category_order[${categoryId}]`;
                hiddenInput.value = order;
                categoryOrderContainer.appendChild(hiddenInput);
            }
        });
    }
    
    function updateProductsList() {
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        productsContainer.innerHTML = '';
        
        if (selectedCategories.length === 0) {
            productsContainer.innerHTML = '<p class="text-muted">{{ __('messages.Select categories first to see products') }}</p>';
            return;
        }
        
        // Get categories in order
        const categoryItems = document.querySelectorAll('.category-item');
        const orderedCategories = [];
        
        categoryItems.forEach(item => {
            const categoryId = item.getAttribute('data-category-id');
            if (selectedCategories.includes(categoryId)) {
                orderedCategories.push(categoryId);
            }
        });
        
        orderedCategories.forEach(categoryId => {
            if (allProducts[categoryId]) {
                const categoryName = document.querySelector(`#category_${categoryId} + label`).textContent.split('(')[0].trim();
                
                const categoryDiv = document.createElement('div');
                categoryDiv.className = 'mb-3';
                categoryDiv.innerHTML = `
                    <h6 class="text-primary border-bottom pb-2">${categoryName}</h6>
                    <ul class="list-unstyled sortable-products" data-category-id="${categoryId}">
                        ${allProducts[categoryId].map(product => `
                            <li class="product-item border rounded p-2 mb-2 bg-light" data-product-id="${product.id}">
                                <div class="form-check d-flex align-items-center">
                                    <i class="fas fa-grip-vertical text-muted me-2 drag-handle"></i>
                                    <input class="form-check-input product-checkbox me-2" 
                                           type="checkbox" 
                                           name="products[]" 
                                           value="${product.id}" 
                                           id="product_${product.id}">
                                    <label class="form-check-label flex-grow-1" for="product_${product.id}">
                                        {{ app()->getLocale() === 'ar' ? '${product.name_ar}' : '${product.name_en}' }}
                                        <small class="text-muted d-block">{{ __('messages.Price') }}: ${product.selling_price}</small>
                                    </label>
                                    <span class="order-number badge bg-secondary ms-2">1</span>
                                </div>
                            </li>
                        `).join('')}
                    </ul>
                `;
                
                productsContainer.appendChild(categoryDiv);
            }
        });
        
        // Initialize product sorting for each category
        initializeProductSorting();
    }
    
    function initializeProductSorting() {
        const productLists = document.querySelectorAll('.sortable-products');
        
        productLists.forEach(list => {
            new Sortable(list, {
                handle: '.drag-handle',
                animation: 150,
                onUpdate: function() {
                    updateProductOrder();
                }
            });
        });
        
        updateProductOrder();
    }
    
    function updateProductOrder() {
        // Clear existing hidden inputs
        productOrderContainer.innerHTML = '';
        
        document.querySelectorAll('.sortable-products').forEach(list => {
            const productItems = list.querySelectorAll('.product-item');
            
            productItems.forEach((item, index) => {
                const productId = item.getAttribute('data-product-id');
                const checkbox = item.querySelector('.product-checkbox');
                const order = index + 1;
                
                // Update order number display
                const orderBadge = item.querySelector('.order-number');
                orderBadge.textContent = order;
                
                // Only create hidden input if product is checked
                if (checkbox && checkbox.checked) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `product_order[${productId}]`;
                    hiddenInput.value = order;
                    productOrderContainer.appendChild(hiddenInput);
                }
            });
        });
    }
    
    // Add event listeners to category checkboxes
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateProductsList();
            updateCategoryOrder(); // Update order when checkbox changes
        });
    });
    
    // Listen for product checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox')) {
            updateProductOrder(); // Update order when product checkbox changes
        }
    });
    
    // Initialize
    updateCategoryOrder();
    updateProductsList();
});
</script>

<style>
.categories-container, .products-container {
    background-color: #f8f9fa;
}

.form-check-input:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-check-label {
    font-weight: 500;
    cursor: pointer;
}

.text-primary {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 5px;
}

.drag-handle {
    cursor: grab;
}

.drag-handle:active {
    cursor: grabbing;
}

.category-item, .product-item {
    transition: all 0.3s ease;
}

.category-item:hover, .product-item:hover {
    background-color: #e9ecef !important;
}

.sortable-ghost {
    opacity: 0.4;
}

.order-number {
    min-width: 25px;
    text-align: center;
}

.alert-info {
    border-left: 4px solid #007bff;
}

.fas {
    color: #007bff;
}
</style>
@endsection