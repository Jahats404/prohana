<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produsen extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_produsen';
    protected $table = 'produsen';
    protected $fillable = [
        'nama_produsen',
        'alamat_produsen',
        'notelp_produsen',
        'domisili_produsen',
        'user_id',
    ] ;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}