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
            $table->unsignedBigInteger('pesanan_id');
            $table->foreign('pesanan_id')->references('id_pesanan')->on('pesanans')->onDelete('cascade');
            $table->enum('status_garansi', ['active', 'expired']);
            $table->text('catatan_garansi');
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
