<?php

namespace App\Http\Controllers\produsen\pesanan;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::simplePaginate(5);
        // dd($pesanan);
        // $bulan = "2024-07";
        // $date = Carbon::parse($bulan);
        // $startOfMonth = $date->startOfMonth()->toDateString();
        // $endOfMonth = $date->endOfMonth()->toDateString();
        
        // if ($bulan) {
        //     $pesanan = Pesanan::whereBetween('tanggal_pesan', [$startOfMonth, $endOfMonth])->get();
        //         dd($pesanan);
        // } else {
        //     $pesanan = Pesanan::all();
        //     dd($pesanan);
        // }
        
        
        return view('produsen.asset.pesanan.index', compact('pesanan'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $decryptId = Crypt::decrypt($id);
        try {
            $pesanan = Pesanan::findOrFail($decryptId);
            return view('produsen.asset.pesanan.detail-pesanan', compact('pesanan'));
        } catch (\Throwable $th) {
            Log::error('Failed to show Pesanan : ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to show Pesanan : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    public function verif(Request $request, $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function updateStatus(Request $request, $id){
        $pesanan = Pesanan::findOrFail($id);
        // dd($pesanan);
        // try {
            $pesanan->update([
                'status_pesanan' => $request->status
            ]);
            // Check if the status is 'accepted'
            if ($request->status == 'accepted') {
                // Update the 'tanggal_garansi' for related DetailPesanan entries
                $detailPesan = DetailPesanan::wherePesananId($pesanan->id_pesanan)->get();
                
                // foreach ($detailPesan as $detail) {
                //     $detail->update([
                //         'tanggal_garansi' => now()->addMonths(2)
                //     ]);
                // }
            }
            return redirect()->back()->with('success', 'Status pesanan berhasil diubah');
        // } catch (\Throwable $th) {
            // Log::error('Failed to update status pesanan: ' . $th->getMessage());
            // $status = 500; // This should be a variable, not a constant
            // $message = 'Failed to update status pesanan. Server Error.';
            // return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }

    public function filter(Request $request)
    {
        $bulan = $request->query('bulan');
        
        if ($bulan) {
            $pesanans = Pesanan::whereMonth('tanggal_pesan', date('m', strtotime($bulan)))
                ->whereYear('tanggal_pesan', date('Y', strtotime($bulan)))
                ->get();
        } else {
            $pesanan = Pesanan::all();
        }
        // Mengenkripsi ID pesanan
        $pesanans = $pesanans->map(function ($pesanan) {
            $pesanan->encrypted_id = Crypt::encrypt($pesanan->id_pesanan);
            return $pesanan;
        });

        return response()->json($pesanans);
    }

    public function printPdf(Request $request)
    {
        $bulan = $request->bulan;

        // Mendapatkan tanggal awal dan akhir dari bulan yang ditentukan
        $tanggalAwal = Carbon::parse($bulan)->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = Carbon::parse($bulan)->endOfMonth()->format('Y-m-d');

        // Mengambil data pesanan berdasarkan rentang tanggal
        $pesanans = Pesanan::whereBetween('tanggal_pesan', [$tanggalAwal, $tanggalAkhir])->get();
        
        $pdf = Pdf::loadView('produsen.asset.pesanan.cetak-pdf', compact('pesanans'));

        return $pdf->stream('daftar_pesanan.pdf'); // Mengunduh PDF
    }

    public function cetakPdf($id)
    {
        $pesanan = Pesanan::with(['detail_pesanan.detail_produk.produk'])->findOrFail($id);
        
        $pdf = Pdf::loadView('produsen.asset.pesanan.pdf-pesanan', compact('pesanan'));
        
        return $pdf->stream('detail_pesanan_' . $pesanan->id_pesanan . '.pdf');
    }

    
}