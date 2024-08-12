<?php

namespace App\Http\Controllers\produsen\garansi;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Garansi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ProdusenGaransiController extends Controller
{
    public function index()
    {
        $garansi = Garansi::where('status_garansi', '!=', 'Aktif' )->simplePaginate(5);
        // dd($garansi);

        return view('produsen.asset.garansi.index',compact('garansi'));
    }

    public function show($id)
    {
        $decryptId = Crypt::decrypt($id);
        try {
            $dtProduk = DetailPesanan::findOrFail($decryptId);
            return view('produsen.asset.garansi.detail-garansi', compact('dtProduk'));
        } catch (\Throwable $th) {
            Log::error('Failed to show Pesanan : ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to show Pesanan : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    public function verifikasi(Request $request, $id)
    {
        $decryptId = Crypt::decrypt($id);
        $garansi = Garansi::findOrFail($decryptId);
        $garansi->status_garansi = $request->status;
        $garansi->save();

        return redirect()->back()->with('success', 'Berhasil diterima');
    }

    public function printPdf()
    {   
        $garansi = Garansi::all();
        $pdf = Pdf::loadView('produsen.asset.garansi.cetak-pdf', compact('garansi'));
        
        return $pdf->stream('daftar_pengiriman.pdf'); // Mengunduh PDF
    }
}