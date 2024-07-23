<?php

namespace App\Http\Controllers\distributor\pesanan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $distributor = $user->distributor;
        $pesanan = Pesanan::whereHas('agen', function ($query) use($distributor) {
            $query->where('domisili_agen', $distributor->domisili_distributor);
        })->get();
        // dd($pesanan);
        return view('distributor.pesanan.index', compact('pesanan'));
    }
}