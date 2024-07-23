<?php

namespace App\Http\Controllers\distributor\pengiriman;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengirimanRequest;
use App\Models\Agen;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::all();
        $user = auth()->user();
        $distributor = $user->distributor;
        $pesanan = Pesanan::whereHas('agen', function ($query) use($distributor) {
            $query->where('domisili_agen', $distributor->domisili_distributor);
        })->get();
        
        return view('distributor.pengiriman.index', compact('pengiriman','distributor','pesanan'));
    }

    public function store(PengirimanRequest $request)
    {
        
    }
}