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
                ->when(request('search'), fn($q,$s)=>$q->where(function($qq) use ($s){
                    $qq->where('location','like',"%$s%")
                        ->orWhere('type','like',"%$s%");
                }))
                ->when(request('lokasi'), fn($q,$l)=>$q->whereRaw('LOWER(location) = ?', [$l]))
                ->with('galleries')
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
