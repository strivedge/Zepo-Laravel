<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterFestivalProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_festival', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->longtext('short_desc')->nullable();
            $table->longtext('long_desc')->nullable();
            $table->string('image')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::create('master_festival_products', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('master_festival')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_festival');
        Schema::dropIfExists('master_festival_products');
    }
}
