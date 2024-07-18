<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardP()
    {
        $recentProducts = Produk::orderBy('created_at', 'desc')->limit(5)->get();
        $countUsers = User::count();
         // Menghitung jumlah pesanan dengan status pesanan 'pending'
        $pendingPesananCount = Pesanan::whereStatusPesanan('pending')->count();

        // Menghitung jumlah pengiriman dengan status pengiriman 'pending'
        $pendingPengirimanCount = Pengiriman::whereStatusPengiriman('pending')->count();

        $totalPesananByAccepted = Pesanan::whereStatusPesanan('accepted')->sum('total_harga');
        // Total jumlah pesanan dan pengiriman yang pending
        $totalPendingCount = $pendingPesananCount + $pendingPengirimanCount;

        return view('produsen.dashboard', compact('recentProducts', 'pendingPesananCount', 'countUsers', 'totalPendingCount', 'totalPesananByAccepted'));
    }

    public function dashboardA()
    {
        return view('agen.dashboard');
    }

    public function dashboardD()
    {
        return view('distributor.dashboard');
    }
}
