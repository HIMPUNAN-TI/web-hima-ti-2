<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $events = [
            [
                'name' => 'Workshop Fullstack Web Development Modern 2026',
                'price' => 50000,
                'quota' => 50,
                'date' => '2026-12-15',
                'regist_start_date' => '2026-11-01',
                'regist_end_date' => '2026-12-10',
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
                'date' => '2026-12-20',
                'regist_start_date' => '2026-11-01',
                'regist_end_date' => '2026-12-18',
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
                'date' => '2026-12-28',
                'regist_start_date' => '2026-11-10',
                'regist_end_date' => '2026-12-25',
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
            $exists = DB::table('events')->where('name', $event['name'])->exists();
            if (!$exists) {
                DB::table('events')->insert($event);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('events')->whereIn('name', [
            'Workshop Fullstack Web Development Modern 2026',
            'Seminar Nasional AI & Cloud Computing 2026',
            'Tech Talk: Cyber Security & Ethical Hacking',
        ])->delete();
    }
};
