<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Regular User',
            'email' => 'user@raf.rs',
            'password' => Hash::make('user'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Editor',
            'email' => 'editor@raf.rs',
            'password' => Hash::make('editor'),
            'role' => 'editor'
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@raf.rs',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);
    }
}
