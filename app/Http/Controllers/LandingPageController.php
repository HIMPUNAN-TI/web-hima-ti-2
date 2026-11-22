<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingPageController extends Controller
{
    public function index()
    {
        // Get highlighted event (most recent or featured)
        $highlightedEvent = Event::latest()->first();
        
        // Get other events (excluding highlighted)
        $events = Event::where('id', '!=', $highlightedEvent?->id)
                      ->latest()
                      ->take(8) // For 3x3 grid (9 total - 1 highlighted = 8)
                      ->get();

        return view('landing.home.index', compact('highlightedEvent', 'events'));
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

        $title = 'Events';

        return view('landing.events.index', compact('highlightedEvent', 'events', 'title'));
    }

    public function eventDetail($id)
    {
        $event = Event::find($id);

        if ($event === null) {
            return redirect()->route('landing.events.index')->with('error', 'Event not found.');
        }

        $title = $event->name;

        // Cek apakah user yang sedang login sudah pernah mendaftar pada event ini
        $userRegistration = null;
        if (Auth::check() && Auth::user()->member) {
            $userRegistration = Payment::where('event_id', $id)
                ->where('member_id', Auth::user()->member->id)
                ->first();
        }

        return view('landing.events.detail', compact('event', 'title', 'userRegistration'));
    }

    public function eventRegister($id)
    {
        $event = Event::find($id);

        if ($event === null) {
            return redirect()->route('landing.events.index')->with('error', 'Event not found.');
        }

        $user = Auth::user();
        $member = $user?->member;

        // Requirement 2: Data peserta (Nama, No. HP, Institusi) wajib lengkap sebelum mendaftar kegiatan
        if (!$member || empty($user->name) || empty($member->telephone_number) || empty($member->institution)) {
            session(['redirect_after_profile' => route('landing.events.register', $id)]);
            return redirect()->route('landing.profile.edit')
                ->with('warning', 'Data profil Anda belum lengkap. Silakan lengkapi nama, nomor HP, dan asal institusi Anda terlebih dahulu sebelum mendaftar kegiatan.');
        }

        // Requirement 3: Periksa batas tenggat pendaftaran
        if ($event->isDeadlinePassed()) {
            return redirect()->route('landing.events.detail', $id)
                ->with('error', 'Batas waktu pendaftaran untuk kegiatan ini telah berakhir pada ' . \Carbon\Carbon::parse($event->regist_end_date)->format('d F Y') . '.');
        }

        // Requirement 3: Periksa kuota kegiatan
        if ($event->isFull()) {
            return redirect()->route('landing.events.detail', $id)
                ->with('error', 'Mohon maaf, kuota pendaftaran untuk kegiatan ini telah penuh.');
        }

        // Requirement 3: Periksa pendaftaran ganda (mencegah mendaftar lebih dari sekali)
        $existingRegistration = Payment::where('event_id', $id)
            ->where('member_id', $member->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('landing.profile.my-events')
                ->with('warning', 'Anda sudah pernah mendaftar kegiatan ini dengan status: ' . ucfirst($existingRegistration->status) . ' (Nomor Registrasi: ' . ($existingRegistration->registration_code ?? '-') . ').');
        }

        $title = $event->name;

        return view('landing.events.register', compact('event', 'title', 'user', 'member'));
    }

    public function submitEventRegistration(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()->route('landing.events.index')->with('error', 'Event not found.');
        }

        $user = Auth::user();
        $member = $user?->member;

        // Requirement 2: Pengecekan kelengkapan profil peserta
        if (!$member || empty($user->name) || empty($member->telephone_number) || empty($member->institution)) {
            session(['redirect_after_profile' => route('landing.events.register', $id)]);
            return redirect()->route('landing.profile.edit')
                ->with('warning', 'Data profil Anda belum lengkap. Silakan lengkapi nama, nomor HP, dan asal institusi Anda terlebih dahulu sebelum mendaftar kegiatan.');
        }

        // Requirement 3: Periksa batas tenggat pendaftaran di sisi server
        if ($event->isDeadlinePassed()) {
            return redirect()->route('landing.events.detail', $id)
                ->with('error', 'Batas waktu pendaftaran untuk kegiatan ini telah berakhir.');
        }

        // Requirement 3: Periksa kuota kegiatan di sisi server
        if ($event->isFull()) {
            return redirect()->route('landing.events.detail', $id)
                ->with('error', 'Mohon maaf, kuota pendaftaran untuk kegiatan ini telah penuh.');
        }

        // Requirement 3: Periksa pendaftaran ganda di sisi server
        $existingRegistration = Payment::where('event_id', $id)
            ->where('member_id', $member->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->route('landing.profile.my-events')
                ->with('warning', 'Anda sudah terdaftar pada kegiatan ini.');
        }

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'member_id' => 'required|exists:members,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'institution' => 'required|string|max:255',
            'nim' => 'nullable|string|max:50',
            'phone' => 'required|string|max:20',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Sinkronisasi data member jika ada pembaruan di form
        if ($member) {
            $member->update([
                'telephone_number' => $request->phone,
                'institution' => $request->institution,
                'nim' => $request->filled('nim') ? $request->nim : $member->nim,
            ]);
        }

        // Handle payment proof upload jika disertakan
        $paymentProofName = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofFile = $request->file('payment_proof');
            $paymentProofName = time() . '_payment_proof_' . $paymentProofFile->getClientOriginalName();
            
            if (!is_dir(public_path('image/proof_of_payments'))) {
                mkdir(public_path('image/proof_of_payments'), 0755, true);
            }
            
            $paymentProofFile->move(public_path('image/proof_of_payments'), $paymentProofName);
        }

        // Requirement 3: Generate nomor unik pendaftaran
        $registrationCode = Payment::generateRegistrationCode($event->id);

        // Requirement 3: Tentukan status pendaftaran
        // Kegiatan gratis langsung 'terdaftar', kegiatan berbayar 'menunggu pembayaran' (atau 'menunggu verifikasi' jika bukti langsung diunggah)
        if ($event->isFree()) {
            $status = Payment::STATUS_REGISTERED;
            $successMsg = "Pendaftaran berhasil! Anda telah resmi terdaftar pada kegiatan gratis ini dengan nomor pendaftaran: $registrationCode.";
        } else {
            $status = $paymentProofName ? Payment::STATUS_PENDING : Payment::STATUS_UNPAID;
            $successMsg = $paymentProofName 
                ? "Pendaftaran berhasil dengan nomor $registrationCode! Bukti pembayaran telah diterima dan sedang menunggu verifikasi panitia."
                : "Pendaftaran berhasil dengan nomor unik $registrationCode! Status Anda saat ini Menunggu Pembayaran. Silakan selesaikan pembayaran.";
        }

        Payment::create([
            'registration_code' => $registrationCode,
            'event_id' => $event->id,
            'member_id' => $member->id,
            'name' => $request->name,
            'email' => $request->email,
            'institution' => $request->institution,
            'nim' => $request->filled('nim') ? $request->nim : null,
            'telephone_number' => $request->phone,
            'status' => $status,
            'proof_of_payment' => $paymentProofName,
        ]);

        return redirect()->route('landing.profile.my-events')->with('success', $successMsg);
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