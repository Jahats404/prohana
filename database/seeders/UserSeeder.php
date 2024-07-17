<?php

namespace Database\Seeders;

use App\Models\Agen;
use App\Models\Produsen;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Produsen User
        $produsenUser = $this->createUser([
            'name' => 'Produsen',
            'email' => 'produsen@gmail.com',
            'password' => 'password', // Ganti 'password' dengan password yang aman
            'role_id' => 1, // Sesuaikan dengan id peran produsen yang telah Anda seed
        ]);

        // Create Produsen
        Produsen::create([
            'id_produsen' => $this->generateUniqueId([$produsenUser->id]),
            'nama_produsen' => 'Toko Prohana',
            'domisili_produsen' => 'Jakarta',
            'alamat_produsen' => 'Jl. Kebon Jeruk No. 10',
            'notelp_produsen' => '081234567890',
            'user_id' => $produsenUser->id,
        ]);

        // Create Distributor User
        $this->createUser([
            'name' => 'Budi Santoso',
            'email' => 'budisantoso@gmail.com',
            'password' => 'password', // Ganti 'password' dengan password yang aman
            'role_id' => 2, // Sesuaikan dengan id peran distributor yang telah Anda seed
        ]);

        // Create Agen User
        $agenUser = $this->createUser([
            'name' => 'Rina Hartati',
            'email' => 'rinahartati@gmail.com',
            'password' => 'password', // Ganti 'password' dengan password yang aman
            'role_id' => 3, // Sesuaikan dengan id peran agen yang telah Anda seed
        ]);

        Agen::create([
            'id_agen' => $this->generateUniqueId([$agenUser->id]),
            'nama_agen' => 'Agen 1',
            'domisili_agen' => 'Jakarta',
            'alamat_agen' => 'Jl. Kebon Jeruk No. 10',
            'user_id' => $agenUser->id,
            'notelp_agen' => '081234567890',
        ]);
    }

    /**
     * Create a new user.
     */
    private function createUser(array $data)
    {
        return User::create([
            'id' => $this->generateUniqueId(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'],
            'remember_token' => Str::random(10),
        ]);
    }

    /**
     * Generate a unique ID.
     */
    private function generateUniqueId(array $excludeIds = [])
    {
        do {
            $id = random_int(10000000, 99999999);
        } while (in_array($id, $excludeIds));

        return $id;
    }
}
