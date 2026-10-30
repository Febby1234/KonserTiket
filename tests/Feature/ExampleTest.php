<?php

it('returns a successful response', function () {
    $response = $this->get('/');

    $response
        ->assertStatus(200)
        ->assertSee('Pesan Tiket Konser — konser.in')
        ->assertSee('name="name"', false)
        ->assertSee('name="email"', false)
        ->assertSee('name="phone"', false)
        ->assertSee('name="event"', false)
        ->assertSee('name="ticket_type"', false)
        ->assertSee('id="summary-total"', false);
});
