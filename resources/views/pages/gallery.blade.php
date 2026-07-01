@extends('layouts.app')

@section('content')
    <!-- Page Header -->
    <section class="relative h-[40vh] min-h-[280px] flex items-end pb-16">
        <div class="absolute inset-0">
            <img src="{{ asset('images/gallery-landscape-1.jpg') }}" alt="Gallery" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(26,18,8,0.4), rgba(99,30,8,0.8));"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">Gallery</span>
            </nav>
            <h1 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
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
                    <div class="gallery-item break-inside-avoid rounded-xl overflow-hidden cursor-pointer group relative" data-category="{{ $item->category }}" onclick="openLightbox({{ $index }})" style="aspect-ratio: {{ $index % 3 === 0 ? '4/3' : ($index % 3 === 1 ? '3/4' : '1/1') }};">
                        <img src="{{ asset($item->url) }}" alt="{{ $item->caption }}" class="w-full h-full object-cover transition-transform duration-400 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-end p-4">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-sm font-bold text-white">{{ $item->caption }}</p>
                                <p class="text-xs text-white text-opacity-70 capitalize">{{ $item->category }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div id="lightbox" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 hidden" onclick="closeLightbox()">
        <button class="absolute top-6 right-6 text-white hover:text-opacity-70 transition-colors" onclick="closeLightbox()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <button class="absolute left-6 top-1/2 -translate-y-1/2 text-white hover:text-opacity-70 transition-colors" onclick="event.stopPropagation(); prevImage()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>
        <button class="absolute right-6 top-1/2 -translate-y-1/2 text-white hover:text-opacity-70 transition-colors" onclick="event.stopPropagation(); nextImage()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        <img id="lightbox-img" src="" alt="" class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg" onclick="event.stopPropagation()">
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-center">
            <p id="lightbox-title" class="text-sm font-bold text-white"></p>
            <p id="lightbox-category" class="text-xs text-white text-opacity-70 capitalize"></p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const galleryData = @json($galleryData);
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
            document.getElementById('lightbox-img').src = item.src;
            document.getElementById('lightbox-img').alt = item.title;
            document.getElementById('lightbox-title').textContent = item.title;
            document.getElementById('lightbox-category').textContent = item.category;
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
    </script>
@endsection
