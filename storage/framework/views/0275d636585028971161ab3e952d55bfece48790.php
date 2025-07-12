

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><?php echo e(__('messages.Branch Details')); ?>: <?php echo e($branch->name); ?></h5>
                    <div class="btn-group">
                        <a href="<?php echo e(route('branch-categories.edit', $branch->id)); ?>" class="btn btn-warning">
                            <?php echo e(__('messages.Edit')); ?>

                        </a>
                        <a href="<?php echo e(route('branch-categories.index')); ?>" class="btn btn-secondary">
                            <?php echo e(__('messages.Back to List')); ?>

                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Branch Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6><?php echo e(__('messages.Branch Information')); ?></h6>
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong><?php echo e(__('messages.Name')); ?></strong></td>
                                    <td><?php echo e($branch->name); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo e(__('messages.Address')); ?></strong></td>
                                    <td><?php echo e($branch->address); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo e(__('messages.Working Hours')); ?></strong></td>
                                    <td><?php echo e($branch->working_hour); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo e(__('messages.Total Categories')); ?></strong></td>
                                    <td><?php echo e($branchCategories->count()); ?></td>
                                </tr>
                                <tr>
                                    <td><strong><?php echo e(__('messages.Total Products')); ?></strong></td>
                                    <td><?php echo e($branch->products->count()); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <?php if($branch->photo): ?>
                                <img src="<?php echo e(asset('storage/' . $branch->photo)); ?>" 
                                     alt="<?php echo e($branch->name); ?>" 
                                     class="img-fluid rounded">
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Categories and Products -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6><?php echo e(__('messages.Categories and Products')); ?></h6>
                            
                            <?php if($branchCategories->count() > 0): ?>
                                <div class="accordion" id="categoriesAccordion">
                                    <?php $__currentLoopData = $branchCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header" id="heading<?php echo e($category->id); ?>">
                                                <button class="accordion-button" 
                                                        type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#collapse<?php echo e($category->id); ?>" 
                                                        aria-expanded="true" 
                                                        aria-controls="collapse<?php echo e($category->id); ?>">
                                                    <div class="d-flex justify-content-between w-100 me-3">
                                                        <span>
                                                            <i class="fas fa-folder me-2"></i>
                                                            <?php echo e(app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en); ?>

                                                        </span>
                                                        <span class="badge bg-primary">
                                                            <?php echo e($category->products->count()); ?> <?php echo e(__('messages.products')); ?>

                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse<?php echo e($category->id); ?>" 
                                                 class="accordion-collapse collapse" 
                                                 aria-labelledby="heading<?php echo e($category->id); ?>" 
                                                 data-bs-parent="#categoriesAccordion">
                                                <div class="accordion-body">
                                                    <?php if($category->products->count() > 0): ?>
                                                        <div class="row">
                                                            <?php $__currentLoopData = $category->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <div class="col-md-4 mb-3">
                                                                    <div class="card border-light">
                                                                        <div class="card-body p-3">
                                                                            <h6 class="card-title">
                                                                                <?php echo e(app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en); ?>

                                                                            </h6>
                                                                            <p class="card-text small text-muted">
                                                                                <?php echo e(Str::limit(app()->getLocale() === 'ar' ? $product->description_ar : $product->description_en, 50)); ?>

                                                                            </p>
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <span class="text-success fw-bold">
                                                                                    $<?php echo e(number_format($product->selling_price, 2)); ?>

                                                                                </span>
                                                                                <div class="btn-group btn-group-sm">
                                                                                    <span class="badge bg-<?php echo e($product->status ? 'success' : 'danger'); ?>">
                                                                                        <?php echo e($product->status ? __('messages.Active') : __('messages.Inactive')); ?>

                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                            <?php if($product->is_featured): ?>
                                                                                <span class="badge bg-warning text-dark mt-2">
                                                                                    <?php echo e(__('messages.Featured')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="text-center py-3">
                                                            <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                                            <p class="text-muted"><?php echo e(__('messages.No products in this category')); ?></p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted"><?php echo e(__('messages.No categories assigned')); ?></h5>
                                    <p class="text-muted"><?php echo e(__('messages.This branch has no categories assigned yet')); ?></p>
                                    <a href="<?php echo e(route('branch-categories.edit', $branch->id)); ?>" class="btn btn-primary">
                                        <?php echo e(__('messages.Add Categories')); ?>

                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.accordion-button {
    background-color: #f8f9fa;
    color: #495057;
}

.accordion-button:not(.collapsed) {
    background-color: #e3f2fd;
    color: #1976d2;
}

.card-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: #495057;
}

.card-text {
    font-size: 0.8rem;
    line-height: 1.4;
}

.badge {
    font-size: 0.7rem;
}

.fas {
    color: #6c757d;
}

.btn-group-sm .btn {
    padding: 0.125rem 0.5rem;
    font-size: 0.75rem;
}

.table td {
    vertical-align: middle;
}

.img-fluid {
    max-height: 200px;
    object-fit: cover;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\yaman\resources\views/admin/branch-categories/show.blade.php ENDPATH**/ ?>