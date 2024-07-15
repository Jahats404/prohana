<?php

namespace App\Http\Controllers\produsen\kelolaAkun;

use App\Http\Controllers\Controller;
use App\Models\Distributor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KelolaDistributorController extends Controller
{
    public function index()
    {
        $distributor = Distributor::all();
        return view('produsen.pengguna.distributor', compact('distributor'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_distributor' => 'required',
            'domisili_distributor' => 'required',
            'alamat_distributor' => 'required',
            'notelp_distributor' => 'required|number',
            'email' => 'required|email|unique:users,email',
        ];

        $messages = [
            'nama_distributor.required' => 'Nama tidak boleh kosong!',
            'domisili_distributor.required' => 'Domisili tidak boleh kosong!',
            'alamat_distributor.required' => 'Alamat tidak boleh kosong!',
            'notelp_distributor.required' => 'Nomor telepon tidak boleh kosong!',
            'notelp_distributor.number' => 'Nomor telepon tidak valid!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email sudah digunakan!'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User;
        $user->name = $request->nama_distributor;
        $user->email = $request->email;
        $user->password = Hash::make('12345678');
        $user->save();

        $distributor = new Distributor;
        $distributor->nama_distributor = $request->nama_distributor;
        $distributor->domisili_distributor = $request->domisili_distributor;
        $distributor->alamat_distributor = $request->alamat_distributor;
        $distributor->notelp_distributor = $request->notelp_distributor;
        $distributor->user_id = $user->id;
        $distributor->save();

        return redirect()->back()->with('success','Distributor berhasil ditambahkan');
    }
}