<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detail_pesanans';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_detail_pesanan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pesanan_id',
        // 'produk_id',
        'tanggal_garansi',
        // 'jumlah',
        'detail_produk_id',
    ];

    /**
     * Get the pesanan that owns the detail pesanan.
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id', 'id_pesanan');
    }

    /**
     * Get the produk associated with the detail pesanan.
     */
    public function detail_produk()
    {
        return $this->belongsTo(DetailProduk::class, 'detail_produk_id', 'resi');
    }

    public function garansi()
    {
        return $this->hasOne(Garansi::class,'detail_pesanan_id', 'id_detail_pesanan');
    }
}