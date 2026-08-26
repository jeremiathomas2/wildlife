@props([
    'featuredTours',
    'contents',
])

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
                style="color: #ff9729; font-family: 'Raleway', sans-serif;"
            >
                {{ $contents['popular_tours_label']->value ?? 'Popular Destinations' }}
            </span>
            <h2
                class="font-bold mb-3"
                style="
                    font-family: 'Raleway', sans-serif;
                    font-size: clamp(1.8rem, 4vw, 3.2rem);
                    color: #854208;
                    line-height: 1.15;
                "
            >
                {{ $contents['popular_tours_title']->value ?? 'Day Trip Adventures' }}
            </h2>
            <p class="text-base mb-8" style="color: #111111; font-family: 'Raleway', sans-serif;">
                {{ $contents['popular_tours_subtitle']->value ?? 'Explore Tanzania\'s most beloved natural wonders in a single day' }}
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredTours as $tour)
                    <a
                                    href="{{ route('destination.detail', is_object($tour) ? ($tour->slug ?? Str::slug($tour->name ?? '')) : ($tour['slug'] ?? Str::slug($tour['name'] ?? ''))) }}"
                                    class="group block rounded-xl overflow-hidden transition-all duration-350"
                                    style="
                                        background: #ffffff;
                                        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
                                    "
                                >
                                    <div class="overflow-hidden" style="aspect-ratio: 16/10;">
                                        <img
                                            src="{{ is_object($tour) ? ($tour->image ?? '') : ($tour['image'] ?? '') }}"
                                            alt="{{ is_object($tour) ? ($tour->name ?? '') : ($tour['name'] ?? '') }}"
                                            class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105"
                                            loading="lazy"
                                        />
                                    </div>
                                    <div class="p-4">
                                        <h3
                                            class="font-bold text-lg mb-1.5"
                                            style="font-family: 'Raleway', sans-serif; color: #854208;"
                                        >
                                            {{ is_object($tour) ? ($tour->name ?? '') : ($tour['name'] ?? '') }}
                                        </h3>
                                        <p class="text-sm mb-3 line-clamp-2" style="color: #111111;">
                                            {{ is_object($tour) ? ($tour->desc ?? '') : ($tour['desc'] ?? '') }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-bold" style="color: #088529;">
                                                From ${{ is_object($tour) ? ($tour->price_adult ?? $tour->price ?? 0) : ($tour['price_adult'] ?? $tour['price'] ?? 0) }}
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
