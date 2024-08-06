<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimans';
    protected $primaryKey = 'id_pengiriman';

    protected $fillable = [
        'distributor_id',
        'pesanan_id',
        'status_pengiriman',
        'jenis_pengiriman',
        'tanggal_pengiriman',
    ];

    protected $casts = [
        'tanggal_pengiriman' => 'date',
        'status_pengiriman' => 'string',
        'jenis_pengiriman' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Define relationships if you have models for Distributor and Pesanan
    public function distributor()
    {
        return $this->belongsTo(Distributor::class, 'distributor_id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id_pesanan');
    }
    public function garansi()
    {
        return $this->belongsTo(Garansi::class, 'garansi_id');
    }
}