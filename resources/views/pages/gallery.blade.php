@extends('layouts.app')

@section('title', 'Tanzania Safari Photo Gallery - Wildlife, Landscapes & Culture')
@section('meta_title', 'Tanzania Safari Photo Gallery - Wildlife, Landscapes & Culture')
@section('meta_description', 'Browse our Tanzania safari photo gallery. Stunning wildlife photos, landscapes, cultural moments from Serengeti, Kilimanjaro, Zanzibar, and more.')
@section('meta_keywords', 'Tanzania safari photos, wildlife photography Tanzania, Serengeti photos, Kilimanjaro pictures, Zanzibar images, Tanzania travel photos, safari gallery')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/gallery-landscape-1_dxdd6x.jpg')

@section('structured_data')
@php
    $structuredData = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ImageGallery",
    "name": "Tanzania Safari Photo Gallery",
    "description": "Browse our Tanzania safari photo gallery featuring wildlife, landscapes, and cultural moments",
    "url": "https://www.tanzaniadailytoursandsafari.com/gallery"
}
</script>';
@endphp
{!! $structuredData !!}

@section('content')
    <!-- Page Header -->
    <section class="relative h-[40vh] min-h-[280px] flex items-end pb-16">
        <div class="absolute inset-0">
            <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890318/gallery-landscape-1_dxdd6x.jpg" alt="Gallery" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(26,18,8,0.4), rgba(99,30,8,0.8));"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">Gallery</span>
            </nav>
            <h1 class="font-bold" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
                {{ $contents['gallery_page_title']->value ?? 'Photo Gallery' }}
            </h1>
        </div>
    </section>

    <!-- Gallery -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Filters -->
            <div class="flex flex-wrap items-center justify-center gap-3 mb-10">
                <button class="gallery-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="all" style="background: #088529; color: #ffffff;">
                    All
                </button>
                <button class="gallery-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="wildlife" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Wildlife
                </button>
                <button class="gallery-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="landscape" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Landscapes
                </button>
                <button class="gallery-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="people" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    People
                </button>
                <button class="gallery-filter-btn px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300" data-filter="culture" style="background: transparent; color: #854208; border: 1px solid #854208;">
                    Culture
                </button>
            </div>

            <!-- Masonry Grid -->
            <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4" id="gallery-grid">
                @foreach($gallery as $index => $item)
                    <div class="gallery-item break-inside-avoid rounded-xl overflow-hidden cursor-pointer group relative" data-category="{{ is_object($item) ? ($item->category ?? '') : ($item['category'] ?? '') }}" onclick="openLightbox({{ $index }})" style="aspect-ratio: {{ $index % 3 === 0 ? '4/3' : ($index % 3 === 1 ? '3/4' : '1/1') }};">
                        <img src="{{ is_object($item) ? ($item->url ?? '') : ($item['url'] ?? '') }}" alt="{{ is_object($item) ? ($item->caption ?? '') : ($item['caption'] ?? '') }}" class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-end p-4">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-sm font-bold text-white">{{ is_object($item) ? ($item->caption ?? '') : ($item['caption'] ?? '') }}</p>
                                <p class="text-xs text-white text-opacity-70 capitalize">{{ is_object($item) ? ($item->category ?? '') : ($item['category'] ?? '') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox" class="fixed inset-0 z-50 hidden" onclick="closeLightbox()">
        <!-- Backdrop -->
        <div class="absolute inset-0" style="background: rgba(0,0,0,0.92); backdrop-filter: blur(4px);"></div>

        <!-- Close Button -->
        <button class="absolute top-5 right-5 z-10 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);" onclick="event.stopPropagation(); closeLightbox()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
        </button>

        <!-- Image Counter -->
        <div class="absolute top-5 left-1/2 -translate-x-1/2 z-10 px-4 py-1.5 rounded-full text-xs font-semibold" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15); color: rgba(255,255,255,0.85); font-family: 'Raleway', sans-serif;">
            <span id="lightbox-counter"></span>
        </div>

        <!-- Prev Button -->
        <button class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20 hover:scale-110" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);" onclick="event.stopPropagation(); prevImage()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Next Button -->
        <button class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 hover:bg-white hover:bg-opacity-20 hover:scale-110" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);" onclick="event.stopPropagation(); nextImage()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: #ffffff;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Image Container -->
        <div class="relative z-10 flex items-center justify-center w-full h-full px-16 py-20" onclick="event.stopPropagation()">
            <img id="lightbox-img" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg transition-opacity duration-300" style="box-shadow: 0 20px 60px rgba(0,0,0,0.5);">
        </div>

        <!-- Caption -->
        <div class="absolute bottom-5 left-1/2 -translate-x-1/2 z-10 text-center px-6 py-3 rounded-2xl" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1);">
            <p id="lightbox-title" class="text-sm font-bold text-white" style="font-family: 'Raleway', sans-serif;"></p>
            <p id="lightbox-category" class="text-xs text-white text-opacity-60 capitalize mt-0.5"></p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const galleryData = @json($galleryData ?? []);
        let currentIndex = 0;

        const filterBtns = document.querySelectorAll('.gallery-filter-btn');
        const items = document.querySelectorAll('.gallery-item');

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

                // Filter items
                items.forEach((item, index) => {
                    const category = item.dataset.category;
                    if (filter === 'all' || category === filter) {
                        item.style.display = 'block';
                        setTimeout(() => item.style.opacity = '1', 10);
                    } else {
                        item.style.opacity = '0';
                        setTimeout(() => item.style.display = 'none', 300);
                    }
                });
            });
        });

        function openLightbox(index) {
            currentIndex = index;
            updateLightbox();
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function updateLightbox() {
            const item = galleryData[currentIndex];
            const img = document.getElementById('lightbox-img');
            img.style.opacity = '0';
            setTimeout(function() {
                img.src = item.src;
                img.alt = item.title;
                img.onload = function() { img.style.opacity = '1'; };
            }, 150);
            document.getElementById('lightbox-title').textContent = item.title;
            document.getElementById('lightbox-category').textContent = item.category;
            document.getElementById('lightbox-counter').textContent = (currentIndex + 1) + ' / ' + galleryData.length;
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % galleryData.length;
            updateLightbox();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + galleryData.length) % galleryData.length;
            updateLightbox();
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (document.getElementById('lightbox').classList.contains('hidden')) return;
            
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });

        // Touch swipe navigation
        let touchStartX = 0;
        let touchEndX = 0;
        const lightboxEl = document.getElementById('lightbox');

        lightboxEl.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });

        lightboxEl.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            const diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextImage();
                else prevImage();
            }
        }, { passive: true });
    </script>
@endsection
