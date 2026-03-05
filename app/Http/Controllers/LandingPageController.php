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
            'email' => 'required|email|max:255',
            'nim' => 'required|string|max:50',
            'phone' => 'required|string|max:20',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
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
