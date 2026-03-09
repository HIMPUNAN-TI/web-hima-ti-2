<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
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
            'type' => ['required', 'string', 'in:general,geteksi,kompetisi,famgath'],
            'parent_event_name' => ['nullable', 'string', 'max:255'],
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
            'type.required' => 'Tipe event wajib dipilih',
            'type.in'       => 'Tipe event tidak valid',
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
                'name'            => $validated['name'],
                'type'            => $validated['type'],
                'parent_event_name' => $validated['parent_event_name'] ?? null,
                'price'           => $validated['price'],
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
            'type' => ['required', 'string', 'in:general,geteksi,kompetisi,famgath'],
            'parent_event_name' => ['nullable', 'string', 'max:255'],
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
            'type.required' => 'Tipe event wajib dipilih',
            'type.in'       => 'Tipe event tidak valid',
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
                'name'            => $validated['name'],
                'type'            => $validated['type'],
                'parent_event_name' => $validated['parent_event_name'] ?? null,
                'price'           => $validated['price'],
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

            return redirect()->route('events.index')->with('success', 'Event berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('events.index')->with('error', 'Terjadi kesalahan saat menghapus event.');
        }
    }

    /**
     * Export daftar peserta (payments) untuk event ini ke format CSV
     */
    public function exportParticipants(Event $event)
    {
        $payments = \App\Models\Payment::with('member')->where('event_id', $event->id)->orderBy('id')->get();
        
        $filename = "peserta_" . \Illuminate\Support\Str::slug($event->name) . "_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ["ID", "Nama", "Email", "NIM", "Nomor Telepon", "Status", "Bukti Pembayaran", "Tanggal Daftar"];

        $callback = function() use($payments, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($payments as $payment) {
                $proofUrl = $payment->proof_of_payment ? url('image/proof_of_payments/' . $payment->proof_of_payment) : '-';
                fputcsv($file, [
                    $payment->id,
                    $payment->name,
                    $payment->email,
                    $payment->nim,
                    $payment->telephone_number,
                    $payment->status,
                    $proofUrl,
                    $payment->created_at ? $payment->created_at->format('Y-m-d H:i:s') : ''
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
