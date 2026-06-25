@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <section class="relative h-[50vh] min-h-[320px] flex items-end pb-16">
        <div class="absolute inset-0">
            <img src="{{ asset('images/safari-serengeti.jpg') }}" alt="Safari" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(26,18,8,0.4), rgba(99,30,8,0.8));"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">Destinations</span>
            </nav>
            <h1 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
                Our Destinations
            </h1>
        </div>
    </section>

    <!-- Destinations Grid -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="all" style="background: #088529; color: #ffffff;">
                    All
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="day" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Day Trips
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="multi" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Multi-Day
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="cultural" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Cultural
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="adventure" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Adventure
                </button>
                <button class="filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="wildlife" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Wildlife
                </button>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="destinations-grid">
                @foreach($tours as $tour)
                    <a href="{{ route('destination.detail', $tour['slug']) }}" class="destination-card group block rounded-xl overflow-hidden transition-all duration-350 hover:-translate-y-1" data-category="{{ $tour['category'] }}" style="background: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                        <div class="overflow-hidden" style="aspect-ratio: 3/2;">
                            <img src="{{ asset($tour['image']) }}" alt="{{ $tour['name'] }}" class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105" loading="lazy">
                        </div>
                        <div class="p-5">
                            <span class="inline-block px-3 py-0.5 rounded-full text-xs font-semibold text-white mb-3" style="background: {{ $tour['category'] === 'day' ? '#ff9729' : ($tour['category'] === 'multi' ? '#088529' : '#854208') }};">
                                {{ $tour['category'] === 'day' ? 'Day Trip' : ($tour['category'] === 'multi' ? 'Multi-Day' : ucfirst($tour['category'])) }}
                            </span>
                            <h3 class="font-bold text-xl mb-2" style="font-family: 'Playfair Display', serif; color: #854208;">{{ $tour['name'] }}</h3>
                            <p class="text-sm mb-4 line-clamp-2" style="color: #111111;">{{ $tour['description'] }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5 text-xs" style="color: #5a3e2b;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ $tour['duration'] }}
                                </div>
                                <span class="text-sm font-bold" style="color: #088529;">From ${{ $tour['price'] }}</span>
                                <span class="inline-flex items-center gap-1 text-sm font-semibold transition-colors duration-300" style="color: #ff9729;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-14" style="background: #ff9729;">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-lg font-bold mb-5" style="color: #ffffff;">
                Can't find what you're looking for? We create custom itineraries!
            </p>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-10 py-4 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg" style="background: #ffffff; color: #854208;">
                Plan a Custom Trip
            </a>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.destination-card');

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
                    if (filter === 'all' || card.dataset.category === filter) {
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
