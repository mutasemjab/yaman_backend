

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><?php echo e(__('messages.Branch Categories Management')); ?></h5>
                    <a href="<?php echo e(route('branch-categories.create')); ?>" class="btn btn-primary">
                        <?php echo e(__('messages.Add New')); ?>

                    </a>
                </div>
                <div class="card-body">
                  

                    <?php if(!empty($branchData)): ?>
                        <?php $__currentLoopData = $branchData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branchId => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="branch-section mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-store me-2"></i>
                                                <?php echo e($data['branch']->name); ?>

                                            </h6>
                                            <div class="btn-group">
                                                <a href="<?php echo e(route('branch-categories.show', $branchId)); ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <?php echo e(__('messages.View')); ?>

                                                </a>
                                                <a href="<?php echo e(route('branch-categories.edit', $branchId)); ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <?php echo e(__('messages.Edit')); ?>

                                                </a>
                                                <form method="POST" 
                                                      action="<?php echo e(route('branch-categories.destroy', $branchId)); ?>" 
                                                      class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('<?php echo e(__('messages.confirm_remove_assignments')); ?>')">
                                                        <?php echo e(__('messages.Remove All')); ?>

                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <?php echo e(__('messages.Total Products')); ?>: <?php echo e($data['total_products']); ?>

                                        </small>
                                    </div>
                                    <div class="card-body">
                                        <?php if($data['categories']->count() > 0): ?>
                                            <div class="row">
                                                <?php $__currentLoopData = $data['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card border-secondary">
                                                            <div class="card-body">
                                                                <h6 class="card-title">
                                                                    <?php echo e(app()->getLocale() === 'ar' ? $category->name_ar : $category->name_en); ?>

                                                                </h6>
                                                                <p class="text-muted small mb-2">
                                                                    <?php echo e(__('messages.Products')); ?>: <?php echo e($category->products->count()); ?>

                                                                </p>
                                                                <?php if($category->products->count() > 0): ?>
                                                                    <div class="products-list">
                                                                        <?php $__currentLoopData = $category->products->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <small class="d-block text-truncate">
                                                                                • <?php echo e(app()->getLocale() === 'ar' ? $product->name_ar : $product->name_en); ?>

                                                                            </small>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($category->products->count() > 3): ?>
                                                                            <small class="text-muted">
                                                                                <?php echo e(__('messages.and')); ?> <?php echo e($category->products->count() - 3); ?> <?php echo e(__('messages.more')); ?>

                                                                            </small>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <small class="text-muted"><?php echo e(__('messages.No products assigned')); ?></small>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-center py-3">
                                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                                <p class="text-muted"><?php echo e(__('messages.No categories assigned to this branch')); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-store fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted"><?php echo e(__('messages.No branch data found')); ?></h5>
                            <p class="text-muted"><?php echo e(__('messages.Start by adding categories to branches')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.branch-section {
    border-left: 4px solid #007bff;
    padding-left: 15px;
}

.products-list {
    max-height: 80px;
    overflow-y: auto;
}

.card-title {
    color: #495057;
    font-weight: 600;
}

.btn-group .btn {
    border-radius: 0.25rem;
    margin-left: 2px;
}

.fas {
    color: #6c757d;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\yaman\resources\views/admin/branch-categories/index.blade.php ENDPATH**/ ?>