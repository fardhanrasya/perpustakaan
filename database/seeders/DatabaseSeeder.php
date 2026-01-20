<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder Admin
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'), // atau bcrypt('admin123')
            'nama_admin' => 'Admin',
        ]);
        
        // Bisa tambahkan data dummy lain jika perlu
    }
}
