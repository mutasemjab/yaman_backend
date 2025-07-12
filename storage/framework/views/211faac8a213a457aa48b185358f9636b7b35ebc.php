

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('messages.Edit Branch Categories')); ?>: <?php echo e($branch->name); ?></h5>
                </div>
                <div class="card-body">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('branch-categories.update', $branch->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Branch Information -->
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <div>
                                    <strong><?php echo e(__('messages.Branch')); ?>:</strong> <?php echo e($branch->name); ?><br>
                                    <small><?php echo e(__('messages.Address')); ?>: <?php echo e($branch->address); ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- Categories Selection -->
                        <div class="form-group mb-4">
                            <label class="form-label h6"><?php echo e(__('messages.Select Categories')); ?></label>
                            <div class="categories-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="row">
                                    <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-6 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input category-checkbox" 
                                                       type="checkbox" 
                                                       name="categories[]" 
                                                       value="<?php echo e($category->id); ?>" 
                                                       id="category_<?php echo e($category->id); ?>"
                                                       <?php echo e(in_array($category->id, $assignedCategories) ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="category_<?php echo e($category->id); ?>">
                                                    <?php echo e(app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en); ?>

                                                    <small class="text-muted">(<?php echo e($category->products->count()); ?> <?php echo e(__('messages.products')); ?>)</small>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                
                                <!-- Select All / Deselect All -->
                                <div class="mt-3 border-top pt-3">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="selectAllCategories">
                                        <?php echo e(__('messages.Select All')); ?>

                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllCategories">
                                        <?php echo e(__('messages.Deselect All')); ?>

                                    </button>
                                </div>
                            </div>
                            <?php $__errorArgs = ['categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Products Selection -->
                        <div class="form-group mb-4">
                            <label class="form-label h6"><?php echo e(__('messages.Select Products')); ?> <small class="text-muted">(<?php echo e(__('messages.optional')); ?>)</small></label>
                            <div class="products-container border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                                <div id="products-list">
                                    <!-- Products will be loaded here via JavaScript -->
                                </div>
                                
                                <!-- Select All / Deselect All for Products -->
                                <div class="mt-3 border-top pt-3" id="productControls" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-outline-primary me-2" id="selectAllProducts">
                                        <?php echo e(__('messages.Select All Products')); ?>

                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllProducts">
                                        <?php echo e(__('messages.Deselect All Products')); ?>

                                    </button>
                                </div>
                            </div>
                            <?php $__errorArgs = ['products'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Current Assignments Summary -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo e(__('messages.Current Categories')); ?></h6>
                                        <div id="currentCategoriesCount"><?php echo e(count($assignedCategories)); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title"><?php echo e(__('messages.Current Products')); ?></h6>
                                        <div id="currentProductsCount"><?php echo e(count($assignedProducts)); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group d-flex justify-content-between">
                            <a href="<?php echo e(route('branch-categories.index')); ?>" class="btn btn-secondary">
                                <?php echo e(__('messages.Cancel')); ?>

                            </a>
                            <button type="submit" class="btn btn-primary">
                                <?php echo e(__('messages.Update')); ?>

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
    const productControls = document.getElementById('productControls');
    const selectAllCategories = document.getElementById('selectAllCategories');
    const deselectAllCategories = document.getElementById('deselectAllCategories');
    const selectAllProducts = document.getElementById('selectAllProducts');
    const deselectAllProducts = document.getElementById('deselectAllProducts');
    const currentCategoriesCount = document.getElementById('currentCategoriesCount');
    const currentProductsCount = document.getElementById('currentProductsCount');
    
    // All products grouped by category
    const allProducts = <?php echo json_encode($allProducts->groupBy('category_id'), 15, 512) ?>;
    const assignedProducts = <?php echo json_encode($assignedProducts, 15, 512) ?>;
    
    function updateProductsList() {
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        productsContainer.innerHTML = '';
        
        if (selectedCategories.length === 0) {
            productsContainer.innerHTML = '<p class="text-muted"><?php echo e(__('messages.Select categories first to see products')); ?></p>';
            productControls.style.display = 'none';
            return;
        }
        
        productControls.style.display = 'block';
        
        selectedCategories.forEach(categoryId => {
            if (allProducts[categoryId]) {
                const categoryName = document.querySelector(`#category_${categoryId} + label`).textContent.split('(')[0].trim();
                
                const categoryDiv = document.createElement('div');
                categoryDiv.className = 'mb-3';
                categoryDiv.innerHTML = `
                    <h6 class="text-primary border-bottom pb-2">${categoryName}</h6>
                    <div class="row">
                        ${allProducts[categoryId].map(product => `
                            <div class="col-md-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input product-checkbox" 
                                           type="checkbox" 
                                           name="products[]" 
                                           value="${product.id}" 
                                           id="product_${product.id}"
                                           ${assignedProducts.includes(product.id) ? 'checked' : ''}>
                                    <label class="form-check-label" for="product_${product.id}">
                                        <?php echo e(app()->getLocale() === 'ar' ? '${product.name_ar}' : '${product.name_en}'); ?>

                                        <small class="text-success d-block"><?php echo e(__('messages.Price')); ?>: $${product.selling_price}</small>
                                    </label>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
                
                productsContainer.appendChild(categoryDiv);
            }
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
        });
    });
    
    // Select/Deselect all categories
    selectAllCategories.addEventListener('click', function() {
        categoryCheckboxes.forEach(cb => cb.checked = true);
        updateProductsList();
    });
    
    deselectAllCategories.addEventListener('click', function() {
        categoryCheckboxes.forEach(cb => cb.checked = false);
        updateProductsList();
    });
    
    // Select/Deselect all products
    selectAllProducts.addEventListener('click', function() {
        document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = true);
        updateCounts();
    });
    
    deselectAllProducts.addEventListener('click', function() {
        document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
        updateCounts();
    });
    
    // Listen for product checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-checkbox')) {
            updateCounts();
        }
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
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\yaman\resources\views/admin/branch-categories/edit.blade.php ENDPATH**/ ?>