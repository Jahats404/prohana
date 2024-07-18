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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk');
            $table->text('foto_produk')->nullable();
            $table->string('nama_produk');
            $table->enum('kategori_produk', ['pria', 'wanita', 'anak']);
            $table->enum('jenis_produk', ['sepatu', 'sandal', 'tas', 'jaket', 'sabuk']);
            $table->integer('harga');
            $table->unsignedBigInteger('produsen_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
