<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Locatinon;
use Illuminate\Http\Request;
use App\Models\TravelPackage;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'kunjungan' => Locatinon::count(),
            'pemesanan' => Booking::count(),
            'wisata' => TravelPackage::count(),
        ]);
    }
}
