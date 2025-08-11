<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\TravelPackage;

class TravelPackageController extends Controller
{
    public function index()
    {
        $travel_packages = TravelPackage::query()
            ->when(request('search'), function ($q, $s) {
                $q->where(function ($qq) use ($s) {
                    $qq->whereHas('locations', function ($lq) use ($s) {
                        $lq->where('name', 'like', "%$s%");
                    })
                    ->orWhere('name', 'like', "%$s%");
                });
            })
            // Filter lokasi (ID)
            ->when(request('lokasi'), function ($q, $l) {
                $q->where('location', $l);
            })
            ->with(['galleries', 'locations'])
            ->paginate(6);
        $locations = Location::all(['name', 'id']);

        return view('travel_packages.index', compact('travel_packages', 'locations'));
    }

    public function show(TravelPackage $travel_package)
    {
        $travel_packages = TravelPackage::where('id', '!=', $travel_package->id)->get();

        return view('travel_packages.show', compact('travel_package', 'travel_packages'));
    }
}
