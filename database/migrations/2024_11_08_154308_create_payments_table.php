<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('method_payment',['cod','online payment'])->default('cod');
            $table->float('total_bayar');
            $table->timestamps('date_payment');
            $table->enum('status',['paid','unpaid','pending','failed'])->default('unpaid');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE');
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
        Schema::dropIfExists('payments');
    }
}
