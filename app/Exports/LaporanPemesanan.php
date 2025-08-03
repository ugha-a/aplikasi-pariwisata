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
        $wisataStats = Booking::with('travel_package')
            ->selectRaw('travel_package_id')
            ->groupBy('travel_package_id')
            ->get()
            ->map(function ($item) {
                $travelPackage = $item->travel_package;

                // Hitung per waktu
                $hariIni = Booking::where('travel_package_id', $item->travel_package_id)
                    ->whereDate('created_at', Carbon::today())
                    ->count();

                $minggu = Booking::where('travel_package_id', $item->travel_package_id)
                    ->whereBetween('created_at', [
                        Carbon::now()->subDays(6)->startOfDay(),
                        Carbon::now()->endOfDay()
                    ])
                    ->count();

                $bulan = Booking::where('travel_package_id', $item->travel_package_id)
                    ->whereBetween('created_at', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ])
                    ->count();

                $total = Booking::where('travel_package_id', $item->travel_package_id)
                    ->count();

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
