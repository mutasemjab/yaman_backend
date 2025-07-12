<?php $__env->startSection('title'); ?>
<?php echo e(__('messages.coupons')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('contentheaderactive'); ?>
<?php echo e(__('messages.Show')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> <?php echo e(__('messages.coupons')); ?> </h3>
          <input type="hidden" id="token_search" value="<?php echo e(csrf_token()); ?>">

          <a href="<?php echo e(route('coupons.create')); ?>" class="btn btn-sm btn-success" >  <?php echo e(__('messages.New')); ?> <?php echo e(__('messages.coupons')); ?></a>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
          <div class="col-md-4">

            

            

                      </div>

                          </div>
               <div class="clearfix"></div>

        <div id="ajax_responce_serarchDiv" class="col-md-12">

            <?php if(isset($data) && !$data->isEmpty()): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon-table')): ?>
            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">

                    <th><?php echo e(__('messages.Code')); ?></th>
                    <th><?php echo e(__('messages.Amount')); ?></th>
                    <th><?php echo e(__('messages.Minimum_Total')); ?></th>
                    <th><?php echo e(__('messages.Expired_At')); ?></th>
                    <th><?php echo e(__('messages.Action')); ?></th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>


                        <td><?php echo e($info->code); ?></td>
                        <td><?php echo e($info->amount); ?></td>
                        <td><?php echo e($info->minimum_total); ?></td>
                        <td><?php echo e($info->expired_at); ?></td>

                        <td>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon-edit')): ?>
                            <a href="<?php echo e(route('coupons.edit', $info->id)); ?>" class="btn btn-sm btn-primary"><?php echo e(__('messages.Edit')); ?></a>
                            <?php endif; ?>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('coupon-delete')): ?>
                            <form action="<?php echo e(route('coupons.destroy', $info->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger"><?php echo e(__('messages.Delete')); ?></button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <?php endif; ?>
            <br>
            <?php echo e($data->links()); ?>


            <?php else: ?>
            <div class="alert alert-danger">
                There is no data found!!
            </div>
            <?php endif; ?>

        </div>



      </div>

        </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('assets/admin/js/couponss.js')); ?>"></script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/coupons/index.blade.php ENDPATH**/ ?>