<?php

namespace App\Http\Controllers\agen\produk;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\DetailProduk;
use App\Models\Garansi;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class BarangController extends Controller
{
    public function index()
    {
        // try {
            // Ambil ID agen dari user yang login
            $agenId = auth()->user()->agen->id_agen;
            
            // Ambil pesanan yang statusnya "accepted" untuk agen yang login
            $pesanans = Pesanan::where('agen_id', $agenId)
            ->where('status_pesanan', 'accepted')
            ->pluck('id_pesanan');

            // Ambil detail produk dengan status "Dipesan" atau "Terjual" yang tanggal garansi belum melewati tanggal sekarang
            $detailProduks = DetailProduk::whereHas('detail_pesanan', function($query) use ($pesanans) {
                $query->whereIn('pesanan_id', $pesanans);
                    // ->where('tanggal_garansi', '>=', now()); // Memeriksa tanggal garansi
            })
            ->where(function($query) {
                $query->where('status', 'Dipesan')
                    ->orWhere('status', 'Terjual');
            })
            ->get();

            foreach ($detailProduks as $item) {
                // Ambil DetailPesanan terkait
                $dtPesanan = DetailPesanan::where('detail_produk_id', $item->resi)->first();
                // dd($dtPesanan);
                // Pastikan DetailPesanan ada sebelum memeriksa tanggal_garansi
                if ($dtPesanan && $dtPesanan->tanggal_garansi < now()) {
                    // Update status garansi
                    $garansi = Garansi::where('detail_pesanan_id', $dtPesanan->id_detail_pesanan)->first();
            
                    // Pastikan Garansi ada sebelum mengupdate status
                    if ($garansi) {
                        $garansi->update(['status_garansi' => 'Kadaluwarsa']);
                    }
                }
            }
                            // dd($detailProduks);
    // dd($detailProduks);
            // Ambil semua produk (jika diperlukan dalam tampilan)
            $produks = Produk::all();
    
            return view('agen.barang.tersedia.index', compact('pesanans', 'detailProduks'));
        // } catch (\Throwable $th) {
        //     Log::error('Failed to show Pesanan: ' . $th->getMessage());
        //     $status = 500; // This should be a variable, not a constant
        //     $message = 'Failed to show Pesanan. Server Error.';
        //     return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }

    public function terjual($id)
    {
        // $decId = Crypt::decrypt($id);
        // dd($id);
        $dtPesanan = DetailPesanan::where('detail_produk_id',$id)->first();
        $dtPesanan->tanggal_garansi = now()->addMonths(2);
        $dtPesanan->save();
        
        $dtProduk = DetailProduk::findOrFail($id);
        $dtProduk->status = 'Terjual';
        $dtProduk->save();
        // dd($dtProduk);

        $garansi = new Garansi();
        $garansi->detail_pesanan_id = $dtPesanan->id_detail_pesanan;
        $garansi->status_garansi = 'Aktif';
        $garansi->save();

        return redirect()->back()->with('success', 'Barang berhasil terjual dan garansi mulai Aktif');
    }
}