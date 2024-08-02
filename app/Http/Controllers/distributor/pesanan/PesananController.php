<?php

namespace App\Http\Controllers\distributor\pesanan;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $distributor = $user->distributor;
        // $pesanan = Pesanan::whereHas('agen', function ($query) use($distributor) {
        //     $query->where('domisili_agen', $distributor->domisili_distributor);
        // })->get();
        $existingPesananIds = Pengiriman::pluck('pesanan_id')->toArray();
        
        $pesanan = Pesanan::whereHas('agen', function ($query) use ($distributor) {
            $query->where('domisili_agen', $distributor->domisili_distributor);
        })
        ->whereNotIn('id_pesanan', $existingPesananIds)
        ->get();
        // dd($pesanan);
        return view('distributor.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $decryptId = Crypt::decrypt($id);
        try {
            $pesanan = Pesanan::findOrFail($decryptId);
            return view('distributor.pesanan.detail-pesanan', compact('pesanan'));
        } catch (\Throwable $th) {
            Log::error('Failed to show Pesanan : ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to show Pesanan : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
}