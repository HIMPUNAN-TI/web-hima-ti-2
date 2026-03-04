<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;

class GoogleSheetsController extends Controller
{
    protected GoogleSheetsService $sheets;

    // Ganti dengan ID Google Sheet kamu (ambil dari URL)
    // Contoh URL: https://docs.google.com/spreadsheets/d/SPREADSHEET_ID/edit
    protected string $spreadsheetId;

    public function __construct(GoogleSheetsService $sheets)
    {
        $this->sheets = $sheets;
        $this->spreadsheetId = config('services.google.spreadsheet_id');
    }

    /**
     * Tampilkan data dari Google Sheet
     */
    public function index()
    {
        // Ambil data dari Sheet1, kolom A sampai E, baris 1 sampai 100
        $data = $this->sheets->getValues($this->spreadsheetId, 'Sheet1!A1:E100');

        return view('sheets.index', ['rows' => $data]);
    }

    /**
     * Simpan data baru ke Google Sheet
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|string|max:100',
            'nim'   => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        // Format data sebagai array 2D (tiap inner array = satu baris)
        $values = [[
            $request->nama,
            $request->nim,
            $request->email,
            now()->format('Y-m-d H:i:s'), // timestamp otomatis
        ]];

        // Append ke baris terakhir yang tersedia di Sheet1
        $this->sheets->appendValues($this->spreadsheetId, 'Sheet1!A:D', $values);

        return redirect()->route('sheets.index')->with('success', 'Data berhasil disimpan ke Google Sheets!');
    }
}
