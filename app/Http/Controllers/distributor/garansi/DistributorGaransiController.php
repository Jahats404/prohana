<?php

namespace App\Http\Controllers\distributor\garansi;

use App\Http\Controllers\Controller;
use App\Models\Garansi;
use Illuminate\Http\Request;

class DistributorGaransiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $distributor = $user->distributor;

        $garansi = Garansi::
                whereNotIn('status_garansi', ['Aktif', 'Diajukan'])
                    ->whereHas('detail_pesanan', function ($query) use ($distributor) {
                        $query->whereHas('pesanan', function ($query) use ($distributor) {
                            $query->whereHas('agen', function ($query) use ($distributor) {
                                $query->where('domisili_agen', $distributor->domisili_distributor);
                            });
                        });
                    })
                    ->get();
        return view('distributor.garansi.index', compact('garansi'));
    }
}