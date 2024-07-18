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
        'produk_id',
        'tanggal_garansi',
        'jumlah',
    ];

    /**
     * Get the pesanan that owns the detail pesanan.
     */
    public function pesanan()
    {
        return $this->hasOne(Pesanan::class, 'pesanan_id', 'id_pesanan');
    }

    /**
     * Get the produk associated with the detail pesanan.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id_produk');
    }
}
