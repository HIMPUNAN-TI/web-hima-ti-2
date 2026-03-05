<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin Hima',
            'email' => 'adminhima@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('@hima1234'),
            'remember_token' => '',
            'role' => 'admin',
            'telephone_number' => '081123123123',
            'is_stikom' => true,
            'nim' => '123456789',
            'generation' => '2022',
            'prodi' => 'Teknik Informatika',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
