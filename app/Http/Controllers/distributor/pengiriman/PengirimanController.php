<?php

namespace App\Http\Controllers\distributor\pengiriman;

use App\Http\Controllers\Controller;
use App\Models\Agen;
use App\Models\Pengiriman;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::all();
        $user = auth()->user();
        $distributor = $user->distributor;
        dd($distributor);
        return view('distributor.pengiriman.index', compact('pengiriman','agen'));
    }
}