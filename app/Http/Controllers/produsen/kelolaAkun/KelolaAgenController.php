<?php

namespace App\Http\Controllers\Produsen\KelolaAkun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agen; // Assuming you have an Agen model
use Illuminate\Support\Facades\Log;

class KelolaAgenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agen = Agen::all();
        return view('produsen.pengguna.agen', compact('agen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $createAgen = $request->validate([
            'nama_agen' => 'required|string|max:255',
            'domisili_agen' => 'required|string|max:255',
            'alamat_agen' => 'required|string|max:255',
            'notelp_agen' => 'required|numeric',
        ]);

        try {
            Agen::create($createAgen);
            return redirect()->route('agen.index')
                ->with('success', 'Agen created successfully.');
        } catch (\Throwable $th) {
            Log::error('Failed to create Agen: ' . $th->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $agen = Agen::findOrFail($id);
        return view('agen.show', compact('agen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $agen = Agen::findOrFail($id);
        return view('agen.edit', compact('agen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:agen,email,'.$id,
            // Add other validation rules as needed
        ]);

        $agen = Agen::findOrFail($id);
        $agen->update($request->all());

        return redirect()->route('agen.index')
            ->with('success', 'Agen updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $agen = Agen::findOrFail($id);
        $agen->delete();

        return redirect()->route('agen.index')
            ->with('success', 'Agen deleted successfully.');
    }
}
