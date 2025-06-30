<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LokasiWisatacontroller extends Controller
{
     public function index()
    {
        $locations = Location::all(['name', 'lat', 'lag']);
        return view('locations.index', compact('locations'));
    }
}
