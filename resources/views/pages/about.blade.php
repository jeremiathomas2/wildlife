@extends('layouts.app')

@section('title', 'About Us - Tanzania Daily Tours & Safari')
@section('meta_title', 'About Us - Tanzania Daily Tours & Safari')
@section('meta_description', 'Learn about Tanzania Daily Tours & Safari - your trusted local guide for authentic safaris, cultural experiences, and Kilimanjaro adventures since 2012. We offer Tanzania safari packages, Serengeti safari, Serengeti tours, Ngorongoro safari, and more!')
@section('meta_keywords', 'Tanzania Wild safari, daily tour, Best Tanzania Tourist, Tanzania safari, Tanzania safari packages, Serengeti safari, Serengeti tours, Mount Kilimanjaro climbing, Zanzibar holidays, Tanzania travel, Tanzania wildlife safari, Ngorongoro safari, Tarangire National Park, Mikumi safari, Ruaha safari, Tanzania honeymoon safari, Family safari Tanzania, Luxury safari Tanzania, Budget safari Tanzania')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/about-story_of4wth.jpg')

@section('content')
    <!-- Page Header -->
    <section class="relative h-[50vh] min-h-[320px] flex items-end pb-16">
        <div class="absolute inset-0">
            <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890320/about-hero_dbeshf.jpg" alt="About" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(26,18,8,0.4), rgba(99,30,8,0.8));"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">About</span>
            </nav>
            <h1 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
                {{ $contents['about_page_title']->value ?? 'About Tanzania Daily Tours' }}
            </h1>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="overflow-hidden rounded-2xl" style="aspect-ratio: 4/3;">
                    <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/about-story_of4wth.jpg" alt="Story" class="w-full h-full object-cover" loading="lazy">
                </div>
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider mb-3 block" style="color: #ff9729;">{{ $contents['about_story_label']->value ?? 'Our Story' }}</span>
                    <h2 class="font-bold mb-4" style="font-family: 'Playfair Display', serif; font-size: clamp(1.5rem, 3vw, 2.5rem); color: #854208; line-height: 1.15;">
                        {{ $contents['about_story_title']->value ?? 'Passionate About Tanzania\'s Natural Heritage' }}
                    </h2>
                    <div class="text-base leading-relaxed" style="color: #111111;">
                        {!! $contents['about_story_text']->value ?? '<p>Founded by local guides with deep knowledge of Tanzania\'s parks and cultures, Tanzania Daily Tours was born from a love of sharing our incredible homeland with visitors from around the world.</p><p>What started as a small team of passionate safari guides has grown into one of the most trusted tour operators in the region. We\'ve spent over a decade crafting unforgettable experiences, from Kilimanjaro\'s summit to the Serengeti\'s endless plains.</p><p>Our mission is simple: to show you the real Tanzania. Not just the postcard views, but the warmth of our people, the depth of our cultures, and the raw beauty of our wilderness.</p>' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values -->
    <section class="py-16 lg:py-20" style="background: #ffffff;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-sm font-semibold uppercase tracking-wider mb-3 block" style="color: #ff9729;">{{ $contents['about_values_label']->value ?? 'Our Values' }}</span>
                <h2 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #854208;">
                    {{ $contents['about_values_title']->value ?? 'What Drives Us' }}
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 rounded-2xl" style="background: #f8f4f0;">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background: #088529;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                            <path d="M2 17l10 5 10-5"/>
                            <path d="M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="font-family: 'Playfair Display', serif; color: #854208;">Sustainability</h3>
                    <p class="text-sm" style="color: #111111;">We practice responsible tourism that protects wildlife and supports local communities.</p>
                </div>
                <div class="text-center p-6 rounded-2xl" style="background: #f8f4f0;">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background: #088529;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="font-family: 'Playfair Display', serif; color: #854208;">Authenticity</h3>
                    <p class="text-sm" style="color: #111111;">Real experiences with real people. No staged cultural performances.</p>
                </div>
                <div class="text-center p-6 rounded-2xl" style="background: #f8f4f0;">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background: #088529;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="7"/>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="font-family: 'Playfair Display', serif; color: #854208;">Excellence</h3>
                    <p class="text-sm" style="color: #111111;">From our vehicles to our guides, we settle for nothing less than the best.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <span class="text-sm font-semibold uppercase tracking-wider mb-3 block" style="color: #ff9729;">{{ $contents['about_team_label']->value ?? 'Our Team' }}</span>
                <h2 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #854208;">
                    {{ $contents['about_team_title']->value ?? 'Meet the Experts' }}
                </h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($team as $member)
                    <div class="text-center">
                        <div class="w-28 h-28 rounded-full overflow-hidden mx-auto mb-4" style="aspect-ratio: 1/1;">
                            <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <h3 class="font-bold text-base" style="font-family: 'Playfair Display', serif; color: #854208;">{{ $member['name'] }}</h3>
                        <p class="text-xs font-semibold mb-1" style="color: #088529;">{{ $member['role'] }}</p>
                        <p class="text-xs" style="color: #5a3e2b;">{{ $member['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-14" style="background: #088529;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                        10+
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">Years of Experience</p>
                </div>
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                        5,000+
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">Happy Travelers</p>
                </div>
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                        12
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">National Parks Covered</p>
                </div>
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                        100%
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">Local Team</p>
                </div>
            </div>
        </div>
    </section>
@endsection
