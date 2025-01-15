<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('cancellation_id');
            $table->float('total_refund'); 
            $table->string('bank_name')->nullable(); 
            $table->string('bank_account')->nullable();
            $table->string('bank_holder')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->timestamps('date_transfer');
            $table->enum('status', ['pending',  'approved', 'rejected', 'completed'])->default('pending'); 
            $table->foreign('cancellation_id')->references('id')->on('cancellations')->onDelete('CASCADE')->unique();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE')->unique();
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
        Schema::dropIfExists('refunds');
    }
}
