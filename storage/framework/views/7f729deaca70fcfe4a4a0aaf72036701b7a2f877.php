<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo e(asset('assets/admin/dist/img/AdminLTELogo.png')); ?>" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">باب اليمن السعيد</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e(asset('assets/admin/dist/img/user2-160x160.jpg')); ?>" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo e(auth()->user()->name); ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->



                

                <li class="nav-item">
                    <a href="<?php echo e(route('admin.customer.index')); ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo e(__('messages.Customers')); ?> </p>
                    </a>
                </li>




                   <?php if(
                    $user->can('order-table') ||
                        $user->can('order-add') ||
                        $user->can('order-edit') ||
                        $user->can('order-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('orders.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.Orders')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>


                   <?php if(
                    $user->can('category-table') ||
                        $user->can('category-add') ||
                        $user->can('category-edit') ||
                        $user->can('category-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('categories.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.categories')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>

                   <?php if(
                    $user->can('unit-table') ||
                        $user->can('unit-add') ||
                        $user->can('unit-edit') ||
                        $user->can('unit-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('units.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.units')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>

            <?php if(
                    $user->can('product-table') ||
                        $user->can('product-add') ||
                        $user->can('product-edit') ||
                        $user->can('product-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('products.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.products')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>


                  <?php if(
                    $user->can('offer-table') ||
                        $user->can('offer-add') ||
                        $user->can('offer-edit') ||
                        $user->can('offer-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('offers.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.offers')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(
                    $user->can('coupon-table') ||
                        $user->can('coupon-add') ||
                        $user->can('coupon-edit') ||
                        $user->can('coupon-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('coupons.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.coupons')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(
                    $user->can('banner-table') ||
                        $user->can('banner-add') ||
                        $user->can('banner-edit') ||
                        $user->can('banner-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('banners.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.banners')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if(
                    $user->can('delivery-table') ||
                        $user->can('delivery-add') ||
                        $user->can('delivery-edit') ||
                        $user->can('delivery-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('deliveries.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.deliveries')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>
       
                <?php if(
                    $user->can('branch-table') ||
                        $user->can('branch-add') ||
                        $user->can('branch-edit') ||
                        $user->can('branch-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('branches.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.branches')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if(
                    $user->can('notification-table') ||
                        $user->can('notification-add') ||
                        $user->can('notification-edit') ||
                        $user->can('notification-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('notifications.create')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> <?php echo e(__('messages.notifications')); ?>  </p>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="<?php echo e(route('settings.index')); ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo e(__('messages.Settings')); ?> </p>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="<?php echo e(route('admin.login.edit',auth()->user()->id)); ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p><?php echo e(__('messages.Admin_account')); ?>  </p>
                    </a>
                </li>

                <?php if($user->can('role-table') || $user->can('role-add') || $user->can('role-edit') || $user->can('role-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.role.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <span><?php echo e(__('messages.Roles')); ?>  </span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(
                    $user->can('employee-table') ||
                        $user->can('employee-add') ||
                        $user->can('employee-edit') ||
                        $user->can('employee-delete')): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.employee.index')); ?>" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <span> <?php echo e(__('messages.Employee')); ?>  </span>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/includes/sidebar.blade.php ENDPATH**/ ?>