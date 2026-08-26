@props([
    'contents',
])

<!-- Hero Section -->
<section id="hero-section" class="relative overflow-hidden" style="height: 100vh; min-height: 600px;" data-total-slides="{{ count($heroImages ?? []) }}">
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
            role="img"
            aria-label="{{ $ariaLabels[$index] ?? $ariaLabels[0] }}"
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
        <span class="text-sm font-semibold uppercase tracking-wider mb-5" style="color: #ff9729; font-family: 'Raleway', sans-serif; pointer-events: auto;">
            {{ $contents['hero_tagline']->value ?? 'Discover Tanzania\'s Wilderness' }}
        </span>

        <h1 class="font-bold mb-6" style="
            font-family: 'Raleway', sans-serif;
            font-size: clamp(2.5rem, 7vw, 5.5rem);
            color: #ffffff;
            text-shadow: 0 2px 40px rgba(0,0,0,0.15);
            max-width: 900px;
            line-height: 1.05;
        ">
            <span id="typewriter"></span>
            <span id="cursor" style="border-right: 3px solid #ff9729; padding-right: 3px; animation: blink 0.75s infinite;">&nbsp;</span>
        </h1>

        <p class="text-lg mb-10 max-w-[560px]" style="color: rgba(255, 255, 255, 0.9); font-family: 'Raleway', sans-serif; pointer-events: auto;">
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
