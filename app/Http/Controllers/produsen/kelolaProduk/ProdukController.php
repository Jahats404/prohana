<?php

namespace App\Http\Controllers\produsen\kelolaProduk;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdukRequest;
use App\Models\Produk;
use App\Models\Produsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::all();
        $produsen = Produsen::all();
        return view('produsen.asset.produk.index', compact('produk', 'produsen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukRequest $request)
    {
        $validateData = $request->validated();
        try {
            $fileImage = $request->file('foto_produk');
            if(!$fileImage){
                Produk::create([
                    'nama_produk' => $validateData['nama_produk'],
                    'kategori_produk' => $validateData['kategori_produk'],
                    'jenis_produk' => $validateData['jenis_produk'],
                    'harga' => $validateData['harga'],
                    'produsen_id' => $validateData['produsen_id'],
                ]);
            }else{
                Produk::create([
                    'nama_produk' => $validateData['nama_produk'],
                    'kategori_produk' => $validateData['kategori_produk'],
                    'jenis_produk' => $validateData['jenis_produk'],
                    'harga' => $validateData['harga'],
                    'foto_produk' => $fileImage->hashName(),
                    'produsen_id' => $validateData['produsen_id'],
                ]);
                $fileImage->storeAs('public/produk', $fileImage->hashName());
            }
            return redirect()->route('produsen.kelola-produk')->with('success', 'Produk berhasil ditambahkan');
        } catch (\Throwable $th) {
            Log::error('Failed to create Produk: '. $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to create Produk. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdukRequest $request, $id)
    {
        $findById = Produk::findOrFail($id);
        $validateData = $request->validated();
        try {
            $fileImage = $request->file('foto_produk');
            if ($fileImage) {
                // Store the new file and delete the old one if it exists
                $hashedFileName = $fileImage->hashName();
                $fileImage->storeAs('public/produk', $hashedFileName);

                // Delete the old file if it exists
                if ($findById->foto_produk) {
                    Storage::delete('public/produk/' . $findById->foto_produk);
                }

                $validateData['foto_produk'] = $hashedFileName;
            }

            $findById->update($validateData);

            return redirect()->route('produsen.kelola-produk')->with('success', 'Produk berhasil diupdate');
        } catch (\Throwable $th) {
            Log::error('Failed to update Produk: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to update Produk. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk, $id)
    {
        $findById = $produk->findOrFail($id);
        try {
            if ($findById->foto_produk) {
                Storage::delete('public/produk/' . $findById->foto_produk);
            }
            $findById->delete();
            return redirect()->route('produsen.kelola-produk')->with('success', 'Produk berhasil dihapus');
        } catch (\Throwable $th) {
            Log::error('Failed to delete Produk: '. $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to delete Produk. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
}
