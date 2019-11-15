<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id');
            $table->integer('customer_id');
            $table->string('customer_phone');
            $table->string('deliver_address');
            $table->string('payment');
            $table->string('payment_status')->default(0);
            $table->integer('total_product')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('ship_price')->default(0);
            $table->integer('order_status')->default(0);
            $table->date('deliver_time')->nullable();
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
}
