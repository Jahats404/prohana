<?php

namespace App\Http\Controllers\agen\pengiriman;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AgenPengirimanController extends Controller
{
    public function index()
    {
        $agenId = Auth()->user()->agen->id_agen;
        // $pengiriman = Pengiriman::where()->simplePaginate(5);
        $pengiriman = Pengiriman::whereHas('pesanan', function($query) use ($agenId) {
            $query->where('agen_id', $agenId);
        })->simplePaginate(5);
        // dd($pengiriman);
        
        return view('agen.pengiriman.index', compact('pengiriman'));
    }

    public function show($id)
    {
        // try {
            $decyptId = Crypt::decrypt($id);
            // dd($decyptId);
            $pengiriman = Pengiriman::find($decyptId);
            $pesanan = Pesanan::with('produk')->find($pengiriman->pesanan_id);
            // dd($pesanan);
            $produk = Produk::all();
            $pengiriman = Pengiriman::with('pesanan.agen', 'distributor') // Pastikan relasi telah didefinisikan
                            ->findOrFail($decyptId);
            return view('agen.pengiriman.detail-pengiriman', compact('pesanan', 'produk','pengiriman'));
        // } catch (\Throwable $th) {
        //     Log::error('Failed to show Pesanan: ' . $th->getMessage());
        //     $status = 500; // This should be a variable, not a constant
        //     $message = 'Failed to create Pesanan. Server Error.';
        //     return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }
}