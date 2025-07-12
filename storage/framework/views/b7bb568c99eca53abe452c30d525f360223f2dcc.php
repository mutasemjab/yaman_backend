

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('messages.Add Categories and Products to Branch')); ?></h5>
                </div>
                <div class="card-body">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('branch-categories.store')); ?>">
                        <?php echo csrf_field(); ?>

                        <!-- Branch Selection -->
                        <div class="form-group mb-3">
                            <label for="branch_id" class="form-label"><?php echo e(__('messages.Select Branch')); ?> <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="branch_id" 
                                    name="branch_id" 
                                    required>
                                <option value=""><?php echo e(__('messages.Choose Branch')); ?></option>
                                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($branch->id); ?>" 
                                            <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>>
                                        <?php echo e($branch->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Categories Selection -->
                        <div class="form-group mb-3">
                            <label for="categories" class="form-label"><?php echo e(__('messages.Select Categories')); ?> <span class="text-danger">*</span></label>
                            <div class="categories-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-checkbox" 
                                               type="checkbox" 
                                               name="categories[]" 
                                               value="<?php echo e($category->id); ?>" 
                                               id="category_<?php echo e($category->id); ?>"
                                               <?php echo e(in_array($category->id, old('categories', [])) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="category_<?php echo e($category->id); ?>">
                                            <?php echo e(app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en); ?>

                                            <small class="text-muted">(<?php echo e($category->products->count()); ?> <?php echo e(__('messages.products')); ?>)</small>
                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php $__errorArgs = ['categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Products Selection -->
                        <div class="form-group mb-3">
                            <label for="products" class="form-label"><?php echo e(__('messages.Select Products')); ?> <small class="text-muted">(<?php echo e(__('messages.optional')); ?>)</small></label>
                            <div class="products-container border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <div id="products-list">
                                    <p class="text-muted"><?php echo e(__('messages.Select categories first to see products')); ?></p>
                                </div>
                            </div>
                            <?php $__errorArgs = ['products'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="form-group d-flex justify-content-between">
                            <a href="<?php echo e(route('branch-categories.index')); ?>" class="btn btn-secondary">
                                <?php echo e(__('messages.Cancel')); ?>

                            </a>
                            <button type="submit" class="btn btn-primary">
                                <?php echo e(__('messages.Save')); ?>

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
    const allProducts = <?php echo json_encode($products->groupBy('category_id'), 15, 512) ?>;
    
    function updateProductsList() {
        const selectedCategories = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        productsContainer.innerHTML = '';
        
        if (selectedCategories.length === 0) {
            productsContainer.innerHTML = '<p class="text-muted"><?php echo e(__('messages.Select categories first to see products')); ?></p>';
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
                                    <?php echo e(app()->getLocale() === 'ar' ? '${product.name_ar}' : '${product.name_en}'); ?>

                                    <small class="text-muted">(<?php echo e(__('messages.Price')); ?>: ${product.selling_price})</small>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\yaman\resources\views/admin/branch-categories/create.blade.php ENDPATH**/ ?>