<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class BookingApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public string $qrPath; // relative OR absolute

    public function __construct($booking, string $qrPath)
    {
        $this->booking = $booking;
        $this->qrPath  = $qrPath;
    }

    public function build()
    {
        // Resolve absolute path
        $qrPath = storage_path('app/public/qr/booking-'.$this->booking->id.'.png');

        $cid = null;
        $this->withSymfonyMessage(function (Email $email) use ($qrPath, &$cid) {
            // simpan inline & ambil CID yang dihasilkan
            $cid = $email->embedFromPath($qrPath, 'qr.png');
            // catatan: $cid formatnya "cid:xxxx@..."; biarkan apa adanya
        });

        return $this->subject('Persetujuan Booking - '.$this->booking->name)
            ->view('emails.bookings.approved')
            ->with([
                'booking' => $this->booking,
                'qrCid'   => $cid,   // kirim ke view
        ]);
    }
}
