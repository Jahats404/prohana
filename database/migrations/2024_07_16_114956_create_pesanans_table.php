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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('agen_id');
            // $table->unsignedBigInteger('produk_id');
            // $table->foreign('produk_id')->references('id_produk')->on('produk')->onDelete('cascade');
            // $table->foreign('agen_id')->references('id_agen')->on('agen')->onDelete('cascade');
            $table->date('tanggal_pesan');
            $table->enum('status_pesanan', ['pending', 'accepted', 'rejected']);
            $table->string('keterangan')->nullable();
            $table->bigInteger('total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};