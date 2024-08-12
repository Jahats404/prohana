<?php

namespace App\Http\Controllers\produsen\pengiriman;

use App\Http\Controllers\Controller;
use App\Models\Pengiriman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProdusenPengirimanController extends Controller
{
    public function filter(Request $request)
    {
        $bulan = $request->query('bulan');
        
        if ($bulan) {
            $pengirimans = Pengiriman::with('distributor') // Eager load the distributor relation
                ->select('pengirimans.*', 
                        'distributor.nama_distributor', 
                        'distributor.domisili_distributor')
                ->join('distributor', 'pengirimans.distributor_id', '=', 'distributor.id_distributor')
                ->whereMonth('tanggal_pengiriman', date('m', strtotime($bulan)))
                ->whereYear('tanggal_pengiriman', date('Y', strtotime($bulan)))
                ->get();
                // dd($pengirimans);
        } else {
            $pengirimans = Pengiriman::with('distributor') // Eager load the distributor relation
                ->select('pengirimans.*', 
                        'distributor.nama_distributor', 
                        'distributor.domisili_distributor')
                ->join('distributor', 'pengirimans.distributor_id', '=', 'distributor.id_distributor')
                ->get();
        }
        $pengirimans = $pengirimans->map(function ($pengirimans) {
            $pengirimans->encrypted_id = Crypt::encrypt($pengirimans->id_pengiriman);
            return $pengirimans;
        });

        return response()->json($pengirimans);
    }

    public function printPdf(Request $request)
    {
        $bulan = $request->bulan;

        // Mendapatkan tanggal awal dan akhir dari bulan yang ditentukan
        $tanggalAwal = Carbon::parse($bulan)->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = Carbon::parse($bulan)->endOfMonth()->format('Y-m-d');

        // Mengambil data pesanan berdasarkan rentang tanggal
        $pengirimans = Pengiriman::whereBetween('tanggal_pengiriman', [$tanggalAwal, $tanggalAkhir])->get();
        
        $pdf = Pdf::loadView('produsen.asset.pengiriman.cetak-pdf', compact('pengirimans'));
        
        return $pdf->stream('daftar_pengiriman.pdf'); // Mengunduh PDF
    }
}