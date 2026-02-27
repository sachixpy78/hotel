<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'email' => 'super@backend.com',
            'username' => 'super_admin',
            'password' => Hash::make('admin123'),
            'level' => 'super_admin',
            'status' => 'on'
        ]);

        Admin::create([
            'email' => 'kasir@backend.com',
            'username' => 'kasir',
            'password' => Hash::make('kasir123'),
            'level' => 'kasir',
            'status' => 'on'
        ]);
    }
}
