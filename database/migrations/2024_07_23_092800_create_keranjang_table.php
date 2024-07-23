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
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang')->primary();
            $table->unsignedBigInteger('agen_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('jumlah');
            $table->timestamps();

            $table->foreign('agen_id')->references('id_agen')->on('agen')->onDelete('cascade');
            $table->foreign('produk_id')->references('id_produk')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};