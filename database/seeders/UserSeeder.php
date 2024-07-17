<?php

namespace Database\Seeders;

use App\Models\Produsen;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $userId = random_int(10000000, 99999999);

        // Ensure the Produsen ID is different from the User ID
        do {
            $produsenId = random_int(10000000, 99999999);
        } while ($produsenId === $userId);

        $produsen = User::create([
            'id' => $userId,
            'name' => 'Produsen',
            'email' => 'produsen@gmail.com',
            'password' => Hash::make('password'), // Ganti 'password' dengan password yang aman
            'role_id' => 1, // Sesuaikan dengan id peran produsen yang telah Anda seed
            'remember_token' => Str::random(10),
        ]);
        Produsen::create([
            'id_produsen' => $produsenId,
            'nama_produsen' => 'Toko Prohana',
            'domisili_produsen' => 'Jakarta',
            'alamat_produsen' => 'Jl. Kebon Jeruk No. 10',
            'notelp_produsen' => '081234567890',
            'user_id' => $produsen->id,
        ]);

        // Contoh pengguna dengan peran distributor
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budisantoso@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 2, // Sesuaikan dengan id peran distributor yang telah Anda seed
            'remember_token' => str::random(10),
        ]);


        // Contoh pengguna dengan peran agen
        User::create([
            'name' => 'Rina Hartati',
            'email' => 'rinahartati@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 3, // Sesuaikan dengan id peran agen yang telah Anda seed
            'remember_token' => Str::random(10),
        ]);

        Produsen::create([
            'id_produsen' => $produsenId,
            'nama_produsen' => 'Toko Prohana',
            'domisili_produsen' => 'Jakarta',
            'alamat_produsen' => 'Jl. Kebon Jeruk No. 10',
            'notelp_produsen' => '081234567890',
            'user_id' => $produsen->id,
        ]);
    }
}