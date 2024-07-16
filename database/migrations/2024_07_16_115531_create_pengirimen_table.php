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
            $table->unsignedBigInteger('pesanan_id');
            $table->foreign('distributor_id')->references('id_distributor')->on('distributor')->onDelete('cascade');
            $table->foreign('pesanan_id')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
            $table->enum('status_pengiriman', ['pending', 'accepted', 'rejected']);
            $table->string('jenis_pengiriman');
            $table->date('tanggal_pengiriman');
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
