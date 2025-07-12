<?php $__env->startSection('title'); ?>

  <?php echo e(__('messages.Edit')); ?> <?php echo e(__('messages.banners')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('contentheaderlink'); ?>
<a href="<?php echo e(route('banners.index')); ?>">  <?php echo e(__('messages.banners')); ?> </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderactive'); ?>
<?php echo e(__('messages.Edit')); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center">   <?php echo e(__('messages.Edit')); ?> <?php echo e(__('messages.banners')); ?> </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="<?php echo e(route('banners.update',$data['id'])); ?>" method="post" enctype='multipart/form-data'>
        <div class="row">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>



        <div class="col-md-6">
            <div class="form-group">
                <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
              <button class="btn"> <?php echo e(__('messages.photo')); ?></button>
             <input  type="file" id="Item_img" name="photo" class="form-control" onchange="previewImage()">
                <?php $__errorArgs = ['photo'];
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
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> <?php echo e(__('messages.Update')); ?></button>
        <a href="<?php echo e(route('banners.index')); ?>" class="btn btn-sm btn-danger"><?php echo e(__('messages.Cancel')); ?></a>

      </div>
    </div>

  </div>
            </form>



            </div>




        </div>
      </div>






<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
<script>
    function previewImage() {
      var preview = document.getElementById('image-preview');
      var input = document.getElementById('Item_img');
      var file = input.files[0];
      if (file) {
      preview.style.display = "block";
      var reader = new FileReader();
      reader.onload = function() {
        preview.src = reader.result;
      }
      reader.readAsDataURL(file);
    }else{
        preview.style.display = "none";
    }
}
  </script>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/banners/edit.blade.php ENDPATH**/ ?>