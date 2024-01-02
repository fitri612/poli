<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegistrationPoli;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'verified']);
    }
    public function index()
    {
        if (Auth::user()->role == 'doctor') {
            $pasien_today = RegistrationPoli::whereDate('created_at', date('Y-m-d'))->count();
            $pasien_waiting = RegistrationPoli::whereDate('created_at', date('Y-m-d'))->where('status', 'waiting')->count();
            $pasien_called = RegistrationPoli::whereDate('created_at', date('Y-m-d'))->where('status', 'called')->count();
            $pasien_canceled = RegistrationPoli::whereDate('created_at', date('Y-m-d'))->where('status', 'canceled')->count();
            $pasien_done = RegistrationPoli::whereDate('created_at', date('Y-m-d'))->where('status', 'done')->count();
            return view('dashboard.index', compact('pasien_today', 'pasien_waiting', 'pasien_called', 'pasien_canceled', 'pasien_done'));
        }
        $pasien_today = 0;
        $pasien_waiting = 0;
        $pasien_called = 0;
        $pasien_canceled = 0;
        $pasien_done = 0;
        return view('dashboard.index', compact('pasien_today', 'pasien_waiting', 'pasien_called', 'pasien_canceled', 'pasien_done'));
    }
}
