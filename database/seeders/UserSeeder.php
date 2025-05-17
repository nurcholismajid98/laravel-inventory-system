<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'nurcholis11',
            'email' => 'cholis@example.com',
            'password' => bcrypt('password123'),
            'role' => 'Admin GA',  // atau 'Admin GA' sesuai role yang diinginkan
        ]);
    }
}
