<?php $__env->startSection('title'); ?>
Setting
<?php $__env->stopSection(); ?>


<?php $__env->startSection('contentheaderactive'); ?>
show
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



<div class="card">
    <div class="card-header">
        <h3 class="card-title card_title_center"> Setting </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 table-responsive">

                <?php if(count($data)>0): ?>
                <div></div>
                <?php else: ?>
                <a href="<?php echo e(route('admin.setting.create')); ?>" class="btn btn-sm btn-success"> New Setting</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-table')): ?>
                <?php if(@isset($data) && !@empty($data) && count($data)>0): ?>

                <table style="width:100%" id="" class="table">
                    <thead class="custom_thead">
                        <td>Min Order</td>
                        <td>Action</td>

                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>



                            <td><?php echo e($info->min_order); ?></td>


                            <td>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('setting-edit')): ?>
                                <a href="<?php echo e(route('admin.setting.edit',$info->id)); ?>"
                                    class="btn btn-sm  btn-primary">edit</a>
                                <?php endif; ?>
                            </td>



                        </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                    </tbody>
                </table>
                <br>
                <?php echo e($data->links()); ?>


                <?php else: ?>
                <div class="alert alert-danger">
                    there is no data found !! </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>



        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/admin/js/Settings.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>