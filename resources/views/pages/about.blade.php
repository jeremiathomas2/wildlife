@extends('layouts.app')

@section('title', 'About Tanzania Daily Tours & Safari - Local Experts Since 2012')
@section('meta_title', 'About Tanzania Daily Tours & Safari - Local Experts Since 2012')
@section('meta_description', 'Learn about Tanzania Daily Tours & Safari - your trusted local tour operator since 2012. Expert guides, authentic experiences, and unforgettable adventures across Tanzania.')
@section('meta_keywords', 'Tanzania tour operator, local safari guides, about Tanzania tours, Tanzania safari company, Arusha tour operator, experienced safari guides, authentic Tanzania experiences')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/about-story_of4wth.jpg')

@section('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AboutPage",
    "name": "About Tanzania Daily Tours & Safari",
    "description": "Learn about Tanzania Daily Tours & Safari - your trusted local tour operator since 2012",
    "url": "https://www.tanzaniadailytoursandsafari.com/about",
    "mainEntity": {
        "@type": "Organization",
        "name": "Tanzania Daily Tours & Safari",
        "foundingDate": "2012",
        "description": "Expert-guided Tanzania safaris, cultural tours, and Kilimanjaro adventures",
        "employee": {
            "@type": "Person",
            "name": "Ally Juma",
            "jobTitle": "Senior Tour Guide",
            "image": "https://res.cloudinary.com/aenplcpl/image/upload/v1783677911/ally_h4ud4z.png",
            "description": "Expert Tanzania safari guide with over 10 years of experience"
        }
    }
}
</script>
@endsection

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
            <h1 class="font-bold" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
                {{ $contents['about_page_title']->value ?? 'About Our Story' }}
            </h1>
        </div>
    </section>

    <!-- Our Story -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <div class="overflow-hidden rounded-2xl" style="aspect-ratio: 4/3;">
                    <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1783621533/Tanzania_Daily_Tours_and_Safari_guide-Picsart-AiImageEnhancer_qisc5z.png" alt="Story" class="w-full h-full object-cover" loading="lazy">
                </div>
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider mb-3 block" style="color: #ff9729;">{{ $contents['about_story_label']->value ?? 'Our Story' }}</span>
                    <h2 class="font-bold mb-4" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.5rem, 3vw, 2.5rem); color: #854208; line-height: 1.15;">
                        {{ $contents['about_story_title']->value ?? 'Passionate About Tanzania\'s Natural Heritage' }}
                    </h2>
                    <div class="text-base leading-relaxed" style="color: #111111; text-align: justify;">
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
                <h2 class="font-bold" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #854208;">
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
                    <h3 class="font-bold text-lg mb-2" style="font-family: 'Raleway', sans-serif; color: #854208;">Sustainability</h3>
                    <p class="text-sm" style="color: #111111;">We practice responsible tourism that protects wildlife and supports local communities.</p>
                </div>
                <div class="text-center p-6 rounded-2xl" style="background: #f8f4f0;">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background: #088529;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="font-family: 'Raleway', sans-serif; color: #854208;">Authenticity</h3>
                    <p class="text-sm" style="color: #111111;">Real experiences with real people. No staged cultural performances.</p>
                </div>
                <div class="text-center p-6 rounded-2xl" style="background: #f8f4f0;">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background: #088529;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="7"/>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2" style="font-family: 'Raleway', sans-serif; color: #854208;">Excellence</h3>
                    <p class="text-sm" style="color: #111111;">From our vehicles to our guides, we settle for nothing less than the best.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl p-8 lg:p-12 text-center" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                    <div class="w-40 h-40 rounded-full overflow-hidden mx-auto mb-6" style="aspect-ratio: 1/1; border: 4px solid #088529;">
                        <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1783677911/ally_h4ud4z.png" alt="Petro Mihambo" class="w-full h-full object-cover" loading="lazy">
                    </div>
                    <p class="text-sm font-semibold uppercase tracking-wider mb-2" style="color: #ff9729;">Senior Tour Guide</p>
                    <h3 class="font-bold text-2xl lg:text-3xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">Ally Juma</h3>
                    <p class="text-lg mb-6" style="color: #111111;">Let us Plan your dream Safari Journey</p>
                    <p class="text-sm mb-8" style="color: #5a3e2b;">Enquire now and our Travel Expert will get back to you within 24 hours.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('contact') }}" class="px-8 py-3 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90 text-center" style="background: #088529;">
                            HELP ME PLAN
                        </a>
                        <a href="https://wa.me/255623975934" target="_blank" rel="noopener noreferrer" class="px-8 py-3 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90 text-center flex items-center justify-center gap-2" style="background: #25D366;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            GET SUPPORT VIA WHATSAPP
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-14" style="background: #088529;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Raleway', sans-serif; color: #ffffff;">
                        10+
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">Years of Experience</p>
                </div>
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Raleway', sans-serif; color: #ffffff;">
                        5,000+
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">Happy Travelers</p>
                </div>
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Raleway', sans-serif; color: #ffffff;">
                        12
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">National Parks Covered</p>
                </div>
                <div>
                    <p class="text-3xl lg:text-4xl font-bold mb-1" style="font-family: 'Raleway', sans-serif; color: #ffffff;">
                        100%
                    </p>
                    <p class="text-sm" style="color: rgba(255,255,255,0.8);">Local Team</p>
                </div>
            </div>
        </div>
    </section>
@endsection
