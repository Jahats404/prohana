<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => '1',
            'level' => 'Produsen',
        ]);

        Role::create([
                    'id' => '2',
                    'level' => 'Distributor',
                ]);


        Role::create([
                    'id' => '3',
                    'level' => 'Agen',
                ]);
    }
}