<?php

namespace App\Http\Controllers\produsen\kelolaAkun;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistributorRequest;
use App\Models\Distributor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class KelolaDistributorController extends Controller
{
    public function index()
    {
        $distributor = Distributor::all();
        return view('produsen.pengguna.distributor.index', compact('distributor'));
    }

    public function store(DistributorRequest $request)
    {
        // Validate the request using the DistributorRequest
        $validatedData = $request->validated();

        try {
            $user = User::create([
                'name' => $validatedData['nama_distributor'],
                'email' => $validatedData['email'],
                'password' => Hash::make('12345678'),
                'role_id' => 2, // Adjust this to match the role ID of a distributor
                'remember_token' => Str::random(10),
            ]);

            // Create a new distributor linked to the user
            Distributor::create([
                'nama_distributor' => $validatedData['nama_distributor'],
                'domisili_distributor' => $validatedData['domisili_distributor'],
                'alamat_distributor' => $validatedData['alamat_distributor'],
                'notelp_distributor' => $validatedData['notelp_distributor'],
                'user_id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Distributor berhasil ditambahkan');
        } catch (\Throwable $th) {
            Log::error('Failed to create Distributor: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to create Distributor. Server Error.';
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    public function update(DistributorRequest $request, $id){

        $validatedData = $request->validated();
        try {
            $distributor = Distributor::find($id);

            $distributor->update([
                'nama_distributor' => $validatedData['nama_distributor'],
                'domisili_distributor' => $validatedData['domisili_distributor'],
                'alamat_distributor' => $validatedData['alamat_distributor'],
                'notelp_distributor' => $validatedData['notelp_distributor'],
                'user_id' => $distributor->user_id, // Keep the same user_id
            ]);
            return redirect()->route('produsen.kelola-distributor')->with('success', 'Distributor berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Failed to update Distributor: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to update Distributor : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
    public function destroy($id){
        try {
            $distributor = Distributor::find($id);
            $distributor->user->delete();
            return redirect()->route('produsen.kelola-distributor')->with('success', 'Distributor berhasil dihapus');
        } catch (\Throwable $th) {
            Log::error('Failed to create Distributor: ' . $th->getMessage());
            $status = 500; // This should be a variable, not a constant
            $message = 'Failed to delete Distributor : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
}