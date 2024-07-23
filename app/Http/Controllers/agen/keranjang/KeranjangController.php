<?php

namespace App\Http\Controllers\agen\keranjang;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function keranjang(Request $request)
    {
        $items = json_decode($request->input('cart'), true);
        $user = auth()->user();
        $agen = $user->agen;
        // dd($agen->id_agen);
        foreach ($items as $item) {
            Keranjang::create([
                'agen_id' => $agen->id_agen,
                'produk_id' => $item['id_produk'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->back()->with('success','Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
    {
        $user = auth()->user();
        $agen = $user->agen;
        $keranjang = Keranjang::where('agen_id', $agen->id_agen)->get();
        // dd($keranjang);
        return view('agen.keranjang.index', compact('keranjang'));
    }
}