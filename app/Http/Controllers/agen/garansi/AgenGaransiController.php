<?php

namespace App\Http\Controllers\agen\garansi;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Garansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AgenGaransiController extends Controller
{
    public function klaim_garansi(Request $request, $id)
    {
        $decId = Crypt::decrypt($id);
        $dtPesanan = DetailPesanan::where('detail_produk_id', $decId)->first();
        
        $garansi = Garansi::where('detail_pesanan_id', $dtPesanan->id_detail_pesanan)->first();
        // dd($dtPesanan->id_detail_pesanan);
        // Pastikan objek Garansi ditemukan sebelum memperbarui
        if ($garansi) {
            // Mengatur nilai catatan_garansi
            $garansi->status_garansi = 'Diajukan';
            $garansi->catatan_garansi = $request->catatan_garansi;
            
            // Simpan perubahan
            $garansi->save();
        } else {
            return redirect()->back()->withErrors('Gagal klaim, data tidak ditemukan!');
        }
        return redirect()->back()->with('success', 'Berhasil diajukan');
    }
}