<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'id_produk',
        'foto_produk',
        'nama_produk',
        'kategori_produk',
        'jenis_produk',
        'harga',
        'stok',
        'produsen_id',
    ];

    public function produsen(){
        return $this->belongsTo(Produsen::class, 'produsen_id', 'id_produsen');
    }

    public function detail_produk()
    {
        return $this->hasMany(DetailProduk::class,'produk_id','id_produk');
    }
}