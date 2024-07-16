<?php

namespace App\Http\Controllers\Produsen\KelolaAkun;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgenRequest;
use App\Models\Agen; // Assuming you have an Agen model
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KelolaAgenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agen = Agen::all();
        return view('produsen.pengguna.agen.index', compact('agen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AgenRequest $request)
    {
        $validatedData = $request->validated();
        try {
            $user = User::create([
                'name' => $validatedData['nama_agen'],
                'email' => $validatedData['email'],
                'password' => Hash::make('12345678'),
                'role_id' => 2, // Adjust this to match the role ID of a agen
                'remember_token' => Str::random(10),
            ]);

            // Create a new agen linked to the user
            Agen::create([
                'nama_agen' => $validatedData['nama_agen'],
                'domisili_agen' => $validatedData['domisili_agen'],
                'alamat_agen' => $validatedData['alamat_agen'],
                'notelp_agen' => $validatedData['notelp_agen'],
                'user_id' => $user->id,
            ]);

            return redirect()->route('produsen.kelola-agen')
                ->with('success', 'Agen created successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to create Agen: ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to create Agen : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgenRequest $request, $id)
    {
        $updateAgen = $request->validated();

        try {
            $agen = Agen::findOrFail($id);
            $agen->update($updateAgen);
    
            return redirect()->route('produsen.kelola-agen')
                ->with('success', 'Agen updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to update Agen: ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to update Agen : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $agen = Agen::findOrFail($id);
            $agen->delete();
    
            return redirect()->route('produsen.kelola-agen')
                ->with('success', 'Agen deleted successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to delete Agen: ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to delete Agen : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }
}