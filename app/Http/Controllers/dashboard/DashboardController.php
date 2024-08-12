<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agen;
use App\Models\DetailProduk;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardP()
    {
        $agen = Agen::count();
        $pesanan = Pesanan::where('status_pesanan', 'pending')->count();
        $pengiriman = Pengiriman::where('status_pengiriman', 'Dalam Perjalanan')->count();
        $produk = Produk::count();
        $recentProducts = Produk::orderBy('created_at', 'desc')->limit(5)->get();
        return view('produsen.dashboard', compact('recentProducts','agen','pesanan','pengiriman','produk'));
    }

    public function getProductTrends()
    {
        $productTrends = DB::table('detail_produk')
                    ->join('produk', 'detail_produk.produk_id', '=', 'produk.id_produk')
                    ->select('produk.nama_produk', DB::raw('COUNT(detail_produk.produk_id) as jumlah_terjual'))
                    ->where('detail_produk.status', 'Terjual') // Tambahkan kondisi untuk status 'Terjual'
                    ->groupBy('produk.id_produk', 'produk.nama_produk')
                    ->orderBy('jumlah_terjual', 'desc')
                    ->get();

        return response()->json($productTrends);
    }

    public function dashboardA()
    {
        $userId = Auth()->user()->agen->id_agen;
        $pesanan = Pesanan::where('agen_id', $userId)->count();
        $pengiriman = Pengiriman::where('status_pengiriman', 'Dalam Perjalanan')->count();
        $recentProducts = Produk::orderBy('created_at', 'desc')->limit(5)->get();
        $jumlahTerjual = DetailProduk::where('status', 'Terjual')
            ->join('detail_pesanans', 'detail_pesanans.detail_produk_id', '=', 'detail_produk.resi')
            ->join('pesanans', 'detail_pesanans.pesanan_id', '=', 'pesanans.id_pesanan')
            ->where('pesanans.agen_id', $userId)
            ->count('detail_produk.resi');
            
        return view('agen.dashboard', compact('pesanan','jumlahTerjual','recentProducts'));
    }

    public function dashboardD()
    {
        $pesanan = Pengiriman::whereIn('status_pengiriman', ['Sedang Diproses', 'Dalam Perjalanan'])->where('jenis_pengiriman', 'Pesanan')->count();
        $garansi = Pengiriman::whereIn('status_pengiriman', ['Sedang Diproses', 'Dalam Perjalanan'])->where('jenis_pengiriman', 'Garansi')->count();
        
        
        return view('distributor.dashboard', compact('pesanan', 'garansi'));
    }
}