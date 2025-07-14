@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('messages.Edit Branch Categories') }}: {{ $branch->name }}</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('branch-categories.update', $branch->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Branch Information -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong>{{ __('messages.Branch') }}:</strong> {{ $branch->name }}<br>
                                    <small>{{ __('messages.Address') }}: {{ $branch->address }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Categories Selection with Ordering -->
                        <div class="form-group mb-4">
                            <label class="form-label h6">{{ __('messages.Select Categories') }}</label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> {{ __('messages.Drag categories to reorder them') }}
                            </div>
                            <div class="categories-container border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <ul id="sortable-categories" class="list-unstyled">
                                    @foreach($allCategories as $category)
                                        <li class="category-item border rounded p-2 mb-2 bg-light" data-category-id="{{ $category->id }}">
                                            <div class="form-check d-flex align-items-center">
                                                <i class="fas fa-grip-vertical text-muted me-2 drag-handle"></i>
                                                <input class="form-check-input category-checkbox me-2" 
                                                       type="checkbox" 
                                                       name="categories[]" 
                                                       value="{{ $category->id }}" 
                                                       id="category_{{ $category->id }}"
                                                       {{ in_array($category->id, $assignedCategories) ? 'checked' : '' }}>
                                                <label class="form-check-label flex-grow-1" for="category_{{ $category->id }}">
                                                    {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                                                    <small class="text-muted">({{ $category->products->count() }} {{ __('messages.products') }})</small>
                                                </label>
                                                <span class="order-number badge bg-primary ms-2">{{ $categoryOrders[$category->id] ?? 0 }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                
                                <!-- Select All / Deselect All -->
                                <div class="mt-3 border-top pt-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="selectAllCategories">
                                        {{ __('messages.Select All') }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllCategories">
                                        {{ __('messages.Deselect All') }}
                                    </button>
                                </div>
                            </div>
                            @error('categories')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Products Selection with Ordering -->
                        <div class="form-group mb-4">
                            <label class="form-label h6">{{ __('messages.Select Products') }} <small class="text-muted">({{ __('messages.optional') }})</small></label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> {{ __('messages.Drag products to reorder them within each category') }}
                            </div>
                            <div class="products-container border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <div id="products-list">
                                    <!-- Products will be loaded here via JavaScript -->
                                </div>
                                
                                <!-- Select All / Deselect All for Products -->
                                <div class="mt-3 border-top pt-3" id="productControls" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="selectAllProducts">
                                        {{ __('messages.Select All Products') }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllProducts">
                                        {{ __('messages.Deselect All Products') }}
                                    </button>
                                </div>
                            </div>
                            @error('products')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Assignments Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('messages.Current Categories') }}</h6>
                                        <div id="currentCategoriesCount">{{ count($assignedCategories) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ __('messages.Current Products') }}</h6>
                                        <div id="currentProductsCount">{{ count($assignedProducts) }}</div>
                                    </div>
                                </div>
                            </div>
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
                                {{ __('messages.Update') }}
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
    const productControls = document.getElementById('productControls');
    const selectAllCategories = document.getElementById('selectAllCategories');
    const deselectAllCategories = document.getElementById('deselectAllCategories');
    const selectAllProducts = document.getElementById('selectAllProducts');
    const deselectAllProducts = document.getElementById('deselectAllProducts');
    const currentCategoriesCount = document.getElementById('currentCategoriesCount');
    const currentProductsCount = document.getElementById('currentProductsCount');
    const categoryOrderContainer = document.getElementById('category-order-inputs');
    const productOrderContainer = document.getElementById('product-order-inputs');
    
    // All products grouped by category
    const allProducts = @json($allProducts->groupBy('category_id'));
    const assignedProducts = @json($assignedProducts);
    const productOrders = @json($productOrders ?? []);
    
    // Initialize category sorting
    const categoryList = document.getElementById('sortable-categories');
    const categorySortable = new Sortable(categoryList, {
        handle: '.drag-handle',
        animation: 150,
        onUpdate: function() {
            updateCategoryOrder();
        }
    });
    
    // Sort categories by their current order on page load
    sortCategoriesByOrder();
    
    function sortCategoriesByOrder() {
        const categoryItems = Array.from(document.querySelectorAll('.category-item'));
        categoryItems.sort((a, b) => {
            const orderA = parseInt(a.querySelector('.order-number').textContent) || 0;
            const orderB = parseInt(b.querySelector('.order-number').textContent) || 0;
            return orderA - orderB;
        });
        
        categoryItems.forEach(item => {
            categoryList.appendChild(item);
        });
        
        updateCategoryOrder();
    }
    
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
            productControls.style.display = 'none';
            return;
        }
        
        productControls.style.display = 'block';
        
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
                
                // Sort products by their saved order
                let categoryProducts = [...allProducts[categoryId]];
                categoryProducts.sort((a, b) => {
                    const orderA = productOrders[a.id] || 0;
                    const orderB = productOrders[b.id] || 0;
                    return orderA - orderB;
                });
                
                categoryDiv.innerHTML = `
                    <h6 class="text-primary border-bottom pb-2">${categoryName}</h6>
                    <ul class="list-unstyled sortable-products" data-category-id="${categoryId}">
                        ${categoryProducts.map((product, index) => `
                            <li class="product-item border rounded p-2 mb-2 bg-light" data-product-id="${product.id}">
                                <div class="form-check d-flex align-items-center">
                                    <i class="fas fa-grip-vertical text-muted me-2 drag-handle"></i>
                                    <input class="form-check-input product-checkbox me-2" 
                                           type="checkbox" 
                                           name="products[]" 
                                           value="${product.id}" 
                                           id="product_${product.id}"
                                           ${assignedProducts.includes(product.id) ? 'checked' : ''}>
                                    <label class="form-check-label flex-grow-1" for="product_${product.id}">
                                        {{ app()->getLocale() === 'ar' ? '${product.name_ar}' : '${product.name_en}' }}
                                        <small class="text-success d-block">{{ __('messages.Price') }}: ${product.selling_price}</small>
                                    </label>
                                    <span class="order-number badge bg-secondary ms-2">${productOrders[product.id] || (index + 1)}</span>
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
        updateCounts();
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
        
        updateCounts();
    }
    
    function updateCounts() {
        const selectedCategories = document.querySelectorAll('.category-checkbox:checked').length;
        const selectedProducts = document.querySelectorAll('.product-checkbox:checked').length;
        
        currentCategoriesCount.textContent = selectedCategories;
        currentProductsCount.textContent = selectedProducts;
    }
    
    // Category checkbox event listeners
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateProductsList();
            updateCategoryOrder(); // Update order when checkbox changes
        });
    });
    
    // Select/Deselect all categories
    selectAllCategories.addEventListener('click', function() {
        categoryCheckboxes.forEach(cb => cb.checked = true);
        updateProductsList();
        updateCategoryOrder(); // Update order after selecting all
    });
    
    deselectAllCategories.addEventListener('click', function() {
        categoryCheckboxes.forEach(cb => cb.checked = false);
        updateProductsList();
        updateCategoryOrder(); // Update order after deselecting all
    });
    
    // Select/Deselect all products
    selectAllProducts.addEventListener('click', function() {
        document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = true);
        updateProductOrder(); // Update order after selecting all
    });
    
    deselectAllProducts.addEventListener('click', function() {
        document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
        updateProductOrder(); // Update order after deselecting all
    });
    
    // Listen for product checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox')) {
            updateProductOrder(); // Update order when product checkbox changes
        }
    });
    
    // Initial load
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
    color: #007bff !important;
}

.card.bg-light {
    background-color: #e9ecef !important;
}

.card-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
}

.alert-info {
    border-left: 4px solid #007bff;
}

.fas {
    color: #007bff;
}

#currentCategoriesCount, #currentProductsCount {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
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
</style>
@endsection