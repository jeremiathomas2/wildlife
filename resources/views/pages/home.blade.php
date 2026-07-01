@extends('layouts.app')

@section('content')
    <style>
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    </style>

    @php
        $testimonials = App\Helpers\TourData::testimonials();
        $featuredTestimonials = array_slice($testimonials, 0, 3);
        $previewImages = $gallery->map(function($item) {
            return ['src' => $item->url, 'title' => $item->caption];
        })->take(10);
    @endphp
    <!-- Hero Section -->
    <section id="hero-section" class="relative overflow-hidden" style="height: 100vh; min-height: 600px;">
        <!-- Carousel Images -->
        @php
            $heroImages = [
                asset('images/safari-serengeti.jpg'),
                asset('images/safari-kilimanjaro.jpg'),
                asset('images/safari-ngorongoro.jpg'),
                asset('images/gallery-landscape-1.jpg'),
                asset('images/gallery-wildlife-1.jpg'),
                asset('images/tour-zanzibar.jpg'),
            ];
        @endphp
        @foreach($heroImages as $index => $src)
            <div 
                id="hero-slide-{{ $index }}"
                class="absolute inset-0 transition-opacity duration-1000"
                style="
                    background-image: url('{{ $src }}');
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    opacity: {{ $index === 0 ? 1 : 0 }};
                "
            ></div>
        @endforeach

        <!-- Dark overlay for text visibility -->
        <div class="absolute inset-0" style="background: rgba(0, 0, 0, 0.5); z-index: 0;"></div>

        <!-- Draping Silk Shader -->
        <canvas id="draping-silk" class="absolute inset-0 w-full h-full" style="z-index: 1; pointer-events: none;"></canvas>

        <!-- Carousel Controls -->
        <div class="absolute z-20 left-6 top-1/2 -translate-y-1/2 flex items-center gap-3">
            <button onclick="prevHeroSlide()" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
        </div>

        <div class="absolute z-20 right-6 top-1/2 -translate-y-1/2 flex items-center gap-3">
            <button onclick="nextHeroSlide()" class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Carousel Indicators -->
        <div class="absolute z-20 bottom-32 left-1/2 -translate-x-1/2 flex items-center gap-3">
            @foreach($heroImages as $index => $src)
                <button
                    onclick="goToHeroSlide({{ $index }})"
                    id="hero-indicator-{{ $index }}"
                    class="rounded-full transition-all duration-300"
                    style="
                        width: {{ $index === 0 ? '48px' : '12px' }};
                        height: 12px;
                        background: {{ $index === 0 ? '#ff9729' : 'rgba(255,255,255,0.5)' }};
                    "
                ></button>
            @endforeach
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full px-6 text-center" style="pointer-events: none;">
            <span class="text-sm font-semibold uppercase tracking-wider mb-5" style="color: #ff9729; font-family: 'Lato', sans-serif; pointer-events: auto;">
                {{ $contents['hero_tagline']->value ?? 'Discover Tanzania\'s Wilderness' }}
            </span>

            <h1 class="font-bold mb-6" style="
                font-family: 'Playfair Display', serif;
                font-size: clamp(2.5rem, 7vw, 5.5rem);
                color: #ffffff;
                text-shadow: 0 2px 40px rgba(0,0,0,0.15);
                max-width: 900px;
                line-height: 1.05;
            ">
                <span id="typewriter"></span>
                <span id="cursor" style="border-right: 3px solid #ff9729; padding-right: 3px; animation: blink 0.75s infinite;">&nbsp;</span>
            </h1>

            <p class="text-lg mb-10 max-w-[560px]" style="color: rgba(255, 255, 255, 0.9); font-family: 'Lato', sans-serif; pointer-events: auto;">
                {{ $contents['hero_subtitle']->value ?? 'We offer a variety of safari packages to suit every budget and interest, from luxury lodges to budget camping trips.' }}
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4" style="pointer-events: auto;">
                <a href="{{ route('destinations') }}" class="inline-flex items-center px-8 py-3.5 rounded-full text-base font-semibold text-white transition-all duration-300 hover:-translate-y-0.5" style="background: #088529; box-shadow: 0 4px 12px rgba(8,133,41,0.3);">
                    Explore Tours
                </a>
                <button onclick="alert('Video coming soon!')" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-base font-semibold text-white transition-all duration-300 hover:bg-white hover:bg-opacity-10" style="border: 1px solid rgba(255,255,255,0.6);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" style="color: #ffffff;" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    Watch Video
                </button>
            </div>

            <!-- Scroll Indicator -->
            <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2" style="pointer-events: auto;">
                <span class="text-xs uppercase tracking-wider" style="color: rgba(255, 255, 255, 0.7);">Scroll to explore</span>
                <div class="w-px h-10 animate-pulse" style="background: linear-gradient(to bottom, rgba(255,255,255,0.6), transparent);"></div>
            </div>
        </div>
    </section>

    <!-- Popular Tours Section -->
    <section id="popular-tours" class="relative py-20 lg:py-28" style="min-height: 80vh;">
        <!-- Boulder River Placeholder (we'll skip Three.js for now to keep it simple) -->
        <div class="absolute inset-0" style="background: #f8f4f0; z-index: 0;"></div>

        <div class="relative z-10 max-w-[1280px] mx-auto px-6">
            <div
                class="rounded-3xl p-8 lg:p-12 mb-10"
                style="
                    background: rgba(255,255,255,0.85);
                    backdrop-filter: blur(16px);
                    box-shadow: inset 0 1px 0 rgba(255,255,255,0.3), 0 8px 32px rgba(0,0,0,0.12);
                "
            >
                <span
                    class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block"
                    style="color: #ff9729; font-family: 'Lato', sans-serif;"
                >
                    {{ $contents['popular_tours_label']->value ?? 'Popular Destinations' }}
                </span>
                <h2
                    class="font-bold mb-3"
                    style="
                        font-family: 'Playfair Display', serif;
                        font-size: clamp(1.8rem, 4vw, 3.2rem);
                        color: #854208;
                        line-height: 1.15;
                    "
                >
                    {{ $contents['popular_tours_title']->value ?? 'Day Trip Adventures' }}
                </h2>
                <p class="text-base mb-8" style="color: #111111; font-family: 'Lato', sans-serif;">
                    {{ $contents['popular_tours_subtitle']->value ?? 'Explore Tanzania\'s most beloved natural wonders in a single day' }}
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredTours as $tour)
                        <a
                            href="{{ route('destination.detail', Str::slug($tour->name)) }}"
                            class="group block rounded-xl overflow-hidden transition-all duration-350"
                            style="
                                background: #ffffff;
                                box-shadow: 0 4px 20px rgba(0,0,0,0.06);
                            "
                        >
                            <div class="overflow-hidden" style="aspect-ratio: 16/10;">
                                <img
                                    src="{{ $tour->image }}"
                                    alt="{{ $tour->name }}"
                                    class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105"
                                    loading="lazy"
                                />
                            </div>
                            <div class="p-4">
                                <h3
                                    class="font-bold text-lg mb-1.5"
                                    style="font-family: 'Playfair Display', serif; color: #854208;"
                                >
                                    {{ $tour->name }}
                                </h3>
                                <p class="text-sm mb-3 line-clamp-2" style="color: #111111;">
                                    {{ $tour->desc }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold" style="color: #088529;">
                                        From ${{ $tour->price_adult ?? $tour->price }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 text-sm font-semibold transition-colors duration-300"
                                        style="color: #ff9729;"
                                    >
                                        View Details
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8 text-center">
                    <a
                        href="{{ route('destinations') }}"
                        class="inline-flex items-center px-8 py-3 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90"
                        style="background: #088529;"
                    >
                        View All Destinations
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Multi-Day Section -->
    <section class="py-20 lg:py-28" style="background: #f8f4f0;">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <!-- Left - Text -->
                <div class="lg:sticky lg:top-32">
                    <span
                        class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block"
                        style="color: #ff9729; font-family: 'Lato', sans-serif;"
                    >
                        {{ $contents['multi_day_label']->value ?? 'Extended Adventures' }}
                    </span>
                    <h2
                        class="font-bold mb-5"
                        style="
                            font-family: 'Playfair Display', serif;
                            font-size: clamp(1.8rem, 4vw, 3.2rem);
                            color: #854208;
                            line-height: 1.15;
                        "
                    >
                        {{ $contents['multi_day_title']->value ?? 'Multi-Day Safari Packages' }}
                    </h2>
                    <p class="text-base mb-8 leading-relaxed" style="color: #111111;">
                        {{ $contents['multi_day_description']->value ?? 'Immerse yourself in Tanzania\'s wilderness with our carefully crafted multi-day itineraries. Witness the Great Migration, explore the Ngorongoro Crater, and sleep under the African stars.' }}
                    </p>
                    <a
                        href="{{ route('destinations') }}"
                        class="inline-flex items-center px-8 py-3 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:-translate-y-0.5"
                        style="background: #088529; box-shadow: 0 4px 12px rgba(8,133,41,0.3);"
                    >
                        Plan Your Safari
                    </a>
                </div>

                <!-- Right - Cards -->
                <div class="space-y-6">
                    @php
                        $multiDayTours = $tours->filter(fn($t) => $t->category === 'Multi-Day Safari')->take(3);
                    @endphp
                    @foreach($multiDayTours as $pkg)
                        <a
                            href="{{ route('destination.detail', Str::slug($pkg->name)) }}"
                            class="flex flex-col sm:flex-row gap-5 p-5 rounded-2xl transition-all duration-350 hover:-translate-y-1 group"
                            style="
                                background: #ffffff;
                                box-shadow: 0 4px 20px rgba(0,0,0,0.06);
                            "
                        >
                            <div
                                class="sm:w-[40%] flex-shrink-0 overflow-hidden rounded-xl"
                                style="aspect-ratio: 3/2;"
                            >
                                <img
                                    src="{{ $pkg->image }}"
                                    alt="{{ $pkg->name }}"
                                    class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex flex-col justify-center sm:w-[60%]">
                                <h3
                                    class="font-bold text-xl mb-2"
                                    style="font-family: 'Playfair Display', serif; color: #854208;"
                                >
                                    {{ $pkg->name }}
                                </h3>
                                <p class="text-sm mb-3 line-clamp-2" style="color: #111111;">
                                    {{ $pkg->desc }}
                                </p>
                                <div class="flex flex-wrap items-center gap-3">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white"
                                        style="background: #ff9729;"
                                    >
                                        {{ $pkg->duration }}
                                    </span>
                                    <span class="text-sm font-bold" style="color: #088529;">
                                        From ${{ $pkg->price_adult ?? $pkg->price }}
                                    </span>
                                    <span class="text-sm font-semibold" style="color: #ff9729;">
                                        Learn More &rarr;
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 lg:py-28" style="background: #ffffff;">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">
                <!-- Left - Image -->
                <div class="relative overflow-hidden rounded-2xl" style="aspect-ratio: 4/3;">
                    <img
                        src="{{ asset('images/about-story.jpg') }}"
                        alt="Safari guides with vehicle in the Serengeti"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    />
                    <div
                        class="absolute inset-0"
                        style="background: linear-gradient(to right, rgba(99,30,8,0.1), transparent);"
                    />
                </div>

                <!-- Right - Content -->
                <div>
                    <span
                        class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block"
                        style="color: #ff9729; font-family: 'Lato', sans-serif;"
                    >
                        {{ $contents['why_choose_label']->value ?? 'Why Travel With Us' }}
                    </span>
                    <h2
                        class="font-bold mb-4"
                        style="
                            font-family: 'Playfair Display', serif;
                            font-size: clamp(1.8rem, 4vw, 3.2rem);
                            color: #854208;
                            line-height: 1.15;
                        "
                    >
                        {{ $contents['why_choose_title']->value ?? 'Your Trusted Safari Partner' }}
                    </h2>
                    <p class="text-base mb-8 leading-relaxed" style="color: #111111;">
                        {{ $contents['why_choose_description']->value ?? 'With over a decade of experience, we craft safari experiences that go beyond the ordinary. Our expert guides, comfortable 4x4 vehicles, and deep local knowledge ensure every moment is unforgettable.' }}
                    </p>

                    <div class="space-y-5">
                        @php
                            $features = [
                                [
                                    'title' => 'Expert Local Guides',
                                    'description' => 'Our guides have 10+ years of experience and know every corner of the parks.',
                                ],
                                [
                                    'title' => 'Comfortable 4x4 Vehicles',
                                    'description' => 'Pop-up roof Land Cruisers with charging ports and binoculars.',
                                ],
                                [
                                    'title' => 'All-Inclusive Packages',
                                    'description' => 'No hidden fees. Park entry, meals, and accommodation included.',
                                ],
                                [
                                    'title' => 'Flexible Itineraries',
                                    'description' => 'Customize your trip. We adapt to your interests and pace.',
                                ],
                            ];
                        @endphp
                        @foreach($features as $feature)
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                    style="background: #088529;"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M9 19l-7-7 7-7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="font-bold text-base mb-1"
                                        style="font-family: 'Lato', sans-serif; color: #854208;"
                                    >
                                        {{ $feature['title'] }}
                                    </h4>
                                    <p class="text-sm leading-relaxed" style="color: #111111;">
                                        {{ $feature['description'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 lg:py-28 relative overflow-hidden" style="background: #631e08;">
        <!-- Subtle noise texture overlay -->
        <div
            class="absolute inset-0 opacity-5"
            style="
                background-image: url('data:image/svg+xml;utf8,<svg viewBox=\'0 0 256 256\' xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'noiseFilter\'><feTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/></filter><rect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/></svg>');
            "
        ></div>

        <div class="relative z-10 max-w-[1280px] mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block" style="color: #ff9729; font-family: 'Lato', sans-serif;">
                    {{ $contents['testimonials_label']->value ?? 'Testimonials' }}
                </span>
                <h2
                    class="font-bold mb-4"
                    style="
                        font-family: 'Playfair Display', serif;
                        font-size: clamp(1.8rem, 4vw, 3.2rem);
                        color: #ffffff;
                        line-height: 1.15;
                    "
                >
                    {{ $contents['testimonials_title']->value ?? 'What Our Travelers Say' }}
                </h2>
                <p class="text-base" style="color: rgba(255,255,255,0.8); font-family: 'Lato', sans-serif;">
                    {{ $contents['testimonials_subtitle']->value ?? 'Real experiences from real adventurers' }}
                </p>
            </div>

            <div class="relative">
                <!-- Navigation Arrows -->
                <button
                    onclick="prevTestimonial()"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20"
                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3);"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>

                <button
                    onclick="nextTestimonial()"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20"
                    style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.3);"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Testimonial Card -->
                <div class="max-w-[800px] mx-auto">
                    <div
                        class="rounded-3xl p-8 lg:p-12 relative overflow-hidden"
                        style="
                            background: rgba(255,255,255,0.08);
                            backdrop-filter: blur(16px);
                            border: 1px solid rgba(255,255,255,0.15);
                            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
                        "
                    >
                        <!-- Decorative quote mark -->
                        <div class="absolute top-6 left-6 opacity-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24" viewBox="0 0 24 24" fill="#ff9729">
                                <path d="M3 21v-6c0-4.418 3.582-8 8-8h3c4.418 0 8 3.582 8 8v6h-5v-6h-3a5 5 0 00-5 5v1H3zM18 21v-6c0-2.761 2.239-5 5-5h1v6h-6z"/>
                            </svg>
                        </div>

                        <div class="relative min-h-[220px] flex flex-col items-center justify-center">
                            @foreach($featuredTestimonials as $index => $t)
                                <div
                                    id="testimonial-{{ $index }}"
                                    class="absolute inset-0 flex flex-col items-center justify-center transition-all duration-700"
                                    style="
                                        opacity: {{ $index === 0 ? 1 : 0 }};
                                        transform: {{ $index === 0 ? 'translateX(0)' : 'translateX(30px)' }};
                                        pointer-events: {{ $index === 0 ? 'auto' : 'none' }};
                                    "
                                >
                                    <p
                                        class="text-lg lg:text-2xl italic leading-relaxed max-w-[700px] text-center mb-8"
                                        style="font-family: 'Playfair Display', serif; color: #ffffff;"
                                    >
                                        &ldquo;{{ $t['text'] }}&rdquo;
                                    </p>
                                    <div class="flex items-center gap-1 mb-4">
                                        @for($i = 0; $i < $t['rating']; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="#ff9729" stroke="#ff9729">
                                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <p class="text-lg font-bold" style="color: #ffffff; font-family: 'Lato', sans-serif;">
                                        {{ $t['name'] }}
                                    </p>
                                    <p class="text-sm" style="color: #ff9729; font-family: 'Lato', sans-serif;">
                                        {{ $t['trip'] }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Dot Indicators -->
                <div class="flex items-center justify-center gap-3 mt-8">
                    @foreach($featuredTestimonials as $index => $_)
                        <button
                            onclick="goToTestimonial({{ $index }})"
                            id="testimonial-indicator-{{ $index }}"
                            class="w-3 h-3 rounded-full transition-all duration-300"
                            style="
                                background: {{ $index === 0 ? '#ff9729' : 'rgba(255,255,255,0.3)' }};
                                transform: {{ $index === 0 ? 'scale(1.4)' : 'scale(1)' }};
                            "
                            aria-label="Go to testimonial {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Preview Section -->
    <section class="py-20 lg:py-28" style="background: #f8f4f0;">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span
                        class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block"
                        style="color: #ff9729; font-family: 'Lato', sans-serif;"
                    >
                        {{ $contents['gallery_label']->value ?? 'Photo Gallery' }}
                    </span>
                    <h2
                        class="font-bold"
                        style="
                            font-family: 'Playfair Display', serif;
                            font-size: clamp(1.8rem, 4vw, 3.2rem);
                            color: #854208;
                            line-height: 1.15;
                        "
                    >
                        {{ $contents['gallery_title']->value ?? 'Moments from the Wild' }}
                    </h2>
                </div>
                <a
                    href="{{ route('gallery') }}"
                    class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 hover:-translate-y-0.5"
                    style="color: #088529; border: 1px solid #088529;"
                >
                    View Full Gallery
                </a>
            </div>
        </div>

        <!-- Horizontal Scroll Strip -->
        <div
            class="flex gap-4 overflow-x-auto px-6 pb-4"
            style="
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            "
        >
            @foreach($previewImages as $index => $img)
                <div
                    class="flex-shrink-0 overflow-hidden rounded-xl group cursor-pointer"
                    style="
                        scroll-snap-align: start;
                        height: clamp(200px, 30vw, 320px);
                        aspect-ratio: {{ $index % 2 === 0 ? '4/3' : '3/4' }};
                    "
                >
                    <img
                        src="{{ asset($img['src']) }}"
                        alt="{{ $img['title'] }}"
                        class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105"
                        loading="lazy"
                    />
                </div>
            @endforeach
        </div>

        <style>
            .gallery-strip::-webkit-scrollbar {
                display: none;
            }
        </style>
    </section>

    <!-- CTA Section -->
    <section class="py-20 lg:py-28" style="background: #088529;">
        <div class="max-w-[700px] mx-auto px-6 text-center">
            <h2
                class="font-bold mb-5"
                style="
                    font-family: 'Playfair Display', serif;
                    font-size: clamp(2rem, 5vw, 3.5rem);
                    color: #ffffff;
                    line-height: 1.15;
                "
            >
                {{ $contents['cta_title']->value ?? 'Ready for Your African Adventure?' }}
            </h2>
            <p
                class="text-lg mb-10"
                style="color: rgba(255,255,255,0.9);"
            >
                {{ $contents['cta_description']->value ?? 'Let our experts craft the perfect safari itinerary for you. From day trips to multi-week expeditions, we make your dream trip a reality.' }}
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a
                    href="{{ route('destinations') }}"
                    class="inline-flex items-center px-10 py-4 rounded-full text-base font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                    style="background: #ffffff; color: #088529;"
                >
                    Book Now
                </a>
                <a
                    href="{{ route('contact') }}"
                    class="inline-flex items-center px-10 py-4 rounded-full text-base font-semibold text-white transition-all duration-300 hover:bg-white hover:bg-opacity-10"
                    style="border: 1px solid rgba(255,255,255,0.6);"
                >
                    Contact Us
                </a>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Hero Carousel
        let currentHeroSlide = 0;
        const totalHeroSlides = {{ count($heroImages ?? []) }};
        let heroAutoplayInterval;

        function updateHeroSlides() {
            for (let i = 0; i < totalHeroSlides; i++) {
                const slide = document.getElementById('hero-slide-' + i);
                const indicator = document.getElementById('hero-indicator-' + i);
                if (slide && indicator) {
                    slide.style.opacity = i === currentHeroSlide ? 1 : 0;
                    indicator.style.width = i === currentHeroSlide ? '48px' : '12px';
                    indicator.style.background = i === currentHeroSlide ? '#ff9729' : 'rgba(255,255,255,0.5)';
                }
            }
        }

        function nextHeroSlide() {
            currentHeroSlide = (currentHeroSlide + 1) % totalHeroSlides;
            updateHeroSlides();
            resetAutoplay();
        }

        function prevHeroSlide() {
            currentHeroSlide = (currentHeroSlide - 1 + totalHeroSlides) % totalHeroSlides;
            updateHeroSlides();
            resetAutoplay();
        }

        function goToHeroSlide(index) {
            currentHeroSlide = index;
            updateHeroSlides();
            resetAutoplay();
        }

        function resetAutoplay() {
            clearInterval(heroAutoplayInterval);
            heroAutoplayInterval = setInterval(nextHeroSlide, 6000);
        }

        // Testimonials
        let currentTestimonial = 0;
        const totalTestimonials = {{ count($featuredTestimonials ?? []) }};
        let testimonialInterval;

        function updateTestimonials() {
            for (let i = 0; i < totalTestimonials; i++) {
                const testimonial = document.getElementById('testimonial-' + i);
                const indicator = document.getElementById('testimonial-indicator-' + i);
                if (testimonial && indicator) {
                    testimonial.style.opacity = i === currentTestimonial ? 1 : 0;
                    testimonial.style.transform = i === currentTestimonial ? 'translateX(0)' : 'translateX(30px)';
                    testimonial.style.pointerEvents = i === currentTestimonial ? 'auto' : 'none';
                    indicator.style.background = i === currentTestimonial ? '#ff9729' : 'rgba(255,255,255,0.3)';
                    indicator.style.transform = i === currentTestimonial ? 'scale(1.4)' : 'scale(1)';
                }
            }
        }

        function goToTestimonial(index) {
            currentTestimonial = index;
            updateTestimonials();
            resetTestimonialAutoplay();
        }

        function nextTestimonial() {
            currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
            updateTestimonials();
            resetTestimonialAutoplay();
        }

        function prevTestimonial() {
            currentTestimonial = (currentTestimonial - 1 + totalTestimonials) % totalTestimonials;
            updateTestimonials();
            resetTestimonialAutoplay();
        }

        function resetTestimonialAutoplay() {
            clearInterval(testimonialInterval);
            testimonialInterval = setInterval(nextTestimonial, 6000);
        }

        // Start testimonial autoplay
        resetTestimonialAutoplay();

        // Draping Silk Shader
        function initDrapingSilk() {
            const canvas = document.getElementById('draping-silk');
            if (!canvas) return;

            const gl = canvas.getContext('webgl');
            if (!gl) {
                console.log('WebGL not supported');
                return;
            }

            // Vertex shader
            const vertexShaderSource = `
                attribute vec2 a_pos;
                varying vec2 v_uv;
                void main() {
                    v_uv = a_pos * 0.5 + 0.5;
                    gl_Position = vec4(a_pos, 0.0, 1.0);
                }
            `;

            // Fragment shader
            const fragmentShaderSource = `
                precision highp float;
                uniform float u_time;
                uniform vec2 u_res;
                uniform vec3 u_color;
                varying vec2 v_uv;

                float hash(vec2 p) {
                    p = fract(p * vec2(127.1, 311.7));
                    p += dot(p, p + 45.32);
                    return fract(p.x * p.y);
                }

                float noise(vec2 p) {
                    vec2 i = floor(p);
                    vec2 f = fract(p);
                    vec2 u = f * f * (3.0 - 2.0 * f);
                    float a = hash(i);
                    float b = hash(i + vec2(1.0, 0.0));
                    float c = hash(i + vec2(0.0, 1.0));
                    float d = hash(i + vec2(1.0, 1.0));
                    return mix(mix(a, b, u.x), mix(c, d, u.x), u.y);
                }

                float fbm(vec2 p) {
                    float val = 0.0;
                    float amp = 0.5;
                    float freq = 1.0;
                    for (int i = 0; i < 5; i++) {
                        val += amp * noise(p * freq);
                        freq *= 2.03;
                        amp *= 0.5;
                        p += vec2(1.7, 9.2);
                    }
                    return val;
                }

                float ridgedNoise(vec2 p) {
                    return 1.0 - abs(noise(p) * 2.0 - 1.0);
                }

                float fabricFold(vec2 uv, float t, float foldStrength, float foldFreq, float foldPhase) {
                    float foldCenter = sin(uv.x * foldFreq * 3.14159 + foldPhase) * 0.25;
                    float foldLine = abs(uv.y - foldCenter);
                    float foldShape = exp(-foldLine * foldLine * 120.0);
                    float foldWave = sin(uv.x * 12.0 + t * 0.4) * 0.03;
                    float foldRidges = pow(max(ridgedNoise(vec2(uv.x * 8.0 + foldPhase, t * 0.15)), 0.0), 3.0) * 0.15;
                    return (foldShape + foldWave) * foldStrength + foldRidges * foldStrength;
                }

                float fabricDrape(vec2 uv, float t) {
                    float drape1 = sin(uv.x * 2.5 + t * 0.25) * 0.06;
                    float drape2 = sin(uv.x * 4.0 + t * 0.35 + 1.5) * 0.035;
                    float drape3 = sin(uv.x * 7.0 + t * 0.18 + 3.0) * 0.015;
                    float weightPull = sin(uv.x * 1.5 + t * 0.1) * 0.02;
                    float drapeNoise = fbm(vec2(uv.x * 3.0, t * 0.1)) * 0.02;
                    float centerGather = sin((uv.x - 0.5) * 1.8) * 0.025;
                    return drape1 + drape2 + drape3 + weightPull + drapeNoise + centerGather;
                }

                float fabricFolds(vec2 uv, float t) {
                    float fold = 0.0;
                    fold += fabricFold(uv, t, 0.5, 1.2, t * 0.15);
                    fold += fabricFold(uv, t, 0.35, 2.8, t * 0.2 + 2.0);
                    fold += fabricFold(uv, t, 0.25, 4.5, t * 0.12 + 4.0);
                    fold += fabricFold(uv, t, 0.18, 7.0, t * 0.18 + 1.0);
                    fold += fabricFold(uv, t, 0.12, 11.0, t * 0.08 + 3.5);
                    return fold;
                }

                void main() {
                    vec2 uv = (gl_FragCoord.xy - u_res * 0.5) / min(u_res.x, u_res.y);
                    vec2 c = gl_FragCoord.xy / u_res;
                    float t = u_time;

                    float folds = fabricFolds(c, t);
                    folds += sin(c.x * 2.5 + t * 0.2) * 0.04;
                    folds += fbm(vec2(c.x * 6.0 + t * 0.1, c.y * 3.0)) * 0.03;

                    float drapeEffect = fabricDrape(c, t);

                    vec2 patternUV = c;
                    patternUV.y += folds * 0.08;
                    patternUV.x += drapeEffect * 0.03;
                    patternUV.y += drapeEffect * 0.06;

                    float pattern = fbm(patternUV * 3.0 + vec2(t * 0.05, 0.0));
                    float sheen = pow(max(noise(patternUV * 8.0 + vec2(t * 0.08, t * 0.03)), 0.0), 2.0);
                    pattern += sheen * 0.3;

                    float threadX = sin(patternUV.x * 200.0) * 0.5 + 0.5;
                    float threadY = sin(patternUV.y * 200.0) * 0.5 + 0.5;
                    float threads = threadX * threadY * 0.06 + (threadX * 0.02);

                    float foldDepth = folds + drapeEffect;

                    vec3 lightDir = normalize(vec3(0.3, 0.8, 0.5));
                    vec3 foldNormal = normalize(vec3(-(folds * 0.5 + drapeEffect * 0.3), 0.6, 1.0));
                    float diffuse = max(dot(foldNormal, lightDir), 0.0);

                    vec3 viewDir = normalize(vec3(0.0, 0.0, 1.0));
                    vec3 halfDir = normalize(lightDir + viewDir);
                    float specAngle = max(dot(foldNormal, halfDir), 0.0);
                    float spec = pow(specAngle, 60.0);

                    float fresnel = pow(1.0 - max(dot(foldNormal, viewDir), 0.0), 3.0);

                    vec3 baseColor = u_color;
                    float colorMix = clamp(diffuse * 1.5 + foldDepth * 0.3 + pattern * 0.2, 0.0, 1.0);
                    vec3 finalColor = baseColor * (0.7 + colorMix * 0.6);

                    finalColor += vec3(0.05, 0.02, 0.0) * fresnel * 0.3;
                    finalColor += vec3(0.35, 0.08, 0.0) * sheen * 0.25;
                    finalColor += vec3(0.02, 0.01, 0.0) * threads;
                    finalColor += vec3(0.45, 0.18, 0.0) * spec * 0.7;
                    finalColor += vec3(0.45, 0.18, 0.0) * pow(max(folds, 0.0), 3.0) * 0.15;

                    float depthShadow = smoothstep(-0.15, 0.25, foldDepth);
                    float gatherShadow = smoothstep(0.3, 0.7, c.y);
                    float shadow = depthShadow * 0.7 + 0.3;
                    finalColor *= shadow * gatherShadow;

                    finalColor += vec3(0.02, 0.005, 0.0) * (1.0 - depthShadow) * 0.5;

                    float breathe = sin(t * 0.15) * 0.015;
                    finalColor += vec3(0.02, 0.005, 0.0) * breathe;

                    float vig = 1.0 - dot(uv * 0.8, uv * 0.8);
                    vig = smoothstep(0.0, 1.0, vig);
                    finalColor *= 0.65 + vig * 0.35;

                    finalColor += (hash(gl_FragCoord.xy + fract(t * 0.1) * 1000.0) - 0.5) * 0.012;

                    finalColor = pow(finalColor, vec3(0.95));

                    gl_FragColor = vec4(finalColor, 0.3);
                }
            `;

            // Compile shader helper
            function compileShader(gl, source, type) {
                const shader = gl.createShader(type);
                gl.shaderSource(shader, source);
                gl.compileShader(shader);
                if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
                    console.error('Shader compile error:', gl.getShaderInfoLog(shader));
                    gl.deleteShader(shader);
                    return null;
                }
                return shader;
            }

            // Create shaders
            const vertexShader = compileShader(gl, vertexShaderSource, gl.VERTEX_SHADER);
            const fragmentShader = compileShader(gl, fragmentShaderSource, gl.FRAGMENT_SHADER);

            // Create program
            const program = gl.createProgram();
            gl.attachShader(program, vertexShader);
            gl.attachShader(program, fragmentShader);
            gl.linkProgram(program);
            if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
                console.error('Program link error:', gl.getProgramInfoLog(program));
                return;
            }
            gl.useProgram(program);

            // Create geometry (a fullscreen triangle)
            const positions = new Float32Array([-1, -1, 3, -1, -1, 3]);
            const positionBuffer = gl.createBuffer();
            gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
            gl.bufferData(gl.ARRAY_BUFFER, positions, gl.STATIC_DRAW);

            const a_pos = gl.getAttribLocation(program, 'a_pos');
            gl.enableVertexAttribArray(a_pos);
            gl.vertexAttribPointer(a_pos, 2, gl.FLOAT, false, 0, 0);

            // Get uniform locations
            const u_time = gl.getUniformLocation(program, 'u_time');
            const u_res = gl.getUniformLocation(program, 'u_res');
            const u_color = gl.getUniformLocation(program, 'u_color');

            // Resize canvas
            function resize() {
                const heroSection = document.getElementById('hero-section');
                if (!heroSection) return;
                const rect = heroSection.getBoundingClientRect();
                canvas.width = rect.width;
                canvas.height = rect.height;
                gl.viewport(0, 0, canvas.width, canvas.height);
            }
            window.addEventListener('resize', resize);
            resize();

            // Animation loop
            const startTime = performance.now();
            function animate(time) {
                const t = (time - startTime) / 1000;
                gl.uniform1f(u_time, t);
                gl.uniform2f(u_res, canvas.width, canvas.height);
                gl.uniform3f(u_color, 0.35, 0.12, 0.0); // Brown color
                gl.drawArrays(gl.TRIANGLES, 0, 3);
                requestAnimationFrame(animate);
            }
            requestAnimationFrame(animate);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            heroAutoplayInterval = setInterval(nextHeroSlide, 6000);
            testimonialInterval = setInterval(nextTestimonial, 6000);
            initDrapingSilk();

            // Typewriter effect
            const messages = [
                "The Best African Safari Experience",
                "Discover Tanzania's Hidden Gems",
                "Adventures That Last a Lifetime",
                "Witness the Great Migration",
                "Connect with Nature's Beauty"
            ];
            let messageIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            const typewriter = document.getElementById('typewriter');

            function type() {
                const currentMessage = messages[messageIndex];
                
                if (isDeleting) {
                    typewriter.textContent = currentMessage.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    typewriter.textContent = currentMessage.substring(0, charIndex + 1);
                    charIndex++;
                }

                let typeSpeed = isDeleting ? 50 : 100;

                if (!isDeleting && charIndex === currentMessage.length) {
                    typeSpeed = 2000; // Pause at end
                    isDeleting = true;
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    messageIndex = (messageIndex + 1) % messages.length;
                    typeSpeed = 500;
                }

                setTimeout(type, typeSpeed);
            }

            // Start typewriter
            type();

            // Hide silk on scroll
            window.addEventListener('scroll', function() {
                const silk = document.getElementById('draping-silk');
                const hero = document.getElementById('hero-section');
                if (hero && silk) {
                    const heroHeight = hero.clientHeight;
                    if (window.scrollY > heroHeight) {
                        silk.style.display = 'none';
                    } else {
                        silk.style.display = 'block';
                    }
                }
            });
        });
    </script>
@endsection
