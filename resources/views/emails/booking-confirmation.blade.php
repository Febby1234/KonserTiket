<!DOCTYPE html>
<html lang="id">
    <body style="margin: 0; padding: 32px 16px; background: #f6f7f3; color: #202820; font-family: Arial, sans-serif;">
        <main style="max-width: 560px; margin: 0 auto; padding: 28px; border: 1px solid #e7eae3; border-radius: 12px; background: #ffffff;">
            <p style="margin: 0 0 8px; color: #718067; font-size: 12px; font-weight: bold; letter-spacing: 1px;">KONSER.IN</p>
            <h1 style="margin: 0 0 16px; font-size: 22px;">Permintaan tiketmu sudah kami terima</h1>
            <p style="line-height: 1.6;">Halo {{ $customerName }}, berikut ringkasan permintaan pemesananmu:</p>

            <table style="width: 100%; margin: 24px 0; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; color: #718067;">Konser</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $eventTitle }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #718067;">Tanggal</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $eventDate }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #718067;">Lokasi</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $venue }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #718067;">Tiket</td>
                    <td style="padding: 8px 0; text-align: right;">{{ $ticketType }} ({{ $quantity }} tiket)</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; color: #718067;">Harga per tiket</td>
                    <td style="padding: 8px 0; text-align: right;">Rp{{ number_format($unitPrice, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="padding: 12px 0; border-top: 1px solid #e7eae3; font-weight: bold;">Total</td>
                    <td style="padding: 12px 0; border-top: 1px solid #e7eae3; text-align: right; font-weight: bold;">Rp{{ number_format($totalPrice, 0, ',', '.') }}</td>
                </tr>
            </table>

            <p style="margin: 0; color: #718067; font-size: 13px; line-height: 1.6;">
                Ini adalah konfirmasi permintaan pada versi demo. Email ini bukan tiket, belum ada pembayaran, dan tiket belum diterbitkan.
            </p>
        </main>
    </body>
</html>
