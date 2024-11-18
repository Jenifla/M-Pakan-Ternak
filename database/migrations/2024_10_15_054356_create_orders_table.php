<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->float('ongkir');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->float('total_amount');
            $table->enum('status',['new','to pay','to ship', 'to receive', 'completed', 'cancel','rejected'])->default('new');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('address_id')->references('id')->on('address')->onDelete('SET NULL');
            $table->foreign('shipping_id')->references('id')->on('shippings')->onDelete('SET NULL');
            $table->string('alasan');
            $table->timestamps('date_order');
            $table->timestamps('date_packed');
            $table->timestamps('date_sent');
            $table->timestamps('date_cancel');
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
