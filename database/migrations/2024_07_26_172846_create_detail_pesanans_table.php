<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_pesanans', function (Blueprint $table) {
            $table->id('id_detail_pesanan');
            $table->unsignedBigInteger('pesanan_id');
            $table->string('detail_produk_id');
            $table->date('tanggal_garansi')->nullable();
            // $table->integer('jumlah');
            $table->foreign('pesanan_id')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
            $table->foreign('detail_produk_id')->references('resi')->on('detail_produk')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanans');
    }
};