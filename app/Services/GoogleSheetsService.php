<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class GoogleSheetsService
{
    protected Client $client;
    protected Sheets $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setApplicationName('HIMA TI App');
        $this->client->setScopes([Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('app/credential.json'));
        $this->client->setAccessType('offline');

        $this->service = new Sheets($this->client);
    }

    /**
     * Baca data dari Google Sheet
     *
     * @param string $spreadsheetId  ID spreadsheet (dari URL Google Sheet)
     * @param string $range          Range sel, contoh: 'Sheet1!A1:E10'
     * @return array
     */
    public function getValues(string $spreadsheetId, string $range): array
    {
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues() ?? [];
    }

    /**
     * Tulis data ke Google Sheet (append / tambah baris baru)
     *
     * @param string $spreadsheetId
     * @param string $range
     * @param array  $values         Array 2D, contoh: [['Nama', 'NIM', 'Email']]
     * @return void
     */
    public function appendValues(string $spreadsheetId, string $range, array $values): void
    {
        $body = new ValueRange(['values' => $values]);

        $params = ['valueInputOption' => 'RAW'];

        $this->service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            $params
        );
    }

    /**
     * Update data di Google Sheet (timpa range tertentu)
     *
     * @param string $spreadsheetId
     * @param string $range
     * @param array  $values
     * @return void
     */
    public function updateValues(string $spreadsheetId, string $range, array $values): void
    {
        $body = new ValueRange(['values' => $values]);

        $params = ['valueInputOption' => 'RAW'];

        $this->service->spreadsheets_values->update(
            $spreadsheetId,
            $range,
            $body,
            $params
        );
    }

    /**
     * Hapus / kosongkan data pada range tertentu
     *
     * @param string $spreadsheetId
     * @param string $range
     * @return void
     */
    public function clearValues(string $spreadsheetId, string $range): void
    {
        $this->service->spreadsheets_values->clear($spreadsheetId, $range, new \Google\Service\Sheets\ClearValuesRequest());
    }

    /**
     * Membuat tab/sheet baru pada Google Sheet
     *
     * @param string $spreadsheetId
     * @param string $sheetTitle
     * @return void
     */
    public function addSheet(string $spreadsheetId, string $sheetTitle): void
    {
        // Pengecekan apakah sheet sudah ada
        $spreadsheet = $this->service->spreadsheets->get($spreadsheetId);
        $sheets = $spreadsheet->getSheets();
        
        foreach ($sheets as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetTitle) {
                return; // Sheet sudah ada
            }
        }

        $body = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => [
                'addSheet' => [
                    'properties' => [
                        'title' => $sheetTitle
                    ]
                ]
            ]
        ]);

        $this->service->spreadsheets->batchUpdate($spreadsheetId, $body);

        // Langsung inisialisasi header setelah dibuat
        $this->updateValues($spreadsheetId, $sheetTitle . '!A1:J1', [[
            'ID', 'Event ID', 'Nama Event', 'Nama Peserta', 'Email', 'NIM',
            'No. Telepon', 'Status', 'Bukti Bayar', 'Didaftarkan Pada',
        ]]);
    }

    /**
     * Mendapatkan daftar semua sheet di dalam spreadsheet
     *
     * @param string $spreadsheetId
     * @return array
     */
    public function getSheetsList(string $spreadsheetId): array
    {
        $spreadsheet = $this->service->spreadsheets->get($spreadsheetId);
        return $spreadsheet->getSheets();
    }

    /**
     * Menghapus sheet berdasarkan ID sheet
     *
     * @param string $spreadsheetId
     * @param int $sheetId
     * @return void
     */
    public function deleteSheet(string $spreadsheetId, int $sheetId): void
    {
        $body = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
            'requests' => [
                [
                    'deleteSheet' => [
                        'sheetId' => $sheetId
                    ]
                ]
            ]
        ]);

        $this->service->spreadsheets->batchUpdate($spreadsheetId, $body);
    }
}
