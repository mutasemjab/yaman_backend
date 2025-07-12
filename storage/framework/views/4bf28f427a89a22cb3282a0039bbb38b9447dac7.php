<?php $__env->startSection('title'); ?>
<?php echo e(__('messages.coupons')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> <?php echo e(__('messages.New')); ?><?php echo e(__('messages.coupons')); ?>   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="<?php echo e(route('coupons.store')); ?>" method="post" enctype='multipart/form-data'>
        <div class="row">
        <?php echo csrf_field(); ?>

        <div class="col-md-6">
            <div class="form-group">
              <label>   <?php echo e(__('messages.Code')); ?>  </label>
              <input name="code" id="code" class="form-control" value="<?php echo e(old('code')); ?>"    >
              <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="text-danger"><?php echo e($message); ?></span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   <?php echo e(__('messages.Amount')); ?> </label>
              <input name="amount" id="amount" class="form-control" value="<?php echo e(old('amount')); ?>"    >
              <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="text-danger"><?php echo e($message); ?></span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>  <?php echo e(__('messages.Minimum_Total')); ?></label>
              <input name="minimum_total" id="minimum_total" class="form-control" value="<?php echo e(old('minimum_total')); ?>"    >
              <?php $__errorArgs = ['minimum_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="text-danger"><?php echo e($message); ?></span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
              <label>   <?php echo e(__('messages.Expired_At')); ?></label>
              <input type="date" name="expired_at" id="expired_at" class="form-control" value="<?php echo e(old('expired_at')); ?>"    >
              <?php $__errorArgs = ['expired_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="text-danger"><?php echo e($message); ?></span>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>



      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> <?php echo e(__('messages.Submit')); ?></button>
        <a href="<?php echo e(route('coupons.index')); ?>" class="btn btn-sm btn-danger"><?php echo e(__('messages.Cancel')); ?></a>

      </div>
    </div>

  </div>
            </form>



            </div>




        </div>
      </div>






<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>

<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/coupons/create.blade.php ENDPATH**/ ?>