const bookingForm = document.querySelector('#booking-form');
const eventSelect = document.querySelector('#event-select');
const ticketQuantity = document.querySelector('#ticket-quantity');

const formatPrice = (amount) => new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    maximumFractionDigits: 0,
}).format(amount);

function getSelectedEvent() {
    return eventSelect.selectedOptions[0];
}

function getTicketPrice() {
    const selectedEvent = getSelectedEvent();
    const ticketType = bookingForm.elements.ticket_type.value;
    const priceAttribute = ticketType === 'vip' ? 'vip' : 'regular';

    return Number(selectedEvent.dataset[priceAttribute] || 0);
}

function updateOrderSummary() {
    const selectedEvent = getSelectedEvent();
    const hasEvent = Boolean(selectedEvent.value);
    const ticketPrice = hasEvent ? getTicketPrice() : 0;
    const quantity = Math.min(5, Math.max(1, Number(ticketQuantity.value) || 1));
    const ticketType = bookingForm.elements.ticket_type.value;
    const regularPrice = Number(selectedEvent.dataset.regular || 0);
    const vipPrice = Number(selectedEvent.dataset.vip || 0);

    document.querySelector('#regular-price').textContent = regularPrice > 0
        ? formatPrice(regularPrice)
        : 'Pilih konser';
    document.querySelector('#vip-price').textContent = vipPrice > 0
        ? formatPrice(vipPrice)
        : 'Pilih konser';
    document.querySelector('#summary-event-name').textContent = hasEvent
        ? selectedEvent.dataset.title
        : 'Konser pilihanmu';
    document.querySelector('#summary-event-date').textContent = hasEvent
        ? `${selectedEvent.dataset.date} · ${selectedEvent.dataset.venue}`
        : 'Pilih konser untuk melihat detail';
    document.querySelector('#summary-ticket').textContent = ticketType === 'vip' ? 'VIP' : 'Reguler';
    document.querySelector('#summary-price').textContent = hasEvent ? formatPrice(ticketPrice) : '—';
    document.querySelector('#summary-quantity').textContent = String(quantity);
    document.querySelector('#summary-total').textContent = hasEvent
        ? formatPrice(ticketPrice * quantity)
        : '—';
    document.querySelector('#quantity').textContent = String(quantity);
    ticketQuantity.value = String(quantity);
}

eventSelect.addEventListener('change', () => {
    updateOrderSummary();
});

bookingForm.querySelectorAll('input[name="ticket_type"]').forEach((input) => {
    input.addEventListener('change', () => {
        updateOrderSummary();
    });
});

document.querySelector('#decrease-quantity').addEventListener('click', () => {
    ticketQuantity.value = String(Math.max(1, Number(ticketQuantity.value) - 1));
    updateOrderSummary();
});

document.querySelector('#increase-quantity').addEventListener('click', () => {
    ticketQuantity.value = String(Math.min(5, Number(ticketQuantity.value) + 1));
    updateOrderSummary();
});

updateOrderSummary();
