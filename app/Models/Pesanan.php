<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanans';
    protected $primaryKey = 'id_pesan';
    protected $fillable = [
        'produk_id',
        'agen_id',
        'tanggal_pesanan',
        'status_pesanan',
        'catatan_pesanan',
    ];
}
