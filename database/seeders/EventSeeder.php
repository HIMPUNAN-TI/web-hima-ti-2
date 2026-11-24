<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'name' => 'Workshop Fullstack Web Development Modern 2026',
                'price' => 50000,
                'quota' => 50,
                'date' => '2026-12-15 09:00:00',
                'regist_start_date' => '2026-11-01 00:00:00',
                'regist_end_date' => '2026-12-10 23:59:59',
                'location' => 'Lab Komputer ITB STIKOM Bali',
                'maps' => 'https://maps.app.goo.gl/94ooc7S9pNLyLQoz9',
                'description' => '<p>Pelajari teknologi terkini pembuatan website modern fullstack dengan Laravel dan TailwindCSS. Dapatkan e-sertifikat resmi, modul praktikum, konsumsi, dan perluas relasi bersama komunitas TI.</p>',
                'poster' => '1760668173_poster_event-1.jpg',
                'certificate' => '1760668173_certificate_hima.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seminar Nasional AI & Cloud Computing 2026',
                'price' => 0,
                'quota' => 100,
                'date' => '2026-12-20 09:00:00',
                'regist_start_date' => '2026-11-01 00:00:00',
                'regist_end_date' => '2026-12-18 23:59:59',
                'location' => 'Auditorium Widya Sabha ITB STIKOM Bali',
                'maps' => 'https://maps.app.goo.gl/94ooc7S9pNLyLQoz9',
                'description' => '<p>Seminar nasional perkembangan kecerdasan buatan (AI) dan arsitektur cloud computing terkini. Kegiatan ini 100% GRATIS dan terbuka untuk seluruh mahasiswa serta umum. Dapatkan e-sertifikat gratis!</p>',
                'poster' => '1772460678_poster_399190_21-3-2023_14-22-21.webp',
                'certificate' => '1760668173_certificate_hima.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tech Talk: Cyber Security & Ethical Hacking',
                'price' => 25000,
                'quota' => 60,
                'date' => '2026-12-28 13:00:00',
                'regist_start_date' => '2026-11-10 00:00:00',
                'regist_end_date' => '2026-12-25 23:59:59',
                'location' => 'Online via Zoom Meeting',
                'maps' => 'https://maps.app.goo.gl/94ooc7S9pNLyLQoz9',
                'description' => '<p>Eksplorasi mendalam tentang dasar-dasar ethical hacking, pengamanan celah sistem web, serta mitigasi insiden cyber security bersama praktisi industri berpengalaman.</p>',
                'poster' => '1760668173_poster_event-1.jpg',
                'certificate' => '1760668173_certificate_hima.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($events as $event) {
            DB::table('events')->updateOrInsert(
                ['name' => $event['name']],
                $event
            );
        }
    }
}
