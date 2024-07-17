<?php

namespace App\Http\Controllers\agen\pesanan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PesananRequest;
use App\Models\Agen;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUser = auth()->user()->id;
        $idAgen = Agen::whereUserId($idUser)->first()->id_agen;
        $pesanan = Pesanan::whereAgenId($idAgen)->get();
        $produks = Produk::all();
        return view('agen.pesanan.index', compact('pesanan', 'produks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PesananRequest $request)
    {
        $validateDate = $request->validated();
        try {
            $agenId = auth()->user()->agen->id_agen;
            $pesanan = Pesanan::create([
                'produk_id' => $validateDate['produk_id'],
                'agen_id' => $agenId,
                'tanggal_pesan' => $validateDate['tanggal_pesan'],
                'status_pesanan' => $validateDate['status_pesanan'],
                'total_harga' => $validateDate['total_harga'],
            ]);
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id_pesanan,
                'produk_id' => $validateDate['produk_id'],
                'jumlah' => $validateDate['jumlah'],
            ]);
            return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan');
        } catch (\Throwable $th) {
            Log::error('Failed to create Pesanan: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to create Pesanan. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan, $id)
    {
        try {
            $decyptId = Crypt::decrypt($id);
            $pesanan = Pesanan::findOrFail($decyptId);
            $produks = Produk::all();
            return view('agen.pesanan.detail-pesanan', compact('pesanan', 'produks'));
        } catch (\Throwable $th) {
            Log::error('Failed to show Pesanan: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to create Pesanan. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    public function getProductPrice($id)
    {
        $product = Produk::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['harga' => $product->harga]);
    }
}
