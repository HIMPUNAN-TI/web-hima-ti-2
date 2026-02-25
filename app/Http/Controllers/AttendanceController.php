<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::orderByDesc('id')->get();
        $viewData = [
            'title' => 'Attendances',
            'events' => $events,
        ];
        
        return view('admin.attendances.index', $viewData);
    }
}
