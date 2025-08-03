<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Visit;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanKunjungan implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view() : View
    {
        
        $visitStats = [
            'hari_ini' => Visit::whereDate('created_at', Carbon::today())->count(),
            'minggu'   => Visit::whereBetween('created_at', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])->count(),
            'bulan'    => Visit::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->count(),
            'total'    => Visit::count(),
        ];


        return view('exports.laporan-kunjungan', compact('visitStats'));
    }
}
