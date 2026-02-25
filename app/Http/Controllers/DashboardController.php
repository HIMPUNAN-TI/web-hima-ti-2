<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Payment;
use App\Models\Contact;
use App\Models\Member;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total member (asumsi role user adalah member)
        $totalMembers = Member::count();
        
        // Hitung total event
        $totalEvents = Event::count();
        
        // Hitung total payment dan pending payment
        $totalPayments = Payment::count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        
        // Ambil data inbox dari tabel contacts (10 terbaru)
        $contacts = Contact::orderBy('created_at', 'desc')->take(10)->get();
        
        return view('admin.dashboard.index', compact(
            'totalMembers',
            'totalEvents',
            'totalPayments',
            'pendingPayments',
            'contacts'
        ));
    }
}