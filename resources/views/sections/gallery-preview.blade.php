@props([
    'previewImages',
    'contents',
])

<!-- Gallery Preview Section -->
<section class="py-20 lg:py-28" style="background: #f8f4f0;">
    <div class="max-w-[1280px] mx-auto px-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between mb-8 gap-4">
            <div>
                <span
                    class="text-sm font-semibold uppercase tracking-[0.15em] mb-3 block"
                    style="color: #ff9729; font-family: 'Raleway', sans-serif;"
                >
                    {{ $contents['gallery_label']->value ?? 'Photo Gallery' }}
                </span>
                <h2
                    class="font-bold"
                    style="
                        font-family: 'Raleway', sans-serif;
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
                    src="{{ $img['src'] }}"
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
