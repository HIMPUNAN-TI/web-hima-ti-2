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

        $payments = \App\Models\Payment::with(['event', 'member'])->orderBy('id')->get();

        if ($payments->isEmpty()) {
            $this->warn('Tidak ada pendaftaran event di database.');
            return;
        }

        $paymentsByEvent = $payments->groupBy('event_id');
        $totalSynced = 0;

        foreach ($paymentsByEvent as $eventId => $eventPayments) {
            $event = $eventPayments->first()->event;
            $eventNameParam = $event ? $event->name : 'Unknown';
            $sheetTitle = $eventNameParam . ' Pendaftaran';

            // Pastikan tab event ada, menggunakan method addSheet
            try {
                $this->sheets->addSheet($spreadsheetId, $sheetTitle);
                $this->info("✅ Tab '$sheetTitle' dipastikan tersedia.");
            } catch (\Exception $e) {
                // Diabaikan jika error (misal sheet udah ada tp check gagal, atau auth error yg ditangkap di bawah)
                $this->error("Gagal inisialisasi tab '$sheetTitle': " . $e->getMessage());
            }

            // 1. Clear semua data (baris 2 ke bawah) di tab event tersebut
            $this->sheets->clearValues($spreadsheetId, $sheetTitle . '!A2:J9999');
            $this->info("🗑️ Data lama di sheet '$sheetTitle' telah dihapus.");

            // 2. Build rows:
            // Sesuai dengan header dari `addSheet` (10 kolom):
            // A: ID, B: Event ID, C: Nama Event, D: Nama Peserta, E: Email, F: NIM
            // G: No. Telepon, H: Status, I: Bukti Bayar, J: Didaftarkan Pada
            $rows = $eventPayments->map(fn($p) => [
                $p->id,
                $p->event_id,
                $p->event?->name ?? '-',
                $p->name,
                $p->email,
                $p->nim,
                $p->telephone_number,
                $p->status,
                $p->proof_of_payment ? asset('image/proof_of_payments/' . $p->proof_of_payment) : '-',
                $p->created_at?->format('Y-m-d H:i:s'),
            ])->values()->toArray();

            // 3. Tulis ulang semua data ke tab tersebut
            $endRow = count($rows) + 1;
            $range  = $sheetTitle . '!A2:J' . $endRow;
            $this->sheets->updateValues($spreadsheetId, $range, $rows);

            $syncedCount = count($rows);
            $totalSynced += $syncedCount;
            $this->info("✅ Berhasil sync {$syncedCount} pendaftaran ke '$sheetTitle'.");
        }

        $this->info("🚀 Total pendaftaran ter-sync: {$totalSynced} dari " . $paymentsByEvent->count() . " event(s).");
    }
}
