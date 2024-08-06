<?php

namespace App\Http\Controllers\agen\pengiriman;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class AgenPengirimanGaransiController extends Controller
{
    public function index()
    {
        $agenId = Auth()->user()->agen->id_agen;
        // $pengiriman = Pengiriman::where()->simplePaginate(5);
        $pengiriman = Pengiriman::whereHas('garansi.detail_pesanan.pesanan', function($query) use ($agenId) {
            $query->where('agen_id', $agenId);
        })->simplePaginate(5);
        
        return view('agen.pengiriman.garansi.index', compact('pengiriman'));
    }

    public function show($id)
    {
        $decryptId = Crypt::decrypt($id);
        try {
            $dtProduk = DetailPesanan::findOrFail($decryptId);
            return view('agen.pengiriman.garansi.detail-pengiriman', compact('dtProduk'));
        } catch (\Throwable $th) {
            Log::error('Failed to show Pesanan : ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to show Pesanan : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
}