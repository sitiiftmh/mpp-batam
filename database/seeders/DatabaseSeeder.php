<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        User::create([
            'nama'       => 'Sipa Admin',
            'email'      => 'Admin@gmail.com',
            'role'       => 'admin',
            'password'   => Hash::make('12345678'),
            'instansi'   => 'admin',
            'is_input'   => false,
        ]);
             
        User::create([
            'nama'       => 'ana',
            'email'      => 'ana@gmail.com',
            'role'       => 'petugas',
            'password'   => Hash::make('12345678'),
            'instansi'   => 'dpmptsp',
            'is_input'   => false,
        ]);
             
        User::create([
            'nama'       => 'zaa',
            'email'      => 'zaa@gmail.com',
            'role'       => 'petugas',
            'password'   => Hash::make('12345678'),
            'instansi'   => 'Bpbatam',
            'is_input'   => false,
        ]);
    }
}
