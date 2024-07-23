<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $primaryKey = "id_keranjang";
    protected $table = 'keranjang';
    protected $fillable = [
        'agen_id',
        'produk_id',
        'jumlah',
    ] ;

    public function agen()
    {
        return $this->belongsTo(Agen::class,'agen_id','id_agen');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class,'produk_id','id_produk');
    }
}