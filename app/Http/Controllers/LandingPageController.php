<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Payment;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    protected GoogleSheetsService $sheets;
    protected string $spreadsheetId;
    protected string $sheetName = 'Pendaftaran';

    public function __construct(GoogleSheetsService $sheets)
    {
        $this->sheets = $sheets;
        $this->spreadsheetId = config('services.google.spreadsheet_id');
    }

    /**
     * Full re-sync semua data registrasi ke sheet 'Registrasi'.
     */
    protected function fullSyncRegistrationsToSheets(): void
    {
        try {
            $payments = Payment::with(['event', 'member'])->orderBy('id')->get();

            if ($payments->isEmpty()) {
                return;
            }

            $paymentsByEvent = $payments->groupBy('event_id');

            foreach ($paymentsByEvent as $eventId => $eventPayments) {
                $event = $eventPayments->first()->event;
                $eventNameParam = $event ? $event->name : 'Unknown';
                $sheetTitle = $eventNameParam . ' Pendaftaran';

                // Pastikan tab event ada, jika tidak tambahkan
                $this->sheets->addSheet($this->spreadsheetId, $sheetTitle);

                // Clear data lama (baris 2 ke bawah)
                $this->sheets->clearValues($this->spreadsheetId, $sheetTitle . '!A2:J9999');

                $rows = $eventPayments->map(fn(Payment $p) => [
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

                $endRow = count($rows) + 1;
                $this->sheets->updateValues(
                    $this->spreadsheetId,
                    $sheetTitle . '!A2:J' . $endRow,
                    $rows
                );
            }
        } catch (\Throwable $e) {
            Log::error('Google Sheets registrasi sync failed: ' . $e->getMessage());
        }
    }

    public function index()
    {
        // Get highlighted event (most recent or featured)
        $highlightedEvent = Event::latest()->first();
        
        // Get other events (excluding highlighted)
        $events = Event::where('id', '!=', $highlightedEvent?->id)
                      ->latest()
                      ->take(8) // For 3x3 grid (9 total - 1 highlighted = 8)
                      ->get();

        // Sub-kompetisi Geteksi dari database (type=kompetisi)
        $geteksiKompetisi = Event::where('type', 'kompetisi')->latest()->get();

        return view('landing.home.index', compact('highlightedEvent', 'events', 'geteksiKompetisi'));
    }

    public function about()
    {
        $title = 'Tentang Kami';

        return view('landing.about.index', compact('title'));
    }

    public function events()
    {
        // Get highlighted event (most recent or featured)
        $highlightedEvent = Event::latest()->first();
        
        // Get other events (excluding highlighted)
        $events = Event::where('id', '!=', $highlightedEvent?->id)
                      ->latest()
                      ->take(8) // For 3x3 grid (9 total - 1 highlighted = 8)
                      ->get();

        // Sub-kompetisi Geteksi dari database (type=kompetisi)
        $geteksiKompetisi = Event::where('type', 'kompetisi')->latest()->get();

        $title = 'Events';

        return view('landing.events.index', compact('highlightedEvent', 'events', 'geteksiKompetisi', 'title'));
    }

    public function eventDetail($id)
    {
        $event = Event::find($id);

        if ($event === null) {
            return redirect()->route('landing.events.index')->with('error', 'Event not found.');
        }

        if (Auth::check() && !Auth::user()->member) {
            return redirect()->route('landing.index')->with('error', 'Silakan lengkapi profil Anda terlebih dahulu sebelum mendaftar event.');
        }

        $title = $event->name;

        return view('landing.events.detail', compact('event', 'title'));
    }

    public function eventRegister($id)
    {
        $event = Event::find($id);

        if ($event === null) {
            return redirect()->route('landing.events.index')->with('error', 'Event not found.');
        }

        if (Auth::check() && !Auth::user()->member) {
            return redirect()->route('landing.index')->with('error', 'Silakan lengkapi profil Anda terlebih dahulu sebelum mendaftar event.');
        }

        $title = $event->name;

        return view('landing.events.register', compact('event', 'title'));
    }

    public function submitEventRegistration(Request $request, $id)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('payments')->where(function ($query) use ($request) {
                    return $query->where('event_id', $request->event_id);
                }),
            ],
            'nim' => [
                'required',
                'string',
                'max:50',
                \Illuminate\Validation\Rule::unique('payments')->where(function ($query) use ($request) {
                    return $query->where('event_id', $request->event_id);
                }),
            ],
            'phone' => 'required|string|max:20',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'email.unique' => 'Email ini sudah terdaftar pada event ini.',
            'nim.unique' => 'NIM ini sudah terdaftar pada event ini.',
        ]);

        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('landing.events.index')->with('error', 'Event not found.');
        }

        if (Auth::check() && !Auth::user()->member) {
            return redirect()->back()->with('error', 'Silakan lengkapi profil member Anda terlebih dahulu.');
        }

        // Handle payment proof upload
        $paymentProofName = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofFile = $request->file('payment_proof');
            $paymentProofName = time() . '_payment_proof_' . $paymentProofFile->getClientOriginalName();
            
            // Create directory if it doesn't exist
            if (!is_dir(public_path('image/proof_of_payments'))) {
                mkdir(public_path('image/proof_of_payments'), 0755, true);
            }
            
            $paymentProofFile->move(public_path('image/proof_of_payments'), $paymentProofName);
        }

        Payment::create([
            'event_id' => $request->event_id,
            'member_id' => $request->member_id,
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'telephone_number' => $request->phone,
            'status' => Payment::STATUS_PENDING,
            'proof_of_payment' => $paymentProofName,
        ]);

        // Sync ke Google Sheets secara real-time
        $this->fullSyncRegistrationsToSheets();

        return redirect()->route('landing.events.detail', $id)->with('success', 'Registrasi berhasil!. Silahkan tunggu konfirmasi dari panitia.');
    }

    public function myEvents()
    {
        $title = 'Event Saya';
        
        $user = Auth::user();
        
        if (!$user->member) {
            return redirect()->route('landing.index')->with('error', 'Data member tidak ditemukan.');
        }
        
        $memberId = $user->member->id;
        $userNim = $user->member->nim;
        
        // Prioritize member_id, fallback to nim if member_id not found
        $registrations = Payment::with('event')
                                ->where('member_id', $memberId)
                                ->orWhere(function($query) use ($userNim) {
                                    $query->where('nim', $userNim)
                                          ->whereNull('member_id');
                                })
                                ->orderBy('created_at', 'desc')
                                ->get();
    
        return view('landing.profile.my-events', compact('registrations', 'title'));
    }

    public function contact()
    {
        $title = 'Kontak';

        return view('landing.contact.index', compact('title'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->route('landing.contact.index')->with('success', 'Pesan Anda berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
