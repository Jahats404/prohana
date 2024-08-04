<?php

namespace App\Http\Controllers\distributor\pengiriman;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengirimanRequest;
use App\Models\Agen;
use App\Models\Pengiriman;
use App\Models\Pesanan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PengirimanController extends Controller
{
    public function index()
    {
        $pengiriman = Pengiriman::all();
        $user = auth()->user();
        $distributor = $user->distributor;
        $pesanan = Pesanan::whereHas('agen', function ($query) use($distributor) {
            $query->where('domisili_agen', $distributor->domisili_distributor);
        })->get();
        
        return view('distributor.pengiriman.index', compact('pengiriman','distributor','pesanan'));
    }

    public function store(Request $request)
    {
        $rules = [
            'jenis_pengiriman' => 'required',
            'tanggal_pengiriman'=> 'required',
        ];
        $messages = [
            'jenis_pengiriman.required'=> 'Jenis pengiriman tidak boleh kosong!',
            'tanggal_pengiriman.required'=> 'Tanggal Pengiriman tidak boleh kosong!',
        ];
        $dateNow = Carbon::now()->toDateString();
        $validator = Validator::make(request()->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else if ($request->tanggal_pengiriman < $dateNow ) {
            return redirect()->back()->withErrors('Tanggal tidak valid!');
        }
        
        $user = auth()->user();
        $distributor = $user->distributor;
        $pengiriman = new Pengiriman();
        $pengiriman->distributor_id = $distributor->id_distributor;
        $pengiriman->pesanan_id = $request->pesanan_id;
        $pengiriman->status_pengiriman = 'Sedang Diproses';
        $pengiriman->jenis_pengiriman = $request->jenis_pengiriman;
        $pengiriman->tanggal_pengiriman = $request->tanggal_pengiriman;
        $pengiriman->save();

        return redirect()->back()->with('success','Pengiriman berhasil ditambahkan');
    }

    public function show($id)
    {
        // try {
            $decyptId = Crypt::decrypt($id);
            // dd($decyptId);
            $pengiriman = Pengiriman::find($decyptId);
            $pesanan = Pesanan::with('produk')->find($pengiriman->pesanan_id);
            // dd($pesanan);
            $produk = Produk::all();
            $pengiriman = Pengiriman::with('pesanan.agen', 'distributor') // Pastikan relasi telah didefinisikan
                            ->findOrFail($decyptId);
            return view('distributor.pengiriman.detail-pengiriman', compact('pesanan', 'produk','pengiriman'));
        // } catch (\Throwable $th) {
        //     Log::error('Failed to show Pesanan: ' . $th->getMessage());
        //     $status = 500; // This should be a variable, not a constant
        //     $message = 'Failed to create Pesanan. Server Error.';
        //     return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }

    public function status(Request $request, $id)
    {
        $decryptId = Crypt::decrypt($id);
        $pengiriman = Pengiriman::findOrFail($decryptId);
        if ($pengiriman->status == 'Sedang Diproses') {
            # code...
        } else {
            # code...
        }
        
        $pengiriman->status_pengiriman = $request->status;
        $pengiriman->save();

        return redirect()->back()->with('success','Status Pengiriman berhasil diubah');
    }
}