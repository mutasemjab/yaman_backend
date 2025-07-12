<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('order_status')->default(1);  // 1 Pending // 2 confirmed //3 OnTheWay //4 Cancelled // 5 Failed // 6 Refund // 7 DELIVERD
            $table->double('total_taxes');
            $table->double('delivery_fee');
            $table->double('total_prices');
            $table->double('total_discounts');
            $table->string('payment_type');
            $table->tinyInteger('payment_status')->default(2); // 1 Paid   // 2 Unpaid
            $table->dateTime('date');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
