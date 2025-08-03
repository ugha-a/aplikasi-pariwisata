<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Exports\LaporanPemesanan;
use Maatwebsite\Excel\Facades\Excel;

class SalesLaporanController extends Controller
{
    public function laporanExcelPesanan() {
        $filename = 'laporan-pemesanan-' . date('Y-m-d') . '.xlsx';

        if (ob_get_contents()) ob_end_clean();
        return Excel::download(new LaporanPemesanan, $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function index()
    {
        $rawData = Visit::selectRaw('DATE(created_at) as tanggal, COUNT(*) as total')
            ->whereBetween('created_at', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal'); // ['2025-08-03' => 2, ...]

        $kunjunganPerHari = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $kunjunganPerHari->push([
                'tanggal' => $date,
                'total'   => $rawData[$date] ?? 0
            ]);
        }

        return view('admin.report.sales-report.index', [
            'kunjungan' => $kunjunganPerHari
        ]);
    }
}
