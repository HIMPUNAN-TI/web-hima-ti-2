<?php

namespace App\Console\Commands;

use App\Services\GoogleSheetsService;
use Illuminate\Console\Command;

class ClearGoogleSheets extends Command
{
    protected $signature = 'sheets:clear-all';
    protected $description = 'Menghapus semua tab di Google Sheets kecuali tab utama (Events) untuk membersihkan data lama.';

    public function __construct(protected GoogleSheetsService $sheets)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $spreadsheetId = config('services.google.spreadsheet_id');

        $this->info("Mengambil daftar sheet dari Google Sheets...");
        $sheetsList = $this->sheets->getSheetsList($spreadsheetId);

        // Google Sheets setidaknya butuh 1 tab yang tersisa, jadi kita akan buat tab sementara
        // atau kita keep tab 'Events'
        
        $hasEventsSheet = false;
        $eventsSheetId = null;

        foreach ($sheetsList as $sheet) {
            $title = $sheet->getProperties()->getTitle();
            $id = $sheet->getProperties()->getSheetId();
            
            if ($title === 'Events') {
                $hasEventsSheet = true;
                $eventsSheetId = $id;
            }
        }

        // Kalau tidak ada tab Events, buat tab Events agar bisa menghapus sisanya
        if (!$hasEventsSheet) {
            $this->sheets->addSheet($spreadsheetId, 'Events');
            $this->info("Tab 'Events' baru telah dibuat.");
            
            // Re-fetch untuk dapet ID yang baru
            $sheetsList = $this->sheets->getSheetsList($spreadsheetId);
            foreach ($sheetsList as $sheet) {
                if ($sheet->getProperties()->getTitle() === 'Events') {
                    $eventsSheetId = $sheet->getProperties()->getSheetId();
                }
            }
        }

        foreach ($sheetsList as $sheet) {
            $title = $sheet->getProperties()->getTitle();
            $id = $sheet->getProperties()->getSheetId();
            
            if ($id !== $eventsSheetId) {
                try {
                    $this->sheets->deleteSheet($spreadsheetId, $id);
                    $this->info("🗑️ Tab '$title' telah dihapus.");
                } catch (\Exception $e) {
                    $this->error("Gagal menghapus tab '$title': " . $e->getMessage());
                }
            }
        }

        // Terakhir, clear data yang ada di tab Events peninggalan lama
        $this->sheets->clearValues($spreadsheetId, 'Events!A1:Z9999');
        $this->info("🗑️ Data di tab 'Events' telah dikosongkan.");

        $this->info("✅ Semua tab lama telah dihapus dan disetel ulang!");
        $this->info("Selanjutnya Anda bisa menjalankan:");
        $this->info("1. php artisan sheets:sync-events --init (untuk mensinkronisasi event)");
        $this->info("2. php artisan sheets:sync-registrations (untuk meregenerate tab per event)");
    }
}
