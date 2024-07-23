<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agen extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_agen';
    protected $table = 'agen';
    protected $fillable = [
        'nama_agen',
        'alamat_agen',
        'notelp_agen',
        'domisili_agen',
        'user_id',
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class,'agen_id','id_agen');
    }
}