<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanans';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'agen_id',
        'tanggal_pesan',
        'status_pesanan',
        'total_harga',
    ];

    public function agen()
    {
        return $this->belongsTo(Agen::class, 'agen_id', 'id_agen');
    }
    public function produk()
    {
        return $this->belongsTo(Produk::class,'produk_id','id_produk');
    }
    public function detail_pesanan(){
        return $this->hasOne(DetailPesanan::class,'pesanan_id','id_pesanan');
    }
}