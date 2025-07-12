<?php $__env->startSection('title'); ?>
orders
<?php $__env->stopSection(); ?>


<?php $__env->startSection('contentheaderactive'); ?>
show
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>



      <div class="card">
        <div class="card-header">
          <h3 class="card-title card_title_center"> orders </h3>
          <input type="hidden" id="token_search" value="<?php echo e(csrf_token()); ?>">


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

            <table id="example2" class="table table-bordered table-hover">
                <thead class="custom_thead">
                    <th>Order status</th>
                    <th>Delivery Fee</th>
                    <th>Total Prices</th>
                    <th>Total discount</th>
                    <th>Payment Type</th>
                    <th>Payment status</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td><?php if($info->order_status==1): ?> Pending <?php elseif($info->order_status==2): ?> OnTheWay <?php elseif($info->order_status==3): ?> Cancelled <?php elseif($info->order_status==4): ?> Failed <?php else: ?> DELIVERD <?php endif; ?></td>
                        <td><?php echo e($info->delivery_fee); ?></td>
                        <td><?php echo e($info->total_prices); ?></td>
                        <td><?php echo e($info->total_discounts); ?></td>
                        <td><?php echo e($info->payment_type); ?></td>
                        <td> <?php if($info->payment_status ==1): ?> Paid <?php else: ?> UnPaid <?php endif; ?> </td>


                        <td>
                            <a href="<?php echo e(route('orders.edit', $info->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo e(route('orders.show', $info->id)); ?>" class="btn btn-sm btn-primary">Show</a>
                            <form action="<?php echo e(route('orders.destroy', $info->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
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
<script src="<?php echo e(asset('assets/admin/js/orderss.js')); ?>"></script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>