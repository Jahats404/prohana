<?php

namespace App\Http\Controllers\produsen\kelolaPesanan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::paginate(5);
        return view('produsen.asset.pesanan.index', compact('pesanan'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = Pesanan::findOrFail($id);
        return view('produsen.asset.produk.detail', compact('produk'));
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
