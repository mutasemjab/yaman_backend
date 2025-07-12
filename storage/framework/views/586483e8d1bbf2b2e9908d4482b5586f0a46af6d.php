<?php $__env->startSection('title'); ?>
orders
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
<style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }

    #invoice {
      max-width: 800px;
      margin: auto;
      border: 1px solid #ccc;
      padding: 20px;
      background-color: #fff;
    }

    #header {
      text-align: center;
    }

    #logo {
      max-width: 100px;
      margin-bottom: 10px;
    }

    #company-name {
      font-size: 1.5em;
      font-weight: bold;
    }

    #details {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }

    #details-left,
    #details-right {
      flex-basis: 25%; /* Adjust the width as needed */
    }

    #client-details {
      margin-top: 30px;
    }

    #client-details p {
      text-align: right;
    }


    #products {
      margin-top: 30px;
      width: 100%;
      border-collapse: collapse;
    }

    #products th, #products td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }

    #totals {
      margin-top: 20px;
      text-align: left;
      font-size: 30px;
    }

    #totals div {
      margin-bottom: 10px;
    }

    @media print {
      body {
        margin: 0;
      }

      #invoice {
        max-width: 100%;
        margin: none;
        border: 1px solid #ccc;
        padding: 20px;
        background-color: #fff;
      }

      .print-hidden {
        display: none;
      }
    }
  </style>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<button onclick="printInvoice()" class="btn btn-sm btn-danger print-hidden">Print Invoice</button>

<div id="invoice">
    <div id="header">
      <img id="logo" src="<?php echo e(asset('assets/admin/imgs/logo.png')); ?>" alt="Company Logo">
      <div id="company-name">Hajat</div>
    </div>

    <div id="details">
        <div id="details-left">
          <p>التاريخ: <?php echo e($order->created_at->format('Y-m-d')); ?></p>
          <p>رقم الفاتورة #: 100<?php echo e($order->id); ?></p>
        </div>
        <div id="details-right">
          <p>العميل: <?php echo e($order->user->name); ?></p>
          <p>العنوان: <?php echo e($order->address->address); ?> / شارع : <?php echo e($order->address->street); ?> / رقم البناية :<?php echo e($order->address->building_number); ?></p>
        </div>
      </div>

    <table id="products">
      <thead>
        <tr>
            <th>الصورة</th>
            <th>اسم السلعة</th>
            <th>المواصفة</th>
            <th>الكمية</th>
            <th>سعر الوحدة</th>
            <th>المجموع</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>
                    <?php if($product->productImages->first()->photo): ?>

                        <div class="image">
                           <img class="custom_img" src="<?php echo e(asset('assets/admin/uploads').'/'.$product->productImages->first()->photo); ?>" >
                        </div>
                      <?php else: ?>
                        No Photo
                    <?php endif; ?>
                </td>
                <td><?php echo e($product->name); ?></td>
                <td>
                    <?php if($product->pivot->variation_id): ?>
                        <?php echo e(\App\Models\Variation::find($product->pivot->variation_id)->variation); ?>

                    <?php else: ?>
                       لا يوجد
                    <?php endif; ?>
                </td>
                <td><?php echo e($product->pivot->quantity); ?></td>
                <td><?php echo e($product->pivot->unit_price); ?></td>
                <!-- Add more columns based on your order_products table -->
                <td><?php echo e($product->pivot->total_price_after_tax); ?></td>



            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    </table>

    <div id="totals">
        <?php
            $totalPriceBeforeTax = $order->products->sum(function ($product) {
                return $product->pivot->total_price_before_tax;
            });
        ?>
        <div>المجموع قبل الضريبة: <?php echo e(round($totalPriceBeforeTax,3)); ?> JD</div>

      <div><?php if($order->total_discounts): ?>
        <p class="total-label" style="color: red">الخصم  : - <?php echo e($order->total_discounts); ?> JD</p>
           <?php endif; ?>
      </div>

     <?php
     $uniqueTaxPercentages = $order->products->pluck('pivot.tax_percentage')->unique();
     ?>

    <?php if($uniqueTaxPercentages->count() == 1): ?>
        
        <?php
            $totalTaxValue = $order->products->sum('pivot.tax_value');
        ?>
        <div>الضريبة (<?php echo e($uniqueTaxPercentages->first()); ?>%): <?php echo e(round($totalTaxValue,3)); ?></div>
    <?php else: ?>
        
        <?php $__currentLoopData = $order->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>الضريبة (<?php echo e($product->pivot->tax_percentage); ?>%): <?php echo e(round($product->pivot->tax_value,3)); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

      <div> المجموع النهائي : <?php echo e($order->total_prices - $order->total_discounts); ?> JD</div>
    </div>
  </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    function printInvoice() {
      window.print();
    }
  </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u167651649/domains/mutasemjaber.online/public_html/yaman/resources/views/admin/orders/show.blade.php ENDPATH**/ ?>