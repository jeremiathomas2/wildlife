@extends('admin.layout')

@section('title', 'Bookings')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Bookings</h2>
            <p class="sub">Track and manage every safari and tour booking request.</p>
        </div>
        <div class="view-actions">
            <button class="btn btn-primary" onclick="openBookingModal()">+ New booking</button>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="chip-filters" id="bookingFilterChips">
                <button class="chip active" data-filter="all" onclick="setBookingFilter('all')">All</button>
                <button class="chip" data-filter="Pending" onclick="setBookingFilter('Pending')">Pending</button>
                <button class="chip" data-filter="Confirmed" onclick="setBookingFilter('Confirmed')">Confirmed</button>
                <button class="chip" data-filter="Completed" onclick="setBookingFilter('Completed')">Completed</button>
                <button class="chip" data-filter="Cancelled" onclick="setBookingFilter('Cancelled')">Cancelled</button>
            </div>
            <div class="table-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Search guest or tour…" oninput="filterBookings(this.value)">
            </div>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Guest</th>
                        <th>Tour</th>
                        <th>Travel Date</th>
                        <th>Adults</th>
                        <th>Children</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="bookingsBody">
                    @if($bookings->isEmpty())
                    <tr><td colspan="9" style="text-align:center;color:var(--ink-soft);padding:30px;">No bookings yet.</td></tr>
                    @else
                    @foreach($bookings as $booking)
                    <tr data-id="{{ $booking->id }}" data-status="{{ $booking->status }}" data-search="{{ strtolower(($booking->name ?? '') . ' ' . $booking->email . ' ' . $booking->tour_name) }}">
                        <td>
                            <div class="cell-main">
                                <div>
                                    <div class="cell-title">{{ $booking->name ?? $booking->email }}</div>
                                    <div class="cell-sub">{{ $booking->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $booking->tour_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->travel_date)->format('M d, Y') }}</td>
                        <td>{{ $booking->adults ?? ($booking->guests ?? 0) }}</td>
                        <td>{{ $booking->children ?? 0 }}</td>
                        <td>{{ $booking->currency ?? '$' }}{{ number_format($booking->amount ?? $booking->total_price, 0) }}</td>
                        <td>{!! \App\Http\Controllers\AdminController::statusTag($booking->status) !!}</td>
                        <td>
                            <div class="row-actions">
                                <button onclick="viewBooking({{ $booking->id }})" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                                <button onclick="editBooking({{ $booking->id }})" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                    </svg>
                                </button>
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Delete this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="danger" type="submit" title="Delete">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if($bookings->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>

<div class="modal-backdrop" id="bookingModalBackdrop">
    <div class="modal">
        <div class="modal-head">
            <h3 id="bookingModalTitle">New booking</h3>
            <button class="modal-close" onclick="closeModal('bookingModalBackdrop')">✕</button>
        </div>
        <form id="bookingForm" action="{{ route('admin.bookings.store') }}" method="POST">
            @csrf
            <input type="hidden" id="bookingId" name="id">
            <input type="hidden" id="bookingMethod" name="_method" value="">
            <div class="modal-body">
                <div class="form-row">
                    <div class="field">
                        <label>Guest name</label>
                        <input type="text" id="bookingName" name="name" placeholder="e.g. Sarah Mitchell" required>
                    </div>
                    <div class="field">
                        <label>Guest email</label>
                        <input type="email" id="bookingEmail" name="email" placeholder="sarah@email.com" required>
                    </div>
                </div>
                <div class="field">
                    <label>Tour / destination</label>
                    <select id="bookingTour" name="tour_name">
                        @foreach($destinations as $dest)
                        <option value="{{ $dest->name }}">{{ $dest->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Travel date</label>
                        <input type="date" id="bookingDate" name="travel_date">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Number of adults</label>
                        <input type="number" id="bookingAdults" name="adults" value="1" min="1">
                    </div>
                    <div class="field">
                        <label>Number of children</label>
                        <input type="number" id="bookingChildren" name="children" value="0" min="0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="field">
                        <label>Total amount (USD)</label>
                        <input type="number" id="bookingAmount" name="amount" placeholder="80">
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select id="bookingStatus" name="status">
                            <option>Pending</option>
                            <option>Confirmed</option>
                            <option>Completed</option>
                            <option>Cancelled</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('bookingModalBackdrop')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save booking</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-backdrop" id="viewBookingModalBackdrop">
    <div class="modal">
        <div class="modal-head">
            <h3>View Booking</h3>
            <button class="modal-close" onclick="closeModal('viewBookingModalBackdrop')">✕</button>
        </div>
        <div class="modal-body" id="viewBookingContent">
        </div>
        <div class="modal-foot">
            <button type="button" class="btn btn-ghost" onclick="closeModal('viewBookingModalBackdrop')">Close</button>
        </div>
    </div>
</div>

<script>
const bookingsData = @json($bookings->items());
let currentBookingFilter = 'all';
let currentBookingSearch = '';

function setBookingFilter(filter) {
    currentBookingFilter = filter;
    document.querySelectorAll('#bookingFilterChips .chip').forEach(c => c.classList.toggle('active', c.dataset.filter === filter));
    renderFilteredBookings();
}

function filterBookings(search) {
    currentBookingSearch = search.toLowerCase();
    renderFilteredBookings();
}

function renderFilteredBookings() {
    document.querySelectorAll('#bookingsBody tr').forEach(tr => {
        if (!tr.dataset.id) return;
        let match = true;
        if (currentBookingFilter !== 'all') {
            match = tr.dataset.status === currentBookingFilter;
        }
        if (currentBookingSearch) {
            match = match && tr.dataset.search.includes(currentBookingSearch);
        }
        tr.style.display = match ? 'table-row' : 'none';
    });
}

function openBookingModal(id = null) {
    const title = document.getElementById('bookingModalTitle');
    title.textContent = id ? 'Edit booking' : 'New booking';
    const form = document.getElementById('bookingForm');
    if (id) {
        const booking = bookingsData.find(b => b.id === id);
        if (!booking) return;
        form.action = "/live/bookings/" + id;
        document.getElementById('bookingMethod').value = 'PUT';
        document.getElementById('bookingId').value = booking.id;
        document.getElementById('bookingName').value = booking.name ?? booking.email;
        document.getElementById('bookingEmail').value = booking.email;
        document.getElementById('bookingTour').value = booking.tour_name;
        document.getElementById('bookingDate').value = booking.travel_date;
        document.getElementById('bookingAdults').value = booking.adults ?? (booking.guests ?? 0);
        document.getElementById('bookingChildren').value = booking.children ?? 0;
        document.getElementById('bookingAmount').value = booking.amount ?? booking.total_price;
        document.getElementById('bookingStatus').value = booking.status;
    } else {
        form.action = "{{ route('admin.bookings.store') }}";
        document.getElementById('bookingMethod').value = '';
        document.getElementById('bookingId').value = '';
        document.getElementById('bookingName').value = '';
        document.getElementById('bookingEmail').value = '';
        document.getElementById('bookingTour').selectedIndex = 0;
        document.getElementById('bookingDate').value = '';
        document.getElementById('bookingAdults').value = 1;
        document.getElementById('bookingChildren').value = 0;
        document.getElementById('bookingAmount').value = '';
        document.getElementById('bookingStatus').value = 'Pending';
    }
    openModal('bookingModalBackdrop');
}

function editBooking(id) {
    openBookingModal(id);
}

function viewBooking(id) {
    const booking = bookingsData.find(b => b.id === id);
    if (!booking) return;

    const statusColors = {
        'Pending': '#ff9729',
        'Confirmed': '#088529',
        'Completed': '#854208',
        'Cancelled': '#dc2626'
    };
    const statusColor = statusColors[booking.status] || '#854208';

    const content = `
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Header Section -->
            <div style="
                display: flex; 
                align-items: center; 
                justify-content: space-between; 
                padding: 16px; 
                background: linear-gradient(135deg, #ff9729 0%, #088529 100%); 
                border-radius: 12px; 
                color: white;">
                <div>
                    <div style="font-size: 20px; font-weight: 700; font-family: 'Playfair Display', serif;">Booking #${booking.id}</div>
                    <div style="font-size: 13px; opacity: 0.9;">Created: ${new Date(booking.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</div>
                </div>
                <span style="
                    display: inline-flex; 
                    align-items: center; 
                    padding: 6px 14px; 
                    background: rgba(255,255,255,0.2); 
                    border-radius: 9999px; 
                    font-size: 12px; 
                    font-weight: 600;">
                    ${booking.status}
                </span>
            </div>
            
            <!-- Guest Info -->
            <div style="
                padding: 20px; 
                background: #f8f4f0; 
                border-radius: 12px; 
                border: 1px solid rgba(133, 66, 8, 0.1);">
                <div style="
                    font-size: 13px; 
                    font-weight: 700; 
                    color: #854208; 
                    text-transform: uppercase; 
                    letter-spacing: 0.05em; 
                    margin-bottom: 16px;">
                    Guest Information
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <div style="
                            font-size: 12px; 
                            color: #854208; 
                            opacity: 0.7; 
                            margin-bottom: 4px;">
                            Guest Name
                        </div>
                        <div style="
                            font-size: 15px; 
                            color: #111111; 
                            font-weight: 600;">
                            ${booking.name ?? booking.email}
                        </div>
                    </div>
                    <div>
                        <div style="
                            font-size: 12px; 
                            color: #854208; 
                            opacity: 0.7; 
                            margin-bottom: 4px;">
                            Email
                        </div>
                        <div style="
                            font-size: 15px; 
                            color: #111111; 
                            font-weight: 600;">
                            ${booking.email}
                        </div>
                    </div>
                    ${booking.phone ? `
                        <div>
                            <div style="
                                font-size: 12px; 
                                color: #854208; 
                                opacity: 0.7; 
                                margin-bottom: 4px;">
                                Phone
                            </div>
                            <div style="
                                font-size: 15px; 
                                color: #111111; 
                                font-weight: 600;">
                                ${booking.country_code ?? ''} ${booking.phone}
                            </div>
                        </div>
                    ` : ''}
                </div>
            </div>
            
            <!-- Tour Info -->
            <div style="
                padding: 20px; 
                background: #f8f4f0; 
                border-radius: 12px; 
                border: 1px solid rgba(133, 66, 8, 0.1);">
                <div style="
                    font-size: 13px; 
                    font-weight: 700; 
                    color: #854208; 
                    text-transform: uppercase; 
                    letter-spacing: 0.05em; 
                    margin-bottom: 16px;">
                    Tour Details
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <div style="
                            font-size: 12px; 
                            color: #854208; 
                            opacity: 0.7; 
                            margin-bottom: 4px;">
                            Tour
                        </div>
                        <div style="
                            font-size: 15px; 
                            color: #111111; 
                            font-weight: 600;">
                            ${booking.tour_name}
                        </div>
                    </div>
                    <div>
                        <div style="
                            font-size: 12px; 
                            color: #854208; 
                            opacity: 0.7; 
                            margin-bottom: 4px;">
                            Travel Date
                        </div>
                        <div style="
                            font-size: 15px; 
                            color: #111111; 
                            font-weight: 600;">
                            ${booking.travel_date ? new Date(booking.travel_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'Not set'}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pricing & Guests -->
            <div style="
                padding: 20px; 
                background: #f8f4f0; 
                border-radius: 12px; 
                border: 1px solid rgba(133, 66, 8, 0.1);">
                <div style="
                    font-size: 13px; 
                    font-weight: 700; 
                    color: #854208; 
                    text-transform: uppercase; 
                    letter-spacing: 0.05em; 
                    margin-bottom: 16px;">
                    Pricing & Guests
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div style="
                        padding: 12px; 
                        background: white; 
                        border-radius: 8px; 
                        border: 1px solid rgba(133, 66, 8, 0.1);">
                        <div style="
                            font-size: 12px; 
                            color: #854208; 
                            opacity: 0.7; 
                            margin-bottom: 4px;">
                            Adults
                        </div>
                        <div style="
                            font-size: 24px; 
                            color: #088529; 
                            font-weight: 700;">
                            ${booking.adults ?? (booking.guests ?? 0)}
                        </div>
                    </div>
                    <div style="
                        padding: 12px; 
                        background: white; 
                        border-radius: 8px; 
                        border: 1px solid rgba(133, 66, 8, 0.1);">
                        <div style="
                            font-size: 12px; 
                            color: #854208; 
                            opacity: 0.7; 
                            margin-bottom: 4px;">
                            Children
                        </div>
                        <div style="
                            font-size: 24px; 
                            color: #088529; 
                            font-weight: 700;">
                            ${booking.children ?? 0}
                        </div>
                    </div>
                </div>
                <div style="
                    display: flex; 
                    align-items: center; 
                    justify-content: space-between; 
                    padding: 16px; 
                    background: white; 
                    border-radius: 8px; 
                    border: 1px solid rgba(133, 66, 8, 0.1);">
                    <div style="
                        font-size: 14px; 
                        color: #854208; 
                        font-weight: 600;">
                        Total Amount
                    </div>
                    <div style="
                        font-size: 28px; 
                        color: #088529; 
                        font-weight: 700; 
                        font-family: 'Playfair Display', serif;">
                        ${booking.currency ?? '$'}${(booking.amount ?? booking.total_price).toLocaleString()}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('viewBookingContent').innerHTML = content;
    openModal('viewBookingModalBackdrop');
}
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection
