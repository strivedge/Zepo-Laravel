<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('card_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->integer('transaction_payment_id')->nullable();

            $table->boolean('is_guest')->nullable();
            $table->string('customer_first_name')->nullable();
            $table->string('customer_last_name')->nullable();
            $table->integer('customer_id', 200)->nullable();
            $table->string('customer_email', 200)->nullable();
            $table->string('customer_contact', 200)->nullable();
            $table->string('customer_email', 200)->nullable();
            $table->decimal('sub_total', 12,4)->default(0);
            $table->decimal('grand_total', 12,4)->default(0);
            $table->decimal('amount', 12,4)->default(0);
            $table->decimal('amount_captured', 12,4)->default(0);
            $table->string('payment_method', 200)->nullable();
            $table->string('pay_method', 200)->nullable();
            $table->string('currency', 200)->nullable();
            $table->string('payment_status', 200)->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('order_transactions');
    }
}
