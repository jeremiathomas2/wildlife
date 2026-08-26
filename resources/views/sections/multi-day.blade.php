@props([
    'tours',
    'contents',
])

<!-- Multi-Day Section -->
<section class="py-20 lg:py-28 relative overflow-hidden" style="min-height: 600px;" id="multiDaySection">
    <!-- Scroll-Zoom Background Image -->
    <div
        id="multiBgZoom"
        class="absolute inset-0 will-change-transform"
        style="
            background-image: url('https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg');
            background-size: cover;
            background-position: center;
            transform: scale(1.25);
        "
    ></div>

    <!-- Dark Overlay -->
    <div class="absolute inset-0" style="background: linear-gradient(to right, rgba(17,17,17,0.82) 0%, rgba(17,17,17,0.65) 50%, rgba(17,17,17,0.45) 100%); z-index: 1;"></div>

    <div class="relative z-10 max-w-[1280px] mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            <!-- Left - Text -->
            <div class="lg:sticky lg:top-32">
                <div class="mb-6">
                    <span
                        class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block"
                        style="color: #ff9729; font-family: 'Raleway', sans-serif;"
                    >
                        {{ $contents['multi_day_label']->value ?? 'Extended Adventures' }}
                    </span>
                    <h2
                        class="font-bold mb-5"
                        style="
                            font-family: 'Raleway', sans-serif;
                            font-size: clamp(1.8rem, 4vw, 3.2rem);
                            color: #ffffff;
                            line-height: 1.15;
                        "
                    >
                        {{ $contents['multi_day_title']->value ?? 'Multi-Day Safari Packages' }}
                    </h2>
                </div>
                <p class="text-base mb-8 leading-relaxed" style="color: rgba(255,255,255,0.8);">
                    {{ $contents['multi_day_description']->value ?? 'Immerse yourself in Tanzania\'s wilderness with our carefully crafted multi-day itineraries. Witness the Great Migration, explore the Ngorongoro Crater, and sleep under the African stars.' }}
                </p>

                <!-- Highlights -->
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(8,133,41,0.2); border: 1px solid rgba(8,133,41,0.3);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#088529" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold" style="color: #ffffff;">Expert Guides</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,151,41,0.2); border: 1px solid rgba(255,151,41,0.3);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#ff9729" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold" style="color: #ffffff;">Flexible Duration</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold" style="color: #ffffff;">Lodge & Camp</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(8,133,41,0.2); border: 1px solid rgba(8,133,41,0.3);">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="#088529" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 9V5a3 3 0 00-6 0v4"/>
                                <path d="M18.8 22H5.2c-.66 0-1.2-.54-1.2-1.2V11.2c0-.66.54-1.2 1.2-1.2h13.6c.66 0 1.2.54 1.2 1.2v9.6c0 .66-.54 1.2-1.2 1.2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold" style="color: #ffffff;">All-Inclusive</span>
                    </div>
                </div>

                <a
                    href="{{ route('destinations') }}"
                    class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:-translate-y-0.5 hover:gap-3"
                    style="background: #088529; box-shadow: 0 4px 12px rgba(8,133,41,0.3); font-family: 'Raleway', sans-serif;"
                >
                    Plan Your Safari
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"/>
                        <path d="m12 5 7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <!-- Right - Cards -->
            <div class="space-y-8">
                @php
                    $multiDayTours = collect($tours)->filter(function($t) {
                        $cat = is_object($t) ? ($t->category ?? '') : ($t['category'] ?? '');
                        return $cat === 'Multi-Day Safari';
                    })->take(3);
                @endphp
                @foreach($multiDayTours as $pkg)
                    <a
                        href="{{ route('destination.detail', is_object($pkg) ? ($pkg->slug ?? Str::slug($pkg->name ?? '')) : ($pkg['slug'] ?? Str::slug($pkg['name'] ?? ''))) }}"
                        class="block rounded-2xl overflow-hidden transition-all duration-500 hover:-translate-y-1 group"
                        style="
                            background: #ffffff;
                            box-shadow: 0 2px 16px rgba(0,0,0,0.05);
                            border: 1px solid rgba(133,66,8,0.05);
                        "
                    >
                        <!-- Card Image -->
                        <div class="relative overflow-hidden" style="aspect-ratio: 16/7;">
                            <img
                                src="{{ is_object($pkg) ? ($pkg->image ?? '') : ($pkg['image'] ?? '') }}"
                                alt="{{ is_object($pkg) ? ($pkg->name ?? '') : ($pkg['name'] ?? '') }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(17,17,17,0.6) 0%, transparent 50%);"></div>

                            <!-- Duration Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold text-white" style="background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <polyline points="12 6 12 12 16 14"/>
                                    </svg>
                                    {{ is_object($pkg) ? ($pkg->duration ?? '') : ($pkg['duration'] ?? '') }}
                                </span>
                            </div>

                            <!-- Price Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold text-white" style="background: #088529; box-shadow: 0 2px 6px rgba(8,133,41,0.35);">
                                    From ${{ is_object($pkg) ? ($pkg->price_adult ?? $pkg->price ?? 0) : ($pkg['price_adult'] ?? $pkg['price'] ?? 0) }}
                                </span>
                            </div>

                            <!-- Title on image -->
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <h3
                                    class="font-bold text-lg"
                                    style="font-family: 'Raleway', sans-serif; color: #ffffff;"
                                >
                                    {{ is_object($pkg) ? ($pkg->name ?? '') : ($pkg['name'] ?? '') }}
                                </h3>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-4 py-3">
                            <p class="text-xs mb-3 line-clamp-1 leading-relaxed" style="color: #5a3e2b;">
                                {{ is_object($pkg) ? ($pkg->desc ?? '') : ($pkg['desc'] ?? '') }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1 text-[11px] font-semibold" style="color: #088529;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"/>
                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                    </svg>
                                    Customizable
                                </span>
                                <span class="inline-flex items-center gap-1 text-xs font-bold transition-all duration-300 group-hover:gap-2" style="color: #ff9729; font-family: 'Raleway', sans-serif;">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14"/>
                                        <path d="m12 5 7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
