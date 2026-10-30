<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:254'],
            'phone' => ['required', 'regex:/^\+?[0-9]{8,15}$/', 'max:16'],
            'event' => ['required', Rule::in(array_keys(config('concerts')))],
            'ticket_type' => ['required', Rule::in(['regular', 'vip'])],
            'quantity' => ['required', 'integer', 'between:1,5'],
        ]);

        $concert = config('concerts.'.$validated['event']);
        $ticketType = $validated['ticket_type'];
        $unitPrice = $concert['prices'][$ticketType];
        $totalPrice = $unitPrice * $validated['quantity'];
        $ticketLabel = $ticketType === 'vip' ? 'VIP' : 'Reguler';

        Mail::to($validated['email'])->send(new BookingConfirmation(
            customerName: $validated['name'],
            eventTitle: $concert['title'],
            eventDate: $concert['date'],
            venue: $concert['venue'],
            ticketType: $ticketLabel,
            quantity: $validated['quantity'],
            unitPrice: $unitPrice,
            totalPrice: $totalPrice,
        ));

        return to_route('home')->with('booking_confirmation', [
            'customerName' => $validated['name'],
            'email' => $validated['email'],
            'eventTitle' => $concert['title'],
            'quantity' => $validated['quantity'],
            'ticketType' => $ticketLabel,
            'totalPrice' => number_format($totalPrice, 0, ',', '.'),
        ]);
    }
}
