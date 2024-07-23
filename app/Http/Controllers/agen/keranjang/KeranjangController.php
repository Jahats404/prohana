<?php

namespace App\Http\Controllers\agen\keranjang;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function checkout(Request $request)
    {
        $items = $request->all();

        foreach ($items as $item) {
            Keranjang::create([
                'id_produk' => $item['id_produk'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang.'], 200);
    }
}