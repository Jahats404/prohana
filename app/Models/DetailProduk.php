<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailProduk extends Model
{
    use HasFactory;

    protected $primaryKey = 'resi';
    protected $casts = ['resi' => 'string'];
    protected $table = 'detail_produk';
    protected $fillable = [
        'resi',
        'ukuran',
        'warna',
        'status',
        'produk_id',
    ];
    
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }

    public function detail_pesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'detail_produk_id', 'id_detail_produk');
    }
}