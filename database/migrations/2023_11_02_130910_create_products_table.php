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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->string('name_en');
            $table->string('description_en');
            $table->string('name_ar');
            $table->string('description_ar');
            $table->longText('attribute')->nullable();
            $table->longText('available_quantity');
            $table->tinyInteger('has_variation');
            $table->double('tax');
            $table->double('selling_price');
            $table->double('rating')->nullable();
            $table->double('total_rating')->nullable();
            $table->integer('min_order');
            $table->tinyInteger('status'); //0 not active //1 active
            $table->tinyInteger('is_featured'); //0 not //1 yes
            $table->tinyInteger('is_favourite')->default(0); //0 not //1 yes
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
        Schema::dropIfExists('products');
    }
};
