<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPemesanan implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view() : View
    {
        $data = [];

        return view('exports.laporan-pemesanan', compact('data'));
    }
}
