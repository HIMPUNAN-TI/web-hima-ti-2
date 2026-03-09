<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class KompetisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // buat beberapa contoh event bertipe "kompetisi" (sub-lomba Geteksi)
        DB::table('events')->insert([
            [
                'name' => 'Lomba Desain Poster',
                'type' => 'kompetisi',
                'parent_event_name' => 'Geteksi VOL 3',
                'price' => 0,
                'date' => '2025-10-20 00:00:00',
                'regist_start_date' => '2025-09-01 00:00:00',
                'regist_end_date' => '2025-10-15 00:00:00',
                'location' => 'Stikom Bali',
                'maps' => '',
                'description' => 'Lomba desain poster sebagai salah satu sub‑kompetisi pada Geteksi VOL 3.',
                'poster' => null,
                'certificate' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lomba Coding',
                'type' => 'kompetisi',
                'parent_event_name' => 'Geteksi VOL 3',
                'price' => 0,
                'date' => '2025-10-21 00:00:00',
                'regist_start_date' => '2025-09-01 00:00:00',
                'regist_end_date' => '2025-10-15 00:00:00',
                'location' => 'Laboratorium TI STIKOM Bali',
                'maps' => '',
                'description' => 'Lomba pemrograman untuk mahasiswa TI yang menjadi salah satu rangkaian acara Geteksi VOL 3.',
                'poster' => null,
                'certificate' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
