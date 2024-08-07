<?php

namespace App\Http\Controllers\produsen\produk;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdukRequest;
use App\Models\DetailProduk;
use App\Models\Produk;
use App\Models\Produsen;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::all();
        $produsen = Produsen::all();
        // dd('asd');
        return view('produsen.asset.produk.index', compact('produk', 'produsen'));
    }

    public function show($id)
    {
        $decryptId = Crypt::decrypt($id);
        $produk = Produk::find($decryptId);
        // Mengelompokkan berdasarkan warna dan ukuran, serta menghitung jumlah untuk setiap kombinasi
        $detailProdukGrouped = DetailProduk::select('produk_id', 'warna', 'ukuran', DB::raw('COUNT(*) as count'))
                                ->where('produk_id', $decryptId)
                                ->groupBy('produk_id', 'warna', 'ukuran')
                                ->get();
        // dd($detailProdukGrouped);
        
        return view('produsen.asset.produk.detail', compact('detailProdukGrouped', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdukRequest $request)
    {
        $validateData = $request->validated();
        
    
        // try {
            $fileImage = $request->file('foto_produk');
            $produsenId = Auth::user()->produsen->id_produsen;
            $produkData = [
                'nama_produk' => $validateData['nama_produk'],
                'kategori_produk' => $validateData['kategori_produk'],
                'jenis_produk' => $validateData['jenis_produk'],
                'harga' => $validateData['harga'],
                'stok' => $validateData['stok'],
                'produsen_id' => $produsenId,
            ];
    
            if ($fileImage) {
                $produkData['foto_produk'] = $fileImage->hashName();
                $fileImage->storeAs('public/produk', $fileImage->hashName());
            }
    
            $produk = Produk::create($produkData);

            $date = Carbon::now()->toDateString();
            $tanggal = str_replace('-', '', $date);
            
            $firstKarakterJenis = substr($request->jenis_produk, 0, 1);
            $firstKarakterWarna = substr($request->warna, 0, 1);
            $firstKarakterKategori = substr($request->kategori_produk, 0, 1);
            $firstKarakterNama = substr($request->nama_produk, 0, 1);

            $latestProduk = DetailProduk::select('*')
                            ->where('produk_id', $produk->id_produk)
                            ->where('warna', $request->warna)
                            ->where('ukuran', $request->ukuran)
                            ->orderBy(DB::raw("CAST(SUBSTRING(resi, 15) AS UNSIGNED)"), 'desc')
                            ->first();
            $latestidProduk = $latestProduk ? intval(substr($latestProduk->resi, 14)) + 1 : 0;
    
            // Insert data into detail_produk table
            $stok = $validateData['stok'];
            for ($i = 0; $i < $stok; $i++) {
                $latestidProduk++;
                DetailProduk::create([
                    'resi' => $firstKarakterJenis . $firstKarakterKategori . $tanggal . $firstKarakterNama . $validateData['ukuran'] . $firstKarakterWarna . $latestidProduk,
                    'produk_id' => $produk->id_produk,
                    'ukuran' => $validateData['ukuran'],
                    'status' => 'Tersedia',
                    'warna' => $validateData['warna'],
                ]);
            }
    
            return redirect()->route('produsen.kelola-produk')->with('success', 'Produk berhasil ditambahkan');
        // } catch (\Throwable $th) {
        //     Log::error('Failed to create Produk: ' . $th->getMessage());
        //     $status = 500; 
        //     $message = 'Failed to create Produk. Server Error.';
        //     return response()->view('errors.index', compact('status', 'message'), $status);
        // }
    }

    public function tambah_stok(Request $request, $id)
    {
        $rules = [
            'stok' => 'required|min:0',
            'ukuran' => 'required|min:0',
            'warna' => 'required|string|max:255',
        ];
        $messages = [
            'stok.required' => 'Stok produk tidak boleh kosong!',
            'stok.min' => 'Stok produk tidak boleh negatif!',
            'ukuran.required' => 'Ukuran produk tidak boleh kosong!',
            'ukuran.min' => 'Ukuran produk tidak boleh negatif!',
            'warna.required' => 'Warna produk tidak boleh kosong!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
        }

        $date = Carbon::now()->toDateString();
        $tanggal = str_replace('-', '', $date);
        
        $produk = Produk::findOrFail( $id );
        $firstKarakterJenis = substr($produk->jenis_produk, 0, 1);
        $firstKarakterWarna = substr($request->warna, 0, 1);
        $firstKarakterKategori = substr($produk->kategori_produk, 0, 1);
        $firstKarakterNama = substr($produk->nama_produk, 0, 1);
        
        // mencari digit ke 14 kebelakang pada resi sesuai jenis 
        $latestProduk = DetailProduk::select('*')
                        ->where('produk_id', $id)
                        ->where('warna', $request->warna)
                        ->where('ukuran', $request->ukuran)
                        ->orderBy(DB::raw("CAST(SUBSTRING(resi, 15) AS UNSIGNED)"), 'desc')
                        ->first();
        $latestidProduk = $latestProduk ? intval(substr($latestProduk->resi, 14)) : 0;
        
        // menambah stok pada table produk
        $totalStok = $produk->stok + $request->stok;
        $produk->stok = $totalStok;
        $produk->save();
        
        // Insert data into detail_produk table
        $stok = $request->stok;
        for ($i = 0; $i < $stok; $i++) {
            $latestidProduk++;
            DetailProduk::create([
                'resi' => $firstKarakterJenis . $firstKarakterKategori . $tanggal . $firstKarakterNama . $request->ukuran . $firstKarakterWarna . $latestidProduk,
                'produk_id' => $id,
                'ukuran' => $request->ukuran,
                'status' => 'Tersedia',
                'warna' => $request->warna,
            ]);
        }
        
        return redirect()->back()->with('success', 'Stok berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'foto_produk' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama_produk' => 'required|string|max:255',
            'kategori_produk' => 'required|string|max:255',
            'jenis_produk' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            // 'stok' => 'required|min:0',
            // 'ukuran' => 'required|min:0',
            // 'warna' => 'required|string|max:255',
        ];
        $messages = [
            'foto_produk.image' => 'Foto produk harus berupa gambar!',
            'foto_produk.mimes' => 'Foto produk harus berformat jpeg, png, jpg, gif, atau svg!',
            'foto_produk.max' => 'Foto produk tidak boleh lebih dari 2MB!',
            'nama_produk.required' => 'Nama produk tidak boleh kosong!',
            'kategori_produk.required' => 'Kategori produk tidak boleh kosong!',
            'jenis_produk.required' => 'Jenis produk tidak boleh kosong!',
            'harga.required' => 'Harga produk tidak boleh kosong!',
            'harga.integer' => 'Harga produk harus berupa angka!',
            'harga.min' => 'Harga produk tidak boleh negatif!',
            // 'stok.required' => 'Stok produk tidak boleh kosong!',
            // 'stok.min' => 'Stok produk tidak boleh negatif!',
            // 'ukuran.required' => 'Ukuran produk tidak boleh kosong!',
            // 'ukuran.min' => 'Ukuran produk tidak boleh negatif!',
            // 'warna.required' => 'Warna produk tidak boleh kosong!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $findById = Produk::findOrFail($id);
        $validateData = $request->all();
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
            
            // $produk = Produk::findOrFail( $id );
            
            // // kode dibawah untuk mengambil resi lama
            // $firstKarakterJenis = substr($produk->jenis_produk, 0, 1);
            // $firstKarakterKategori = substr($produk->kategori_produk, 0, 1);
            // $firstKarakterNama = substr($produk->nama_produk, 0, 1);
            // $tanggal = str_replace('-', '', $produk->created_at->toDateString());
            // $resiLama = $firstKarakterJenis . $firstKarakterKategori . $tanggal . $firstKarakterNama;

            // // kode dibawah untuk mengambil resi baru
            // $firstKarakterNamaBaru = substr($request->nama_produk, 0, 1);
            // $firstKarakterKategoriBaru = substr($request->kategori_produk, 0, 1);
            // $firstKarakterJenisBaru = substr($request->jenis_produk, 0, 1);
            
            // $detail = DetailProduk::where('produk_id', $id)->where('resi', 'LIKE', '%' . $resiLama . '%')->where('status', 'Tersedia')->get();
            // dd($resiLama);
            // foreach ($detail as $dt) {
            //     $firstKarakterWarna = substr($dt->warna, 0, 1);
            //     $resiBaru = $firstKarakterJenisBaru . $firstKarakterKategoriBaru . $tanggal . $firstKarakterNamaBaru . $dt->ukuran . substr($dt->warna, 0, 1);
            //     // dd($resiBaru);
                
            //     $latestProduk = DetailProduk::select('*')
            //                     ->where('resi', 'LIKE', '%' . $resiBaru . '%')
            //                     ->where('produk_id', $id)
            //                     ->where('warna', $dt->warna)
            //                     ->where('ukuran', $dt->ukuran)
            //                     ->orderBy(DB::raw("CAST(SUBSTRING(resi, 15) AS UNSIGNED)"), 'desc')
            //                     ->first();
            //     $latestidProduk = $latestProduk ? intval(substr($latestProduk->resi, 14)) : 0;
            //     dd($latestidProduk);
                
            //     $dt->resi =  $resiBaru;
            //     $dt->save();
            //     dd($produk);
            // }

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