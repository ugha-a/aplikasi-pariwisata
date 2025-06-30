<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LokasiWisatacontroller extends Controller
{
     public function index()
    {
        return view('locations.index');
    }
}
