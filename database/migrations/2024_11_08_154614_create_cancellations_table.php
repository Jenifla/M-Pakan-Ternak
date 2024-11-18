<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancellationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancellations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('status_pembatalan',['pending','ditolak','disetujui'])->default('pending');
            $table->timestamps('tgl_diajukan');
            $table->timestamps('tgl_diproses');
            $table->string('alasan');
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
        Schema::dropIfExists('cancellations');
    }
}
