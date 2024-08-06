<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garansi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_garansi';
    protected $table = 'garansis';
    protected $fillable = [
        'detail_pesanan_id',
        'status_garansi',
        'catatan_garansi',
    ];

    public function detail_pesanan()
    {
        return $this->belongsTo(DetailPesanan::class,'detail_pesanan_id', 'id_detail_pesanan');
    }
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class,'garansi_id');
    }
    
}