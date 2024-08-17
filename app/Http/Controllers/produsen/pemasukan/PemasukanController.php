<?php

namespace App\Http\Controllers\produsen\pemasukan;

use Carbon\Carbon;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PemasukanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $bulan = $request->bulan;

        // Mendapatkan tanggal awal dan akhir dari bulan yang ditentukan
        $tanggalAwal = Carbon::parse($bulan)->startOfMonth()->format('Y-m-d');
        $tanggalAkhir = Carbon::parse($bulan)->endOfMonth()->format('Y-m-d');

        // Mengambil data pesanan berdasarkan rentang tanggal
        $pesanans = Pesanan::whereBetween('tanggal_pesan', [$tanggalAwal, $tanggalAkhir])
                    ->where('status_pesanan', '!=', 'Rejected')->get();

        $totals = $pesanans->sum('total_harga');

        // Mengembalikan view Blade dan meneruskan data
        return view('produsen.asset.pemasukan.pemasukan', compact('pesanans', 'totals'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
