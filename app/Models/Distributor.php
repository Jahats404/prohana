<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_distributor';
    protected $table = 'distributor';
    protected $fillable = [
        'nama_distributor',
        'alamat_distributor',
        'notelp_distributor',
        'domisili_distributor',
        'user_id',
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}