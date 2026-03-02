<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

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
            'password' => '@hima1234',
            'remember_token' => '',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
