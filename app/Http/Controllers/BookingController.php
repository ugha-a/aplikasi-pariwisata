<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function store(BookingRequest $request)
    {
        try {
            $data = $request->validated();
    
            if ($request->hasFile('file')) {
                // Simpan ke storage/app/public/payment_proofs
                $storedPath = $request->file('file')->store('payment_proofs', 'public');
    
                // simpan path ke field "file"
                $data['file'] = $storedPath;
            }
    
            Booking::create($data);
    
            return back()->with('message', "Terima kasih! Pemesanan kamu sudah kami terima.");
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
