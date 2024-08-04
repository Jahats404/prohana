<?php

namespace App\Http\Controllers\produsen\pengiriman;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengiriman = Pengiriman::simplePaginate(5);
        return view('produsen.asset.pengiriman.index', compact('pengiriman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // try {
            $decyptId = Crypt::decrypt($id);
            // dd($decyptId);
            $pesanan = Pesanan::with('produk')->find($decyptId);
            // dd($pesanan);
            $produk = Produk::all();
            $pengiriman = Pengiriman::find($decyptId);

            return view('produsen.asset.pengiriman.detail-pengiriman', compact('pesanan', 'produk','pengiriman'));
        // } catch (\Throwable $th) {
        //     Log::error('Failed to show Pesanan: ' . $th->getMessage());
        //     $status = 500; // This should be a variable, not a constant
        //     $message = 'Failed to create Pesanan. Server Error.';
        //     return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        //
    }
}