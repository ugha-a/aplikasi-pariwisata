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
            'travel_package_id' => ['required','integer'],
            'name'             => ['required','string','max:255'],
            'email'            => ['required','email'],
            'number_phone'     => ['required','string','max:30'],
            'date'             => ['required','date'],
            'check_in'         => ['required'],
            'check_out'        => ['required'],
            'payment_method'   => ['nullable','in:bank,ewallet'],
            // ini nama input di form modal
            'file'             => ['required','image','mimes:jpg,jpeg,png','max:10240'], // 10MB
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
