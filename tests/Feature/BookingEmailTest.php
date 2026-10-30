<?php

use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;

it('sends the customer a confirmation with the server-calculated order total', function () {
    Mail::fake();

    $response = $this->post(route('bookings.store'), [
        'name' => 'Febby Putri',
        'email' => 'febby@example.com',
        'phone' => '081234567890',
        'event' => 'pestapora',
        'ticket_type' => 'regular',
        'quantity' => 2,
        'total' => 1,
    ]);

    $response
        ->assertRedirect(route('home'))
        ->assertSessionHas('booking_confirmation.email', 'febby@example.com')
        ->assertSessionHas('booking_confirmation.totalPrice', '900.000');

    Mail::assertSent(BookingConfirmation::class, function (BookingConfirmation $mail): bool {
        $mail->assertTo('febby@example.com');
        $mail->assertHasSubject('Konfirmasi permintaan tiket konser');
        $mail->assertSeeInHtml('Pestapora 2027');
        $mail->assertSeeInHtml('Rp900.000');

        return $mail->customerName === 'Febby Putri'
            && $mail->quantity === 2
            && $mail->totalPrice === 900000;
    });
});

it('rejects invalid concert selections without sending an email', function () {
    Mail::fake();

    $response = $this->from(route('home'))->post(route('bookings.store'), [
        'name' => 'Febby Putri',
        'email' => 'febby@example.com',
        'phone' => '081234567890',
        'event' => 'unlisted-event',
        'ticket_type' => 'regular',
        'quantity' => 2,
    ]);

    $response
        ->assertRedirect(route('home'))
        ->assertSessionHasErrors('event');

    Mail::assertNothingSent();
});
