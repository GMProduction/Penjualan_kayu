<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'admin',
            'alamat' => 'solo',
            'username' => 'admin',
            'no_hp' => '0000',
            'password' => Hash::make('admin'),
            'roles' => 'admin',
        ]);
    }
}
