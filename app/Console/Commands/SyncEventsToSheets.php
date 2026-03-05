<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Services\GoogleSheetsService;
use Illuminate\Console\Command;

class SyncEventsToSheets extends Command
{
    protected $signature = 'sheets:sync-events {--init : Tambahkan header di baris pertama}';
    protected $description = 'Sync semua data event ke Google Sheets';

    public function __construct(protected GoogleSheetsService $sheets)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $spreadsheetId = config('services.google.spreadsheet_id');
        $sheetName     = 'Events';

        // Inisialisasi header jika pakai flag --init
        if ($this->option('init')) {
            $this->sheets->updateValues($spreadsheetId, $sheetName . '!A1:J1', [[
                'ID',
                'Nama Event',
                'Harga',
                'Tanggal Event',
                'Buka Registrasi',
                'Tutup Registrasi',
                'Lokasi',
                'Deskripsi',
                'Link Maps',
                'Dibuat Pada',
            ]]);
            $this->info('✅ Header berhasil ditambahkan di baris 1.');
        }

        $events = Event::all();

        if ($events->isEmpty()) {
            $this->warn('Tidak ada data event di database.');
            return;
        }

        $rows = $events->map(fn(Event $e) => [
            $e->id,
            $e->name,
            (float) $e->price,
            $e->date?->format('Y-m-d'),
            $e->regist_start_date?->format('Y-m-d'),
            $e->regist_end_date?->format('Y-m-d'),
            $e->location,
            $e->description,
            $e->maps,
            $e->created_at?->format('Y-m-d H:i:s'),
        ])->values()->toArray();

        // Tulis mulai dari A2 (setelah header)
        $endCol   = 'J';
        $endRow   = count($rows) + 1;
        $range    = $sheetName . '!A2:' . $endCol . $endRow;

        $this->sheets->updateValues($spreadsheetId, $range, $rows);

        $this->info("✅ Berhasil sync {$events->count()} event ke Google Sheets.");
    }
}
