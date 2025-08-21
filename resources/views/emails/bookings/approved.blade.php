<p>Halo <strong>{{ $booking->name }}</strong>,</p>
<p>Silakan simpan dan tunjukkan QR Code ini saat check-in:</p>

@if(!empty($qrCid))
  <img src="{{ $qrCid }}" alt="QR Code"
       style="max-width:220px; display:block; margin:16px auto;">
@else
  <p style="color:#888">QR tidak tersedia.</p>
@endif

<p style="background:#f3f6ff;padding:12px 16px;border-radius:8px;">
  <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->date)->translatedFormat('d M Y') }}
</p>

<p>Terima kasih,<br><strong>Pengelola Wisata</strong></p>
