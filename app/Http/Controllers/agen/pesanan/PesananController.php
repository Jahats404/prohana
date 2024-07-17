<?php

namespace App\Http\Controllers\agen\pesanan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PesananRequest;
use App\Models\Agen;
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
        // try {
            $agenId = auth()->user()->agen->id_agen;
            Pesanan::create([
                'produk_id' => $validateDate['produk_id'],
                'agen_id' => $agenId,
                'tanggal_pesan' => $validateDate['tanggal_pesan'],
                'status_pesanan' => $validateDate['status_pesanan'],
                'total_harga' => $validateDate['total_harga'],
            ]);
            return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan');
        // } catch (\Throwable $th) {
        //     Log::error('Failed to create Distributor: ' . $th->getMessage());
        //     $status = 500; // This should be a variable, not a constant
        //     $message = 'Failed to create Pesanan. Server Error.';
        //     return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan, $id)
    {
        $decyptId = Crypt::decrypt($id);
        $pesanan = Pesanan::findOrFail($decyptId);
        $produks = Produk::all();
        return view('agen.pesanan.detail-pesanan', compact('pesanan', 'produks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }
}
