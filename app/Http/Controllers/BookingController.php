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

             // Ambil data tervalidasi
        $data = $request->validated();

        // Simpan bukti pembayaran (wajib sesuai rules)
        if ($request->hasFile('payment_proof')) {
            // disimpan ke storage/app/public/payment_proofs/...
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $data['payment_proof_path'] = $path;
        }

        // Simpan booking
        // Pastikan model Booking memiliki fillable yang sesuai:
        // ['travel_package_id','name','email','number_phone','date','check_in','check_out','payment_method','payment_proof_path']
        Booking::create($data);

        return back()->with([
            'message' => "Terima kasih! Pemesanan kamu sudah kami terima. Pembayaran akan diproses maksimal 1x24 jam."
        ]);

        } catch (\Exception $e) {
            dd($e);
        }
       
    }
}
