<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $adminEmail = 'adminhima@gmail.com';
        $user = DB::table('users')->where('email', $adminEmail)->first();

        if ($user) {
            DB::table('users')->where('id', $user->id)->update([
                'role' => 'admin',
                'password' => Hash::make('@hima1234'),
                'email_verified_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            DB::table('users')->insert([
                'name' => 'Admin Hima',
                'email' => $adminEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('@hima1234'),
                'remember_token' => '',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
