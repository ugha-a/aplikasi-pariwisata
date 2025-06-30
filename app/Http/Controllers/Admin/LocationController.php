<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
       $location = Location::paginate(10);
        return view('admin.locations.index', [
            'locations' => $location
        ]);
    }

     /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'lat' => 'required|string',
            'lag' => 'required|string',
        ]);

        $location = Location::create($request->only(['name', 'description', 'lat', 'lag']));

        return redirect()->route('admin.locations.edit', $location->id)->with([
            'message' => 'Successfully created!',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'lat' => 'required|string',
            'lag' => 'required|string',
        ]);

        $location->update($request->only(['name', 'description', 'lat', 'lag']));

        return redirect()->route('admin.locations.index')->with([
            'message' => 'Successfully updated!',
            'alert-type' => 'info',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $location->delete();
    
        return redirect()->back()->with([
            'message' => 'Successfully deleted!',
            'alert-type' => 'danger',
        ]);
    }
}
