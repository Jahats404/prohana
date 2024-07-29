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
        Schema::create('detail_produk', function (Blueprint $table) {
            $table->string('resi')->primary();
            $table->string('ukuran');
            $table->string('warna');
            $table->string('status');
            $table->unsignedBigInteger('produk_id');
            $table->timestamps();
            $table->foreign('produk_id')->references('id_produk')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_produk');
    }
};