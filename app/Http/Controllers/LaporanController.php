<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\LaporanPemesanan;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function laporanExcelPesanan() {
        $filename = 'laporan-pemesanan-' . date('Y-m-d') . '.xlsx';

        if (ob_get_contents()) ob_end_clean();
        return Excel::download(new LaporanPemesanan, $filename, \Maatwebsite\Excel\Excel::XLSX);
    }
}
