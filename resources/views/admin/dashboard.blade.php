@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Karibu back, Admin 🌍</h2>
            <p class="sub">Here's what's happening across Tanzania Daily Tours & Safari today.</p>
        </div>
        <div class="view-actions">
            <a href="{{ route('admin.bookings') }}" class="btn btn-soft">View bookings</a>
            <a href="{{ route('admin.destinations') }}" class="btn btn-primary">+ Add destination</a>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card" style="--stat-tint: var(--terracotta-100); --stat-fg: var(--terracotta-600);">
            <div class="stat-top">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                        <path d="M16 2v4M8 2v4M3 9h18"></path>
                    </svg>
                </div>
                <span class="stat-trend up">+12.4%</span>
            </div>
            <div class="stat-value" id="statBookings">{{ $totalBookings }}</div>
            <div class="stat-label">Total bookings</div>
        </div>
        <div class="stat-card" style="--stat-tint: var(--acacia-100); --stat-fg: var(--acacia-600);">
            <div class="stat-top">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
                <span class="stat-trend up">+8.1%</span>
            </div>
            <div class="stat-value" id="statRevenue">${{ number_format($totalRevenue, 0) }}</div>
            <div class="stat-label">Revenue (this month)</div>
        </div>
        <div class="stat-card" style="--stat-tint: var(--gold-100); --stat-fg: #8a6418;">
            <div class="stat-top">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 11 12 4l9 7"></path>
                        <path d="M5 10v10h14V10"></path>
                    </svg>
                </div>
                <span class="stat-trend up">+{{ $activeDestinations > 0 ? $activeDestinations : 0 }}</span>
            </div>
            <div class="stat-value" id="statDestinations">{{ $activeDestinations }}</div>
            <div class="stat-label">Active destinations</div>
        </div>
        <div class="stat-card" style="--stat-tint: var(--danger-100); --stat-fg: var(--danger);">
            <div class="stat-top">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"></path>
                    </svg>
                </div>
                <span class="stat-trend down">New</span>
            </div>
            <div class="stat-value" id="statMessages">{{ $unreadMessages }}</div>
            <div class="stat-label">Unread messages</div>
        </div>
    </div>

    <div class="panel-grid">
        <div class="panel">
            <div class="panel-head">
                <h3>Bookings — last 7 months</h3>
                <span class="link">+ 18% vs prior period</span>
            </div>
            <div class="panel-body">
                <div class="bars" id="bookingsChart">
                    <div class="bar-col">
                        <div class="bar" style="height: 60%;"></div>
                        <div class="bar-label">Jan</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar" style="height: 70%;"></div>
                        <div class="bar-label">Feb</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar" style="height: 50%;"></div>
                        <div class="bar-label">Mar</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar" style="height: 80%;"></div>
                        <div class="bar-label">Apr</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar" style="height: 75%;"></div>
                        <div class="bar-label">May</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar" style="height: 90%;"></div>
                        <div class="bar-label">Jun</div>
                    </div>
                    <div class="bar-col">
                        <div class="bar" style="height: 50%;"></div>
                        <div class="bar-label">Jul</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-head">
                <h3>Bookings by category</h3>
            </div>
            <div class="panel-body">
                <div class="donut-wrap">
                    <svg width="120" height="120" viewBox="0 0 120 120" id="donutChart">
                        <circle cx="60" cy="60" r="50" fill="none" stroke="#E9DCC0" stroke-width="14"/>
                    </svg>
                    <div class="legend" id="donutLegend">
                        <div class="legend-item">
                            <span class="legend-dot" style="background: #C2592B;"></span>
                            Day Trips
                            <b>{{ $dayTripCount }}</b>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background: #D4A24C;"></span>
                            Multi-Day Safaris
                            <b>{{ $multiDayCount }}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-grid">
        <div class="panel">
            <div class="panel-head">
                <h3>Recent bookings</h3>
                <a href="{{ route('admin.bookings') }}" class="link">View all →</a>
            </div>
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Tour</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="recentBookingsBody">
                        @if($recentBookings->isEmpty())
                        <tr><td colspan="4" style="text-align:center;color:var(--ink-soft);padding:30px;">Nothing here yet.</td></tr>
                        @else
                        @foreach($recentBookings as $booking)
                        <tr>
                            <td class="cell-title">{{ $booking->name ?? $booking->email }}</td>
                            <td>{{ $booking->tour_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->travel_date)->format('M d, Y') }}</td>
                            <td>{!! \App\Http\Controllers\AdminController::statusTag($booking->status) !!}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel">
            <div class="panel-head">
                <h3>Recent activity</h3>
            </div>
            <div class="panel-body">
                <div class="activity-list" id="activityList">
                    <div class="activity-row">
                        <div class="activity-ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                                <path d="M16 2v4M8 2v4M3 9h18"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="activity-text"><b>{{ $totalBookings > 0 ? 'Guest' : 'System' }}</b> booked a tour</div>
                            <div class="activity-time">2 hours ago</div>
                        </div>
                    </div>
                    @if($pendingReviews > 0)
                    <div class="activity-row">
                        <div class="activity-ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="12 2.5 15.1 9 22 10 17 15 18.2 22 12 18.6 5.8 22 7 15 2 10 8.9 9"></polygon>
                            </svg>
                        </div>
                        <div>
                            <div class="activity-text">New review submitted for a tour</div>
                            <div class="activity-time">5 hours ago</div>
                        </div>
                    </div>
                    @endif
                    @if($unreadMessages > 0)
                    <div class="activity-row">
                        <div class="activity-ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="activity-text"><b>Traveler</b> sent a message</div>
                            <div class="activity-time">Today, 9:24 AM</div>
                        </div>
                    </div>
                    @endif
                    <div class="activity-row">
                        <div class="activity-ico">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 11 12 4l9 7"></path>
                                <path d="M5 10v10h14V10"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="activity-text">Destination updated</div>
                            <div class="activity-time">Yesterday</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
