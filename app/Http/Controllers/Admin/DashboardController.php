<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\TravelPackage;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {

        $namaWisata = Booking::with('travel_package')->get();
        $grouped = $namaWisata->groupBy('travel_package_id')->map(function ($items) {
            return [
                'travel_package' => $items->first()->travel_package,
                'jumlah' => $items->count(),
            ];
        })->sortByDesc('jumlah')->take(10);

        return view('admin.dashboard', [
            // 'kunjungan' => Location::count(),
            'wisata' => $grouped,
        ]);
    }
}
