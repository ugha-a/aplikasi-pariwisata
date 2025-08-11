<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Booking::with(['travel_package']);

        // Jika user login adalah pengelola
        if (auth()->user()->role === 'pengelola') {
            $query->whereHas('travel_package', function ($q) {
                $q->where('user_id', auth()->id()); // asumsi kolom pengelola di travel_packages = user_id
            });
        }

        $bookings = $query->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with('travel_package')->findOrFail($id);

        $booking->update(['status' => 'di-setujui']);
    
        // Pastikan nomor WA bersih dari spasi/tanda lain
        $phone = preg_replace('/\D/', '', $booking->number_phone);
    
        // Pastikan nomor sudah format internasional (Indonesia: mulai 62)
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
    
        $message = "Halo {$booking->name}, booking Anda telah disetujui.";
        $url = "https://wa.me/{$phone}?text=" . urlencode($message);
    
        return redirect()->away($url);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->back()->with([
            'message' => 'success deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
