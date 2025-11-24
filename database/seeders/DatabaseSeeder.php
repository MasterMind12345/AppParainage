<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Salle;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'admin-clubgi',
            'email' => 'admin123@gmail.com',
            'password' => Hash::make('passadmin123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'admin2-clubgi',
            'email' => 'iutclubgi@gmail.com',
            'password' => Hash::make('club-GI#2025'),
            'role' => 'admin'
        ]);

        $salles = ['E301', 'E302', 'E202', 'A31', 'A12'];

        foreach ($salles as $salle) {
            Salle::create(['nom' => $salle]);
        }
    }
}
