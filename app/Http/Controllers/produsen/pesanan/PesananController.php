<?php

namespace App\Http\Controllers\produsen\pesanan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
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
        $pesanan = Pesanan::paginate(5);
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
    public function update(Request $request, Pesanan $pesanan)
    {
        //
    }

    public function updateStatus(Request $request, $id){
        $pesanan = Pesanan::findOrFail($id);
        try {
            $pesanan->update([
                'status_pesanan' => $request->status_pesanan
            ]);
            return redirect()->back()->with('success', 'Status pesanan berhasil diubah');
        } catch (\Throwable $th) {
            Log::error('Failed to update status pesanan: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to update status pesanan. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }
}
