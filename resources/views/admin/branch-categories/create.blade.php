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

                        <!-- Categories Selection -->
                        <div class="form-group mb-3">
                            <label for="categories" class="form-label">{{ __('messages.Select Categories') }} <span class="text-danger">*</span></label>
                            <div class="categories-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                @foreach($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-checkbox" 
                                               type="checkbox" 
                                               name="categories[]" 
                                               value="{{ $category->id }}" 
                                               id="category_{{ $category->id }}"
                                               {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en }}
                                            <small class="text-muted">({{ $category->products->count() }} {{ __('messages.products') }})</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Products Selection -->
                        <div class="form-group mb-3">
                            <label for="products" class="form-label">{{ __('messages.Select Products') }} <small class="text-muted">({{ __('messages.optional') }})</small></label>
                            <div class="products-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
    const productsContainer = document.getElementById('products-list');
    
    // All products grouped by category
    const allProducts = @json($products->groupBy('category_id'));
    
    function updateProductsList() {
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        productsContainer.innerHTML = '';
        
        if (selectedCategories.length === 0) {
            productsContainer.innerHTML = '<p class="text-muted">{{ __('messages.Select categories first to see products') }}</p>';
            return;
        }
        
        selectedCategories.forEach(categoryId => {
            if (allProducts[categoryId]) {
                const categoryName = document.querySelector(`#category_${categoryId} + label`).textContent.split('(')[0].trim();
                
                const categoryDiv = document.createElement('div');
                categoryDiv.className = 'mb-3';
                categoryDiv.innerHTML = `
                    <h6 class="text-primary">${categoryName}</h6>
                    <div class="ms-3">
                        ${allProducts[categoryId].map(product => `
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="products[]" 
                                       value="${product.id}" 
                                       id="product_${product.id}">
                                <label class="form-check-label" for="product_${product.id}">
                                    {{ app()->getLocale() === 'ar' ? '${product.name_ar}' : '${product.name_en}' }}
                                    <small class="text-muted">({{ __('messages.Price') }}: ${product.selling_price})</small>
                                </label>
                            </div>
                        `).join('')}
                    </div>
                `;
                
                productsContainer.appendChild(categoryDiv);
            }
        });
    }
    
    // Add event listeners to category checkboxes
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateProductsList);
    });
    
    // Initial load
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
}

.text-primary {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 5px;
}

.ms-3 {
    margin-left: 1rem;
}
</style>
@endsection