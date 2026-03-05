<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GoogleSheetsService;

class SyncRegistrationsToSheets extends Command
{
    protected $signature = 'sheets:sync-registrations {--init : Initialize header in row 1}';
    protected $description = 'Sync all event registrations (payments) to Google Sheets';

    protected GoogleSheetsService $sheets;

    public function __construct(GoogleSheetsService $sheets)
    {
        parent::__construct();
        $this->sheets = $sheets;
    }

    public function handle(): void
    {
        $spreadsheetId = config('services.google.spreadsheet_id');
        $sheetName     = 'Pendaftaran';

        if ($this->option('init')) {
            $this->sheets->updateValues($spreadsheetId, $sheetName . '!A1:I1', [[
                'Event ID', 'Nama Event', 'Nama Peserta', 'Email', 'NIM',
                'No. Telepon', 'Bukti Pembayaran', 'Status', 'Tanggal Daftar',
            ]]);
            $this->info('✅ Header berhasil ditambahkan di baris 1.');
        }

        $payments = \App\Models\Payment::with(['event', 'member'])->orderBy('id')->get();

        if ($payments->isEmpty()) {
            $this->warn('Tidak ada pendaftaran event di database.');
            return;
        }

        // 1. Clear semua data (baris 2 ke bawah)
        $this->sheets->clearValues($spreadsheetId, $sheetName . '!A2:I9999');
        $this->info('🗑️ Data lama di sheet Pendaftaran telah dihapus.');

        // 2. Build rows sesuai dengan kolom di gambar:
        // A: Event ID, B: Nama Event, C: Nama Peserta, D: Email, E: NIM
        // F: No. Telepon, G: Bukti Pembayaran, H: Status, I: Tanggal Daftar
        $rows = $payments->map(fn($p) => [
            $p->event_id,
            $p->event?->name ?? '-',
            $p->name,
            $p->email,
            $p->nim,
            $p->telephone_number,
            $p->proof_of_payment ? asset('image/proof_of_payments/' . $p->proof_of_payment) : '-',
            $p->status,
            $p->created_at?->format('Y-m-d H:i:s'),
        ])->values()->toArray();

        // 3. Tulis ulang semua data
        $endRow = count($rows) + 1;
        $range  = $sheetName . '!A2:I' . $endRow;
        $this->sheets->updateValues($spreadsheetId, $range, $rows);

        $this->info("✅ Berhasil sync {$payments->count()} pendaftaran ke Google Sheets.");
    }
}
