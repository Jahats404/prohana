<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardP()
    {
        $recentProducts = Produk::orderBy('created_at', 'desc')->limit(5)->get();
        return view('produsen.dashboard', compact('recentProducts'));
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
