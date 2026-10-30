<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#f6f7f3">
        <meta name="description" content="Pesan tiket konser dengan mudah di konser.in.">
        <title>Pesan Tiket Konser — konser.in</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <header class="site-header">
            <a class="brand" href="/" aria-label="konser.in">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
                </span>
                <span>konser<span class="brand-muted">.in</span></span>
            </a>
            <span class="secure-label">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2"></rect><path d="M8 10V7a4 4 0 1 1 8 0v3"></path></svg>
                Pemesanan tiket
            </span>
        </header>

        <main class="page-shell">
            <section class="intro">
                <p class="eyebrow"><span class="eyebrow-dot"></span> SATU HALAMAN, TINGGAL ISI</p>
                <h1>Siap untuk<br>malam <span>yang seru?</span></h1>
                <p class="intro-copy">Isi data diri, pilih konser dan tiketmu. Ringkasan permintaan akan dikirim ke emailmu.</p>
            </section>

            @if ($errors->any())
                <div class="form-errors" role="alert">
                    <strong>Periksa kembali data pemesananmu:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="booking-layout" id="booking-form" method="POST" action="{{ route('bookings.store') }}">
                @csrf
                <div class="form-column">
                    <section class="form-card" aria-labelledby="contact-heading">
                        <div class="card-heading">
                            <span class="step-number">01</span>
                            <div>
                                <h2 id="contact-heading">Data pemesan</h2>
                                <p>Gunakan data yang bisa dihubungi.</p>
                            </div>
                        </div>

                        <div class="fields-grid">
                            <label class="field field-full">
                                <span>Nama lengkap</span>
                                <input name="name" type="text" autocomplete="name" placeholder="Contoh: Febby Putri" value="{{ old('name') }}" required maxlength="100">
                            </label>
                            <label class="field">
                                <span>Email</span>
                                <input name="email" type="email" autocomplete="email" placeholder="nama@email.com" value="{{ old('email') }}" required maxlength="254">
                            </label>
                            <label class="field">
                                <span>Nomor telepon</span>
                                <input name="phone" type="tel" autocomplete="tel" inputmode="tel" placeholder="081234567890" value="{{ old('phone') }}" pattern="\+?[0-9]{8,15}" title="Masukkan 8–15 angka, dengan tanda + di depan jika perlu." required maxlength="16">
                            </label>
                        </div>
                    </section>

                    <section class="form-card" aria-labelledby="ticket-heading">
                        <div class="card-heading">
                            <span class="step-number">02</span>
                            <div>
                                <h2 id="ticket-heading">Pilih tiket konser</h2>
                                <p>Pilih acara dan kategori tiket yang kamu mau.</p>
                            </div>
                        </div>

                        <label class="field">
                            <span>Nama konser</span>
                            <select name="event" id="event-select" required>
                                <option value="" selected disabled>Pilih konser</option>
                                @foreach (config('concerts') as $slug => $concert)
                                    <option value="{{ $slug }}" data-title="{{ $concert['title'] }}" data-date="{{ $concert['date'] }}" data-venue="{{ $concert['venue'] }}" data-regular="{{ $concert['prices']['regular'] }}" data-vip="{{ $concert['prices']['vip'] }}" @selected(old('event') === $slug)>{{ $concert['label'] }}</option>
                                @endforeach
                            </select>
                        </label>

                        <fieldset class="ticket-options">
                            <legend class="field-legend">Kategori tiket</legend>
                            <label class="ticket-option">
                                <input type="radio" name="ticket_type" value="regular" @checked(old('ticket_type', 'regular') === 'regular')>
                                <span class="radio-indicator" aria-hidden="true"></span>
                                <span class="ticket-option-copy">
                                    <strong>Reguler</strong>
                                    <span>Akses masuk konser</span>
                                </span>
                                <span class="ticket-option-price" id="regular-price">Pilih konser</span>
                            </label>
                            <label class="ticket-option">
                                <input type="radio" name="ticket_type" value="vip" @checked(old('ticket_type') === 'vip')>
                                <span class="radio-indicator" aria-hidden="true"></span>
                                <span class="ticket-option-copy">
                                    <strong>VIP</strong>
                                    <span>Akses prioritas</span>
                                </span>
                                <span class="ticket-option-price" id="vip-price">Pilih konser</span>
                            </label>
                        </fieldset>

                        <div class="quantity-row">
                            <div>
                                <span class="field-title">Jumlah tiket</span>
                                <span class="field-hint">Maksimal 5 tiket per pesanan</span>
                            </div>
                            <div class="quantity-control">
                                <button class="quantity-button" id="decrease-quantity" type="button" aria-label="Kurangi jumlah tiket">−</button>
                                <output id="quantity" for="ticket-quantity" aria-live="polite">1</output>
                                <button class="quantity-button" id="increase-quantity" type="button" aria-label="Tambah jumlah tiket">+</button>
                                <input class="visually-hidden" id="ticket-quantity" name="quantity" type="number" value="{{ old('quantity', 1) }}" min="1" max="5" required tabindex="-1" aria-hidden="true">
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="summary-card" aria-labelledby="summary-heading">
                    <div class="summary-top">
                        <p class="summary-eyebrow">RINGKASAN</p>
                        <h2 id="summary-heading">Pesananmu</h2>
                        <p class="summary-note">Periksa pilihan tiket sebelum melanjutkan.</p>
                    </div>

                    <div class="summary-event" id="summary-event">
                        <span class="summary-music-mark" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
                        </span>
                        <div>
                            <strong id="summary-event-name">Konser pilihanmu</strong>
                            <span id="summary-event-date">Pilih konser untuk melihat detail</span>
                        </div>
                    </div>

                    <div class="summary-lines">
                        <div><span>Tiket</span><strong id="summary-ticket">Reguler</strong></div>
                        <div><span>Harga per tiket</span><strong id="summary-price">—</strong></div>
                        <div><span>Jumlah</span><strong><span id="summary-quantity">1</span> tiket</strong></div>
                    </div>

                    <div class="summary-total">
                        <span>Total pembayaran</span>
                        <strong id="summary-total">—</strong>
                    </div>

                    <button class="submit-button" type="submit">
                        Kirim permintaan & konfirmasi email
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"></path></svg>
                    </button>
                    <p class="demo-note">Ringkasan permintaan dikirim ke emailmu. Ini demo: tidak ada pembayaran dan tiket belum diterbitkan.</p>
                </aside>
            </form>

            @if ($booking = session('booking_confirmation'))
                <section class="confirmation-card" id="confirmation" role="status" aria-live="polite">
                <span class="confirmation-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 4 4L19 6"></path></svg>
                </span>
                <div>
                    <h2>Permintaan pesanan terkirim</h2>
                    <p>{{ $booking['customerName'] }}, ringkasan {{ $booking['quantity'] }} tiket {{ $booking['ticketType'] }} untuk {{ $booking['eventTitle'] }} (Rp{{ $booking['totalPrice'] }}) telah dikirim ke {{ $booking['email'] }}.</p>
                    <p class="confirmation-disclaimer">Ini masih demo — email ini bukan tiket, tiket belum diterbitkan, dan tidak ada pembayaran.</p>
                </div>
                </section>
            @endif
        </main>

        <footer class="site-footer">
            <a class="brand footer-brand" href="/" aria-label="konser.in">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"></path><circle cx="6" cy="18" r="3"></circle><circle cx="18" cy="16" r="3"></circle></svg>
                </span>
                <span>konser<span class="brand-muted">.in</span></span>
            </a>
            <span class="footer-copy">Musik bagus, kenangan seru. © 2026 konser.in</span>
        </footer>
    </body>
</html>
