<?php $__env->startSection('title'); ?>
<?php echo e(__('messages.products')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    /* Style for the "plus" button */
    #add-variation {
        display: block;
        margin-top: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
    }

    /* Style for the variation fields container */
    #variationFields {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }

    /* Style for individual variation fields */
    .variation {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 10px;
    }
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> <?php echo e(__('messages.New')); ?> <?php echo e(__('messages.products')); ?>   </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="<?php echo e(route('products.store')); ?>" method="post" enctype='multipart/form-data'>
        <div class="row">
        <?php echo csrf_field(); ?>


        <div class="col-md-6">
            <div class="form-group">
                <label>  <?php echo e(__('messages.Name_en')); ?> </label>
                <input name="name_en" id="name_en" class="form-control" value="<?php echo e(old('name_en')); ?>">
                <?php $__errorArgs = ['name_en'];
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
                <label>  <?php echo e(__('messages.Name_ar')); ?> </label>
                <input name="name_ar" id="name_ar" class="form-control" value="<?php echo e(old('name_ar')); ?>">
                <?php $__errorArgs = ['name_ar'];
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
                <label>  <?php echo e(__('messages.description_en')); ?> </label>
                <textarea name="description_en" id="description_en" class="form-control" value="<?php echo e(old('description_en')); ?>" rows="8"></textarea>
                <?php $__errorArgs = ['description_en'];
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
                <label>  <?php echo e(__('messages.description_ar')); ?> </label>
                <textarea name="description_ar" id="description_ar" class="form-control" value="<?php echo e(old('description_ar')); ?>" rows="8"></textarea>
                <?php $__errorArgs = ['description_ar'];
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

            <div class="form-group col-md-6">
                <label for="category_id">Parent Category</label>
                <select class="form-control" name="category" id="category_id">
                    <option value="">Select Parent Category</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name_ar); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['category'];
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

            <div class="form-group col-md-6">
                <label for="category_id"> Unit</label>
                <select class="form-control" name="unit" id="category_id">
                    <option value="">Select Unit</option>
                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->name_ar); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['unit'];
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


        <div class="col-md-6">
            <div class="form-group">
              <label>   <?php echo e(__('messages.Available_Qty')); ?> </label>
              <input name="available_quantity" id="available_quantity" class="form-control" value="<?php echo e(old('available_quantity')); ?>"    >
              <?php $__errorArgs = ['available_quantity'];
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
                  <label>  <?php echo e(__('messages.tax')); ?> %</label>
                  <input name="tax" id="tax" class="form-control" value="<?php echo e(old('tax')); ?>"    >
                  <?php $__errorArgs = ['tax'];
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
                  <label>  <?php echo e(__('messages.Selling_price')); ?></label>
                  <input name="selling_price" id="tax" class="form-control" value="<?php echo e(old('selling_price')); ?>"    >
                  <?php $__errorArgs = ['selling_price'];
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
                      <label>  <?php echo e(__('messages.Minimum_order')); ?></label>
                      <input name="min_order" id="tax" class="form-control" value="<?php echo e(old('min_order')); ?>"    >
                      <?php $__errorArgs = ['min_order'];
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
                          <label>  <?php echo e(__('messages.Status')); ?> </label>
                          <select name="status" id="status" class="form-control">
                           <option value=""> select</option>
                          <option   <?php if(old('status')==1  || old('status')=="" ): ?> selected="selected"  <?php endif; ?> value="1"> active</option>
                           <option <?php if( (old('status')==0 and old('status')!="")): ?> selected="selected"  <?php endif; ?>   value="0"> disactive</option>
                          </select>
                          <?php $__errorArgs = ['status'];
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
                              <label> <?php echo e(__('messages.is_featured')); ?> </label>
                              <select name="is_featured" id="is_featured" class="form-control">
                               <option value=""> select</option>
                              <option   <?php if(old('is_featured')==1  || old('is_featured')=="" ): ?> selected="selected"  <?php endif; ?> value="1"> active</option>
                               <option <?php if( (old('is_featured')==0 and old('is_featured')!="")): ?> selected="selected"  <?php endif; ?>   value="0"> disactive</option>
                              </select>
                              <?php $__errorArgs = ['is_featured'];
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
                                    <label><?php echo e(__('messages.Has_Variation')); ?></label>
                                    <select name="has_variation" id="has_variation" class="form-control">
                                        <option value="">Select</option>
                                        <option <?php if(old('has_variation') == 1 || old('has_variation') == ""): ?> selected="selected" <?php endif; ?> value="1">Active</option>
                                        <option <?php if(old('has_variation') == 0 and old('has_variation') != ""): ?> selected="selected" <?php endif; ?> value="0">Inactive</option>
                                    </select>
                                    <?php $__errorArgs = ['has_variation'];
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

                            <div id="variationFields">
                                <div class="variation">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="attributes[]" placeholder="Attributes">
                                            <br>
                                            <br>
                                            <input type="text" name="variations[]" placeholder="Variations">
                                            <br>
                                            <br>
                                            <input type="number" name="available_quantities[]" placeholder="Available Quantity">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <button type="button" id="add-variation">Add Variation</button>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <img src="" id="image-preview" alt="Selected Image" height="50px" width="50px" style="display: none;">
                                  <button class="btn"> <?php echo e(__('messages.photo')); ?></button>
                                 <input  type="file" id="Item_img" name="photo[]" class="form-control" onchange="previewImage()" multiple>
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
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> <?php echo e(__('messages.Submit')); ?></button>
        <a href="<?php echo e(route('products.index')); ?>" class="btn btn-sm btn-danger"><?php echo e(__('messages.Cancel')); ?></a>

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
    // Function to toggle visibility of variation fields
    function toggleVariationFields() {
        const hasVariation = document.getElementById('has_variation').value;
        const variationFields = document.getElementById('variationFields');

        if (hasVariation === '1') {
            variationFields.style.display = 'block';
        } else {
            variationFields.style.display = 'none';
        }
    }

    // Initial state on page load
    toggleVariationFields();

    // Event listener to toggle fields when the selection changes
    document.getElementById('has_variation').addEventListener('change', toggleVariationFields);

    // Function to add new variation fields
    document.getElementById('add-variation').addEventListener('click', function () {
        const variationFields = document.getElementById('variationFields');
        const variation = document.querySelector('.variation');
        const clone = variation.cloneNode(true);
        variationFields.appendChild(clone);
    });
</script>


<script>
    $(function() {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            localStorage.setItem('lastTab', $(this).attr('href'));
        });

        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('[href="' + lastTab + '"]').tab('show');
        } else {
            $('a[data-toggle="tab"]').first().tab('show');
        }
    });
</script>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/products/create.blade.php ENDPATH**/ ?>