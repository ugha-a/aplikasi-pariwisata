<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPemesanan implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view() : View
    {
        $wisataStatsQuery = Booking::with('travel_package')
        ->selectRaw('travel_package_id');
    
    // Filter jika user adalah pengelola
    if (auth()->user()->role === 'pengelola') {
        $wisataStatsQuery->whereHas('travel_package', function ($q) {
            $q->where('user_id', auth()->id()); // sesuaikan nama kolom pengelola di tabel travel_packages
        });
    }
    
    $wisataStats = $wisataStatsQuery
        ->groupBy('travel_package_id')
        ->get()
        ->map(function ($item) {
            $travelPackage = $item->travel_package;
    
            // Base query untuk sub-count agar tidak duplikat logika filter
            $baseQuery = Booking::where('travel_package_id', $item->travel_package_id);
    
            if (auth()->user()->role === 'pengelola') {
                $baseQuery->whereHas('travel_package', function ($q) {
                    $q->where('user_id', auth()->id());
                });
            }
    
            $hariIni = (clone $baseQuery)
                ->whereDate('created_at', Carbon::today())
                ->count();
    
            $minggu = (clone $baseQuery)
                ->whereBetween('created_at', [
                    Carbon::now()->subDays(6)->startOfDay(),
                    Carbon::now()->endOfDay()
                ])
                ->count();
    
            $bulan = (clone $baseQuery)
                ->whereBetween('created_at', [
                    Carbon::now()->startOfMonth(),
                    Carbon::now()->endOfMonth()
                ])
                ->count();
    
            $total = (clone $baseQuery)->count();
    
            return [
                'nama_paket' => $travelPackage->type ?? 'Tidak diketahui',
                'hari_ini'   => $hariIni,
                'minggu'     => $minggu,
                'bulan'      => $bulan,
                'total'      => $total
            ];
        });
    

        return view('exports.laporan-pemesanan', compact(
            'wisataStats',
        ));
    }
}
