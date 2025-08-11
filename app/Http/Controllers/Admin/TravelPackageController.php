<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Gallery;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TravelPackage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TravelPackageRequest;

class TravelPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travel_packages = TravelPackage::with(['locations', 'users'])->paginate(10);

        return view('admin.travel_packages.index', compact('travel_packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all(['name', 'id']);
        $users = User::query()->where('role', 'pengelola')->get(['name', 'id']);
        return view('admin.travel_packages.create', compact('locations', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TravelPackageRequest $request)
    {
        
        if($request->validated()) {
            $slug = Str::slug($request->location, '-');
            $travel_package = TravelPackage::create($request->validated() + ['slug' => $slug ]);
        }

        return redirect()->route('admin.travel_packages.edit', [$travel_package])->with([
            'message' => 'Success Created !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelPackage $travel_package)
    {
        $galleries = Gallery::paginate(10);
        $locations = Location::all(['name', 'id']);
        $users = User::query()->where('role', 'pengelola')->get(['name', 'id']);
        
        return view('admin.travel_packages.edit', compact('travel_package','galleries', 'locations', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TravelPackageRequest $request, TravelPackage $travel_package)
    {
        if($request->validated()) {
            $slug = Str::slug($request->location, '-');
            $travel_package->update($request->validated() + ['slug' => $slug]);
        }

        return redirect()->route('admin.travel_packages.index')->with([
            'message' => 'Success Updated !',
            'alert-type' => 'info'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelPackage $travel_package)
    {
        $travel_package->delete();

        return redirect()->back()->with([
            'message' => 'Success Deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
