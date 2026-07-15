@extends('layouts.app')

@section('title', 'Tanzania Safari Reviews - What Our Travelers Say')
@section('meta_title', 'Tanzania Safari Reviews - What Our Travelers Say')
@section('meta_description', 'Read genuine Tanzania safari reviews from our happy travelers. 4.8/5 rating from 10,000+ customers. See why we\'re the top-rated Tanzania tour operator.')
@section('meta_keywords', 'Tanzania safari reviews, Tanzania tour operator reviews, Serengeti safari reviews, Kilimanjaro climb reviews, Zanzibar tour reviews, customer testimonials Tanzania')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890322/safari-ngorongoro_j04gqg.jpg')

@section('structured_data')
@php
    $structuredData = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ReviewPage",
    "name": "Tanzania Safari Reviews",
    "description": "Read genuine Tanzania safari reviews from our happy travelers",
    "url": "https://www.tanzaniadailytoursandsafari.com/reviews",
    "mainEntity": {
        "@type": "TravelAgency",
        "name": "Tanzania Daily Tours & Safari",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "500",
            "bestRating": "5",
            "worstRating": "1"
        }
    }
}
</script>';
@endphp
{!! $structuredData !!}

@section('content')
    <!-- Page Header -->
    <section class="relative h-[40vh] min-h-[280px] flex items-end pb-16">
        <div class="absolute inset-0">
            <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890322/reviews-header_wnccc3.jpg" alt="Reviews" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(26,18,8,0.4), rgba(99,30,8,0.8));"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">Reviews</span>
            </nav>
            <h1 class="font-bold mb-2" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
                {{ $contents['reviews_page_title']->value ?? 'Traveler Reviews' }}
            </h1>
            <div class="flex items-center gap-2">
                <div class="flex">
                    @for($i = 0; $i < 5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#ff9729" stroke="#ff9729">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    @endfor
                </div>
                <span class="text-sm font-bold" style="color: #ffffff;">5.0</span>
                <span class="text-sm" style="color: rgba(255,255,255,0.7);">({{ count($testimonials) }} reviews)</span>
            </div>
        </div>
    </section>

    <!-- Reviews Content -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Filters -->
            <div class="flex flex-wrap items-center gap-3 mb-10">
                <button class="review-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="all" style="background: #088529; color: #ffffff;">
                    All
                </button>
                <button class="review-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="serengeti" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Serengeti
                </button>
                <button class="review-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="kilimanjaro" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Kilimanjaro
                </button>
                <button class="review-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="day" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Day Trips
                </button>
                <button class="review-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="multi" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Multi-Day
                </button>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="reviews-grid">
                @foreach($testimonials as $testimonial)
                    <div class="review-card bg-white rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1" data-trip="{{ strtolower(str_replace(' ', '', $testimonial['trip'])) }}" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                        <div class="flex items-center gap-1 mb-3">
                            @for($i = 0; $i < $testimonial['rating']; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#ff9729" stroke="#ff9729">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            @endfor
                        </div>
                        <p class="text-sm italic mb-4 leading-relaxed" style="font-family: 'Raleway', sans-serif; color: #111111;">
                            "{{ $testimonial['text'] }}"
                        </p>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-bold" style="color: #854208;">{{ $testimonial['name'] }}</p>
                                <p class="text-xs" style="color: #5a3e2b;">{{ $testimonial['trip'] }}</p>
                            </div>
                            @if($testimonial['verified'])
                                <span class="flex items-center gap-1 text-xs font-semibold" style="color: #088529;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                    Verified
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Review CTA -->
            <div class="mt-12 text-center">
                <div class="bg-white rounded-2xl p-8 inline-block max-w-md" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                    <p class="text-base mb-4" style="color: #111111;">
                        {{ $contents['reviews_cta_text']->value ?? 'Traveled with us? Share your experience!' }}
                    </p>
                    <button onclick="alert('Review submission coming soon! Thank you for your feedback.')" class="px-8 py-3 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90" style="background: #088529;">
                        {{ $contents['reviews_cta_button']->value ?? 'Write a Review' }}
                    </button>
                </div>
            </div>

            <!-- TripAdvisor Review Section -->
            <div class="mt-16">
                <div class="bg-white rounded-2xl p-8 text-center" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                    <div class="flex items-center justify-center gap-3 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="#00af87">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z" fill="white"/>
                        </svg>
                        <h3 class="text-2xl font-bold" style="font-family: 'Raleway', sans-serif; color: #00af87;">TripAdvisor Reviews</h3>
                    </div>
                    <p class="text-base mb-6" style="color: #5a3e2b;">
                        Share your experience on TripAdvisor and help other travelers discover Tanzania with us!
                    </p>
                    <a href="https://www.tripadvisor.com/UserReviewEdit-g317084-d34526433-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-8 py-3 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90" style="background: #00af87;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        Review on TripAdvisor
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const filterBtns = document.querySelectorAll('.review-filter-btn');
        const cards = document.querySelectorAll('.review-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;

                // Update active button styles
                filterBtns.forEach(b => {
                    b.style.background = 'transparent';
                    b.style.color = '#854208';
                    b.style.border = '1px solid #854208';
                });
                btn.style.background = '#088529';
                btn.style.color = '#ffffff';
                btn.style.border = '1px solid #088529';

                // Filter cards
                cards.forEach(card => {
                    const trip = card.dataset.trip;
                    if (filter === 'all' || 
                        (filter === 'day' && (trip.includes('hot') || trip.includes('boma') || trip.includes('waterfall'))) ||
                        (filter === 'multi' && (trip.includes('safari') || trip.includes('crater'))) ||
                        trip.includes(filter)) {
                        card.style.display = 'block';
                        setTimeout(() => card.style.opacity = '1', 10);
                    } else {
                        card.style.opacity = '0';
                        setTimeout(() => card.style.display = 'none', 300);
                    }
                });
            });
        });
    </script>
@endsection
