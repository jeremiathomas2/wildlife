@php
    $tdtsTours = \App\Support\SafariContent::buildTours($tours ?? \App\Models\Destination::where('status', 'Published')->get());
    $tdtsGallery = \App\Support\SafariContent::buildGallery($gallery ?? \App\Models\Gallery::all());
    $tdtsReviews = \App\Support\SafariContent::buildReviews($reviews ?? $testimonials ?? \App\Models\Review::where('status', 'Published')->get());
@endphp
<script>
window.TDTS = window.TDTS || {};
window.TDTS.SITE = window.TDTS.SITE || {};
window.TDTS.SITE.base = @json(url('/'));
window.TDTS.HERO = {!! json_encode(\App\Support\SafariContent::hero(), JSON_UNESCAPED_UNICODE) !!};
window.TDTS.DEPOSIT_PERCENT = {{ (int) \App\Services\PaymentSettings::depositPercentage() }};
window.TDTS.TOURS = {!! json_encode($tdtsTours, JSON_UNESCAPED_UNICODE) !!};
window.TDTS.GALLERY = {!! json_encode($tdtsGallery, JSON_UNESCAPED_UNICODE) !!};
window.TDTS.REVIEWS = {!! json_encode($tdtsReviews, JSON_UNESCAPED_UNICODE) !!};
window.TDTS.API = {!! json_encode([
    'bookings' => url('bookings'),
    'contact' => url('contact'),
    'currencyRates' => url('api/currency-rates'),
], JSON_UNESCAPED_UNICODE) !!};
</script>