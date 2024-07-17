<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Agen;
use App\Models\Distributor;
use App\Models\Produsen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $profile = $user->findOrFail(auth()->user()->id);
        return view('profile.edit', compact('profile'));
    }

    public function editPass(){
        return view('profile.security');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileRequest $request, User $user)
    {
        $idUser = auth()->user()->id;
        $roleIdByUser = auth()->user()->role_id;
        $profile = $user->findOrFail($idUser);
        try {
            $profile->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            if($roleIdByUser == 1){
                Produsen::whereUserId($idUser)->update([
                    'nama_produsen' => $request->name,
                    'alamat_produsen' => $request->alamat,
                    'notelp_produsen' => $request->no_telp,
                    'domisili_produsen' => $request->domisili,
                    'updated_at' => now()
                ]);
            }else if($roleIdByUser == 2){
                Agen::whereUserId($idUser)->update([
                    'nama_agen' => $request->name,
                    'alamat_agen' => $request->alamat,
                    'notelp_agen' => $request->no_telp,
                    'domisili_agen' => $request->domisili,
                    'updated_at' => now()
                ]);
            }else if($roleIdByUser == 3){
                Distributor::whereUserId($idUser)->update([
                    'nama_distributor' => $request->name,
                    'alamat_distributor' => $request->alamat,
                    'notelp_distributor' => $request->no_telp,
                    'domisili_distributor' => $request->domisili,
                    'updated_at' => now()
                ]);
            }
            return redirect('/profile')->with('success', 'Profile updated successfully!');
        } catch (\Throwable $th) {
            Log::error('Failed to update profile: ' . $th->getMessage());
            $status = 500;
            $message = 'Failed to update profile : '. $th->getMessage();
            return response()->view('errors.index', compact('status', 'message'), $status);
        }
    }

    public function updatePassword(Request $request){
        $authUser = auth()->user()->id;

        $user = User::findOrFail($authUser);
        // Check the current password first
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        // Validate the new password fields
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your password has been updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
