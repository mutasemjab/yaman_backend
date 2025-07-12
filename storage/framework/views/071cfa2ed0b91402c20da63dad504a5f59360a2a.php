<?php $__env->startSection('title'); ?>

<?php echo e(__('messages.Edit')); ?> <?php echo e(__('messages.products')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('contentheaderlink'); ?>
<a href="<?php echo e(route('products.index')); ?>">  <?php echo e(__('messages.products')); ?> </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheaderactive'); ?>
<?php echo e(__('messages.Edit')); ?>

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
          <h3 class="card-title card_title_center"> <?php echo e(__('messages.Edit')); ?> <?php echo e(__('messages.products')); ?> </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">


      <form action="<?php echo e(route('products.update',$data['id'])); ?>" method="post" enctype='multipart/form-data'>
        <div class="row">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>


        <div class="col-md-6">
            <div class="form-group">
                <label><?php echo e(__('messages.Name_en')); ?></label>
                <input name="name_en" id="name_en" class="form-control"
                    value="<?php echo e(old('name_en', $data['name_en'])); ?>">
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
                <label><?php echo e(__('messages.Name_ar')); ?></label>
                <input name="name_ar" id="name_ar" class="form-control"
                    value="<?php echo e(old('name_ar', $data['name_ar'])); ?>">
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
                <label><?php echo e(__('messages.description_en')); ?></label>
                <textarea name="description_en" id="description_en" class="form-control"
                    value="<?php echo e(old('description_en', $data['description_en'])); ?>"><?php echo e($data['description_en']); ?></textarea>
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
                <label><?php echo e(__('messages.description_ar')); ?></label>
                <textarea name="description_ar" id="description_ar" class="form-control"
                    value="<?php echo e(old('description_ar', $data['description_ar'])); ?>"><?php echo e($data['description_ar']); ?></textarea>
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
                    <option value="<?php echo e($category->id); ?>"
                        <?php echo e($category->id == $data->category_id ? 'selected' : ''); ?>>
                        <?php echo e($category->name_ar); ?>

                    </option>
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
            <label for="unit_id">Unit</label>
            <select class="form-control" name="unit" id="unit_id">
                <option value="">Select Unit</option>
                <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($unit->id); ?>"
                        <?php echo e($unit->id == $data->unit_id ? 'selected' : ''); ?>>
                        <?php echo e($unit->name_ar); ?>

                    </option>
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
                <label> <?php echo e(__('messages.Available_Qty')); ?></label>
                <input name="available_quantity" id="available_quantity" class="form-control"
                    value="<?php echo e(old('available_quantity', $data->available_quantity)); ?>">
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
                <label> <?php echo e(__('messages.tax')); ?>  %</label>
                <input name="tax" id="tax" class="form-control"
                    value="<?php echo e(old('tax', $data->tax)); ?>">
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
                <label><?php echo e(__('messages.Selling_price')); ?></label>
                <input name="selling_price" id="selling_price" class="form-control"
                    value="<?php echo e(old('selling_price', $data->selling_price)); ?>">
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
                <label><?php echo e(__('messages.Minimum_order')); ?></label>
                <input name="min_order" id="min_order" class="form-control"
                    value="<?php echo e(old('min_order', $data->min_order)); ?>">
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
                <label> <?php echo e(__('messages.Status')); ?></label>
                <select name="status" id="status" class="form-control">
                    <option value="">Select</option>
                    <option value="1" <?php echo e($data->status == 1 ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e($data->status == 0 ? 'selected' : ''); ?>>Inactive</option>
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
                <label><?php echo e(__('messages.is_featured')); ?> </label>
                <select name="is_featured" id="is_featured" class="form-control">
                    <option value="">Select</option>
                    <option value="1" <?php echo e($data->is_featured == 1 ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e($data->is_featured == 0 ? 'selected' : ''); ?>>Inactive</option>
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
                    <option value="1" <?php echo e($data->has_variation == 1 ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e($data->has_variation == 0 ? 'selected' : ''); ?>>Inactive</option>
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
            <?php if($data->has_variation): ?>
                <?php $__currentLoopData = $data->variations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="variation">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="attributes[]" placeholder="Attributes"
                                    value="<?php echo e($variation->attributes); ?>">
                                <br>
                                <br>
                                <input type="text" name="variations[]" placeholder="Variations"
                                    value="<?php echo e($variation->variation); ?>">
                                <br>
                                <br>
                                <input type="number" name="available_quantities[]"
                                    placeholder="Available Quantity"
                                    value="<?php echo e($variation->available_quantity); ?>">
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <button type="button" id="add-variation">Add Variation</button>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <?php if($data->productImages->count() > 0): ?>
                    <?php $__currentLoopData = $data->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('assets/admin/uploads/' . $image->photo)); ?>" alt="Product Image" height="50px" width="50px">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p>No images available for this product.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>Product Images</label>
                <input type="file" name="photo[]" class="form-control" multiple>
            </div>
        </div>

      <div class="col-md-12">
      <div class="form-group text-center">
        <button id="do_add_item_cardd" type="submit" class="btn btn-primary btn-sm"> <?php echo e(__('messages.Update')); ?></button>
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





<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>