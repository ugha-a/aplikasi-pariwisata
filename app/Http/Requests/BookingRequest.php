<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'travel_package_id' => ['required','exists:travel_packages,id'],

            'name'          => ['required','string','max:100'],
            'email'         => ['required','email'],
            'number_phone'  => ['required','string','max:30'],

            'date'          => ['required','date'],
            'check_in'      => ['required','date_format:H:i'],
            'check_out'     => ['required','date_format:H:i'],

            // tambahan untuk pembayaran
            // 'payment_method' => ['required','in:bank,ewallet'],
            'file'  => ['required','image','mimes:jpg,jpeg,png','max:5120'], // <= 5MB

            // Jika kamu juga kirim field lain, tambah di sini
        ];
    }

    public function messages(): array
    {
        return [
            // 'payment_method.required' => 'Silakan pilih metode pembayaran.',
            // 'payment_method.in'       => 'Metode pembayaran tidak valid.',
            'file.required'  => 'Bukti pembayaran wajib diunggah.',
            'file.image'     => 'Bukti pembayaran harus berupa gambar.',
            'file.mimes'     => 'Format bukti harus JPG/PNG.',
            'file.max'       => 'Ukuran bukti maksimal 5MB.',
        ];
    }
}
