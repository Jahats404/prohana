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

    public function show($id)
    {
        // Ambil produk beserta detailnya
        $product = Produk::with('detail_produk')
    ->where('id_produk', $id)
    ->firstOrFail();

        // Kelompokkan detail produk berdasarkan warna dan ukuran, dan hitung stok
        $detailProdukGrouped = $product->detail_produk
            ->groupBy(function ($item) {
                return $item->warna . '-' . $item->ukuran;
            })
            ->map(function ($group) {
                // Ambil item pertama dari kelompok (warna-ukuran yang sama)
                $firstItem = $group->first();
                // Hitung total stok untuk kelompok ini
                $totalStock = $group->count();
                return [
                    'warna' => $firstItem->warna,
                    'ukuran' => $firstItem->ukuran,
                    'stok' => $totalStock,
                    // Tambahkan field lain yang diperlukan
                ];
            });

        return view('agen.produk.detail', [
            'product' => $product,
            'detailProdukGrouped' => $detailProdukGrouped
        ]);
    }

    
}