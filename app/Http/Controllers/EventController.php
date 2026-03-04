<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    protected GoogleSheetsService $sheets;
    protected string $spreadsheetId;
    protected string $sheetName = 'Events'; // nama tab/sheet di spreadsheet

    public function __construct(GoogleSheetsService $sheets)
    {
        $this->sheets = $sheets;
        $this->spreadsheetId = config('services.google.spreadsheet_id');
    }

    /**
     * Sync satu event ke Google Sheets.
     * Cari baris berdasarkan ID di kolom A, lalu update.
     * Jika belum ada, append baris baru.
     */
    protected function syncEventToSheets(Event $event): void
    {
        try {
            $row = [
                $event->id,
                $event->name,
                (float) $event->price,
                $event->date?->format('Y-m-d'),
                $event->regist_start_date?->format('Y-m-d'),
                $event->regist_end_date?->format('Y-m-d'),
                $event->location,
                $event->description,
                $event->maps,
                $event->created_at?->format('Y-m-d H:i:s'),
            ];

            // Baca semua data untuk cari baris dengan ID yang sama
            $existing = $this->sheets->getValues(
                $this->spreadsheetId,
                $this->sheetName . '!A:A'
            );

            $rowIndex = null;
            foreach ($existing as $i => $cell) {
                if (isset($cell[0]) && (string)$cell[0] === (string)$event->id) {
                    $rowIndex = $i + 1; // Google Sheets 1-indexed
                    break;
                }
            }

            if ($rowIndex) {
                // Update baris yang sudah ada
                $range = $this->sheetName . '!A' . $rowIndex . ':J' . $rowIndex;
                $this->sheets->updateValues($this->spreadsheetId, $range, [$row]);
            } else {
                // Belum ada, tambah baris baru
                $this->sheets->appendValues(
                    $this->spreadsheetId,
                    $this->sheetName . '!A:J',
                    [$row]
                );
            }
        } catch (\Throwable $e) {
            Log::error('Google Sheets sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Hapus baris event dari Google Sheets berdasarkan ID.
     * (Isi sel jadi kosong — clear row)
     */
    protected function removeEventFromSheets(int $eventId): void
    {
        try {
            $existing = $this->sheets->getValues(
                $this->spreadsheetId,
                $this->sheetName . '!A:A'
            );

            foreach ($existing as $i => $cell) {
                if (isset($cell[0]) && (string)$cell[0] === (string)$eventId) {
                    $rowIndex = $i + 1;
                    $this->sheets->clearValues(
                        $this->spreadsheetId,
                        $this->sheetName . '!A' . $rowIndex . ':J' . $rowIndex
                    );
                    break;
                }
            }
        } catch (\Exception $e) {
            Log::error('Google Sheets delete sync failed: ' . $e->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::orderByDesc('id')->get();
        $viewData = [
            'title' => 'Events',
            'events' => $events,
        ];
        
        return view('admin.events.index', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'regist_start_date' => ['required', 'date', 'before_or_equal:regist_end_date'],
            'regist_end_date' => ['required', 'date', 'after_or_equal:regist_start_date', 'before_or_equal:date'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'poster' => ['nullable', 'file', 'image', 'max:2048'],
            'certificate' => ['nullable', 'file', 'image', 'max:2048'],
            'maps' => ['required', 'url'],
        ], [
            'name.required' => 'Nama event wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'date.required' => 'Tanggal event wajib diisi',
            'date.after_or_equal' => 'Tanggal event tidak boleh kurang dari hari ini',
            'regist_start_date.required' => 'Tanggal mulai registrasi wajib diisi',
            'regist_start_date.before_or_equal' => 'Tanggal mulai registrasi harus sebelum atau sama dengan tanggal selesai registrasi',
            'regist_end_date.required' => 'Tanggal selesai registrasi wajib diisi',
            'regist_end_date.after_or_equal' => 'Tanggal selesai registrasi harus setelah atau sama dengan tanggal mulai registrasi',
            'regist_end_date.before_or_equal' => 'Tanggal selesai registrasi harus sebelum atau sama dengan tanggal event',
            'location.required' => 'Lokasi wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'poster.image' => 'File poster harus berupa gambar',
            'poster.max' => 'Ukuran poster maksimal 2MB',
            'certificate.image' => 'File sertifikat harus berupa gambar',
            'certificate.max' => 'Ukuran sertifikat maksimal 2MB',
            'maps.required' => 'Link maps wajib diisi',
            'maps.url' => 'Link maps harus berupa URL yang valid',
        ]);

        try {
            $eventData = [
                'name' => $validated['name'],
                'price' => $validated['price'],
                'date' => $validated['date'],
                'regist_start_date' => $validated['regist_start_date'],
                'regist_end_date' => $validated['regist_end_date'],
                'location' => $validated['location'],
                'description' => $validated['description'],
                'maps' => $validated['maps'] ?? null,
            ];

            // Handle poster upload
            if ($request->hasFile('poster')) {
                $posterFile = $request->file('poster');
                $posterName = time() . '_poster_' . $posterFile->getClientOriginalName();
                $posterFile->move(public_path('image/events/posters'), $posterName);
                $eventData['poster'] = $posterName;
            }

            // Handle certificate upload
            if ($request->hasFile('certificate')) {
                $certificateFile = $request->file('certificate');
                $certificateName = time() . '_certificate_' . $certificateFile->getClientOriginalName();
                $certificateFile->move(public_path('image/events/certificates'), $certificateName);
                $eventData['certificate'] = $certificateName;
            }

            $event = Event::create($eventData);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal membuat event: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat event: ' . $e->getMessage())->withInput();
        }

        // Sync ke Google Sheets (terpisah dari try-catch utama agar tidak menggagalkan simpan event)
        $this->syncEventToSheets($event->fresh());

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'regist_start_date' => ['required', 'date', 'before_or_equal:regist_end_date'],
            'regist_end_date' => ['required', 'date', 'after_or_equal:regist_start_date', 'before_or_equal:date'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'poster' => ['nullable', 'file', 'image', 'max:2048'],
            'certificate' => ['nullable', 'file', 'image', 'max:2048'],
            'maps' => ['required', 'url'],
        ], [
            'name.required' => 'Nama event wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.numeric' => 'Harga harus berupa angka',
            'price.min' => 'Harga tidak boleh negatif',
            'date.required' => 'Tanggal event wajib diisi',
            'regist_start_date.required' => 'Tanggal mulai registrasi wajib diisi',
            'regist_start_date.before_or_equal' => 'Tanggal mulai registrasi harus sebelum atau sama dengan tanggal selesai registrasi',
            'regist_end_date.required' => 'Tanggal selesai registrasi wajib diisi',
            'regist_end_date.after_or_equal' => 'Tanggal selesai registrasi harus setelah atau sama dengan tanggal mulai registrasi',
            'regist_end_date.before_or_equal' => 'Tanggal selesai registrasi harus sebelum atau sama dengan tanggal event',
            'location.required' => 'Lokasi wajib diisi',
            'description.required' => 'Deskripsi wajib diisi',
            'poster.image' => 'File poster harus berupa gambar',
            'poster.max' => 'Ukuran poster maksimal 2MB',
            'certificate.image' => 'File sertifikat harus berupa gambar',
            'certificate.max' => 'Ukuran sertifikat maksimal 2MB',
            'maps.required' => 'Link maps wajib diisi',
            'maps.url' => 'Link maps harus berupa URL yang valid',
        ]);

        try {
            $eventData = [
                'name' => $validated['name'],
                'price' => $validated['price'],
                'date' => $validated['date'],
                'regist_start_date' => $validated['regist_start_date'],
                'regist_end_date' => $validated['regist_end_date'],
                'location' => $validated['location'],
                'description' => $validated['description'],
                'maps' => $validated['maps'] ?? $event->maps,
            ];

            // Handle poster upload
            if ($request->hasFile('poster')) {
                // Delete old poster if exists
                if ($event->poster && file_exists(public_path('image/events/posters/' . $event->poster))) {
                    unlink(public_path('image/events/posters/' . $event->poster));
                }
                
                $posterFile = $request->file('poster');
                $posterName = time() . '_poster_' . $posterFile->getClientOriginalName();
                $posterFile->move(public_path('image/events/posters'), $posterName);
                $eventData['poster'] = $posterName;
            }

            // Handle certificate upload
            if ($request->hasFile('certificate')) {
                // Delete old certificate if exists
                if ($event->certificate && file_exists(public_path('image/events/certificates/' . $event->certificate))) {
                    unlink(public_path('image/events/certificates/' . $event->certificate));
                }
                
                $certificateFile = $request->file('certificate');
                $certificateName = time() . '_certificate_' . $certificateFile->getClientOriginalName();
                $certificateFile->move(public_path('image/events/certificates'), $certificateName);
                $eventData['certificate'] = $certificateName;
            }

            $event->update($eventData);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal update event: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui event: ' . $e->getMessage())->withInput();
        }

        // Sync ke Google Sheets (terpisah dari try-catch utama agar tidak menggagalkan update event)
        $this->syncEventToSheets($event->fresh());

        return redirect()->route('events.index')->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        try {
            // Delete associated files
            if ($event->poster && file_exists(public_path('image/events/posters/' . $event->poster))) {
                unlink(public_path('image/events/posters/' . $event->poster));
            }
            
            if ($event->certificate && file_exists(public_path('image/events/certificates/' . $event->certificate))) {
                unlink(public_path('image/events/certificates/' . $event->certificate));
            }

            $eventId = $event->id;
            $event->delete();

            // Hapus dari Google Sheets
            $this->removeEventFromSheets($eventId);

            return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('events.index')->with('error', 'Terjadi kesalahan saat menghapus event.');
        }
    }
}
