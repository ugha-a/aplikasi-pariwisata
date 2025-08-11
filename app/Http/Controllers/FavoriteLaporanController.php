<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Exports\LaporanPemesanan;
use Maatwebsite\Excel\Facades\Excel;

class FavoriteLaporanController extends Controller
{
    public function laporanExcelPesanan() {
        $filename = 'laporan-pemesanan-' . date('Y-m-d') . '.xlsx';

        if (ob_get_contents()) ob_end_clean();
        return Excel::download(new LaporanPemesanan, $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function index() 
    {
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

        return view('admin.report.booking-report.index', [
            'topBooking' => $topBooking
        ]);
    }
}
