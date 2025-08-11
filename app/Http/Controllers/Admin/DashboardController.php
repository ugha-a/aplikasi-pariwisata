<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Booking;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\TravelPackage;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $travel_package = TravelPackage::query()
            ->when(auth()->user()->role === 'pengelola', function ($q) {
                $q->where('user_id', auth()->id()); // sesuaikan nama kolom pengelola
            })
            ->count();

        $booking = Booking::query()
            ->when(auth()->user()->role === 'pengelola', function ($q) {
                $q->whereHas('travel_package', function ($sub) {
                    $sub->where('user_id', auth()->id()); // sesuaikan kolom pengelola
                });
            })
            ->count();
        $topBookingQuery = Booking::with('travel_package')
            ->selectRaw('travel_package_id, COUNT(*) as total');

        // Jika user login adalah pengelola
        if (auth()->user()->role === 'pengelola') {
            $topBookingQuery->whereHas('travel_package', function ($q) {
                $q->where('user_id', auth()->id()); // sesuaikan nama kolom pengelola
            });
        }

        $topBooking = $topBookingQuery
            ->groupBy('travel_package_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'nama_paket' => $item->travel_package->name ?? 'Tidak diketahui',
                    'total'      => $item->total
                ];
            });

        $totalPengelola = User::where('role', 'pengelola')->count();

        return view('admin.dashboard', [
            // 'kunjungan' => Location::count(),
            'travel_package' => $travel_package,
            'booking' => $booking,
            'topBooking' => $topBooking,
            'totalPengelola' => $totalPengelola,
        ]);
    }
}
