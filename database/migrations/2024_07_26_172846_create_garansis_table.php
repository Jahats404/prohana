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
        Schema::create('garansis', function (Blueprint $table) {
            $table->id('id_garansi');
            $table->unsignedBigInteger('detail_pesanan_id');
            $table->foreign('detail_pesanan_id')->references('id_detail_pesanan')->on('detail_pesanans')->onDelete('cascade');
            $table->enum('status_garansi', ['Aktif', 'Kadaluwarsa', 'Diajukan', 'Diproses', 'Pengiriman ke Produsen', 'Pengiriman ke Agen']);
            $table->text('catatan_garansi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garansis');
    }
};
