<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_product_discount', function (Blueprint $table) {
            $table->increments('id');
            $table->string('discount_type')->nullable();
            $table->string('percentage')->nullable();
            $table->string('discount_condition')->nullable();
            $table->string('discount_qty')->nullable();
            $table->string('discount_purchase')->nullable();
            $table->string('discount_by')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('master_product_discount');
    }
}
