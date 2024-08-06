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
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->unsignedBigInteger('distributor_id');
            $table->unsignedBigInteger('pesanan_id')->nullable();
            $table->unsignedBigInteger('garansi_id')->nullable();
            $table->foreign('distributor_id')->references('id_distributor')->on('distributor')->onDelete('cascade');
            $table->foreign('pesanan_id')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
            $table->foreign('garansi_id')->references('id_garansi')->on('garansis')->onDelete('cascade');
            $table->enum('status_pengiriman', ['Sedang Diproses', 'Dalam Perjalanan', 'Sampai Tujuan']);
            $table->string('jenis_pengiriman');
            $table->date('tanggal_pengiriman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};