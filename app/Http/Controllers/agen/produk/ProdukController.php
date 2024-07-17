<?php

namespace App\Http\Controllers\agen\produk;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('agen.produk.index', compact('produk'));
    }
}
