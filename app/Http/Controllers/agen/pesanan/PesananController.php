<?php

namespace App\Http\Controllers\agen\pesanan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PesananRequest;
use App\Models\Agen;
use App\Models\DetailPesanan;
use App\Models\DetailProduk;
use App\Models\Pesanan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUser = auth()->user()->id;
        $idAgen = Agen::whereUserId($idUser)->first()->id_agen;
        $pesanan = Pesanan::whereAgenId($idAgen)->get();
        $produks = Produk::all();
        return view('agen.pesanan.index', compact('pesanan', 'produks'));
    }

    public function pesanan()
    {
        $idUser = auth()->user()->id;
        $idAgen = Agen::whereUserId($idUser)->first()->id_agen;
        $pesanan = Pesanan::whereAgenId($idAgen)->get();
        $produks = Produk::all();
        return view('agen.pesanan.pesanan', compact('pesanan', 'produks'));
    }

    public function detail($id)
    {
        $produk = Produk::findOrFail($id);
        // dd($produk);
        return view('agen.produk.detail-produk',compact('produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(PesananRequest $request)
    // {
    //     $validateDate = $request->validated();
    //     try {
    //         $agenId = auth()->user()->agen->id_agen;
    //         $pesanan = Pesanan::create([
    //             'produk_id' => $validateDate['produk_id'],
    //             'agen_id' => $agenId,
    //             'tanggal_pesan' => $validateDate['tanggal_pesan'],
    //             'status_pesanan' => $validateDate['status_pesanan'],
    //             'total_harga' => $validateDate['total_harga'],
    //         ]);
    //         DetailPesanan::create([
    //             'pesanan_id' => $pesanan->id_pesanan,
    //             'produk_id' => $validateDate['produk_id'],
    //             'jumlah' => $validateDate['jumlah'],
    //         ]);
    //         return redirect()->back()->with('success', 'Pesanan berhasil ditambahkan');
    //     } catch (\Throwable $th) {
    //         Log::error('Failed to create Pesanan: ' . $th->getMessage());
    //         $status = 500; // This should be a variable, not a constant
    //         $message = 'Failed to create Pesanan. Server Error.';
    //         return response()->view('errors.index', compact('status', 'message'), $status);
    //     }
    // }

    
    public function store(Request $request)
    {
        $items = json_decode($request->input('cart'), true);

        //untuk mengambil id_agen
        $user = auth()->user();
        $agen = $user->agen;

        //untuk mengambil tanggal sekarang
        $dateNow = Carbon::now()->toDateString();

        //untuk menghitung total keseluruhan total_harga
        $totalHarga = 0;
        foreach ($items as $th) {
            $totalHarga += $th['harga'] * $th['jumlah'];
        }

        //insert data ke tabel pesanan
        $pesanan = new Pesanan();
        $pesanan->agen_id = $agen->id_agen;
        $pesanan->status_pesanan = 'pending';
        $pesanan->tanggal_pesan = $dateNow;
        $pesanan->total_harga = $totalHarga;
        $pesanan->save();

        foreach ($items as $item) {
            // Mencari detail produk yang sesuai dengan kriteria dan tersedia
            $detailProduks = DetailProduk::where('produk_id', $item['id_produk'])
                ->where('warna', $item['warna'])
                ->where('ukuran', $item['ukuran'])
                ->where('status', 'Tersedia')
                ->orderBy(DB::raw("CAST(SUBSTRING(resi, 15) AS UNSIGNED)"), 'desc')
                ->take($item['jumlah']) // Mengambil sejumlah item yang diminta
                ->get();

            // Memastikan jumlah detail produk yang ditemukan cukup
            if ($detailProduks->count() < $item['jumlah']) {
                return redirect()->back()->withErrors(['error' => 'Jumlah produk dengan kriteria tertentu tidak mencukupi.']);
            }

            foreach ($detailProduks as $detail) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id_pesanan,
                    'detail_produk_id' => $detail->resi, // Menyimpan ID detail produk yang sesuai
                    'tanggal_pesan' => $dateNow,
                    'status_pesanan' => 'pending', // Status detail pesanan
                    'harga' => $item['harga'],
                ]);

                // Update status produk setelah dipesan
                $detail->status = 'Dipesan';
                $detail->save();
            }
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan, $id)
    {
        try {
            $decyptId = Crypt::decrypt($id);
            $pesanan = Pesanan::with('produk')->findOrFail($decyptId);
            // dd($pesanan);
            $produks = Produk::all();
            return view('agen.pesanan.detail', compact('pesanan', 'produks'));
        } catch (\Throwable $th) {
            Log::error('Failed to show Pesanan: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to create Pesanan. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    public function getProductPrice($id)
    {
        $product = Produk::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json(['harga' => $product->harga]);
    }

    public function getStock($produk_id, $warna, $ukuran)
    {
        $stok = DetailProduk::where('produk_id', $produk_id)
            ->where('warna', $warna)
            ->where('ukuran', $ukuran)
            ->where('status', 'Tersedia')
            ->count();
        
        return response()->json(['stok' => $stok]);
    }
}