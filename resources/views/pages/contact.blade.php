@extends('layouts.app')

@section('title', 'Contact Tanzania Daily Tours & Safari - Plan Your Safari')
@section('meta_title', 'Contact Tanzania Daily Tours & Safari - Plan Your Safari')
@section('meta_description', 'Get in touch with Tanzania Daily Tours & Safari to plan your perfect Tanzania adventure. Expert consultation, custom itineraries, and 24/7 support. Book your safari today!')
@section('meta_keywords', 'contact Tanzania safari, book Tanzania safari, safari inquiry, Tanzania tour booking, Arusha tour operator contact, safari consultation')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/contact-header_uxkkku.jpg')

@section('structured_data')
@php
    $structuredData = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact Tanzania Daily Tours & Safari",
    "description": "Get in touch with Tanzania Daily Tours & Safari to plan your perfect Tanzania adventure",
    "url": "https://www.tanzaniadailytoursandsafari.com/contact",
    "mainEntity": {
        "@type": "TravelAgency",
        "name": "Tanzania Daily Tours & Safari",
        "telephone": "+255123456789",
        "email": "info@tanzaniadailytoursandsafari.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Arusha, Tanzania",
            "addressLocality": "Arusha",
            "addressCountry": "TZ"
        }
    }
}
</script>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        {
            "@type": "Question",
            "name": "How do I book a Tanzania safari?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "You can book a Tanzania safari by contacting us through our website form, WhatsApp, or email. We'll respond within 24 hours with a customized itinerary and quote based on your preferences and travel dates."
            }
        },
        {
            "@type": "Question",
            "name": "What information do I need to provide for booking?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "To book your safari, we'll need your travel dates, number of travelers, preferred destinations, accommodation level (budget, mid-range, or luxury), and any special requirements or dietary restrictions."
            }
        },
        {
            "@type": "Question",
            "name": "What payment methods do you accept?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "We accept bank transfers, credit cards, and mobile money payments. A 30% deposit is required to confirm your booking, with the remaining balance due 30 days before your safari begins."
            }
        }
    ]
}
</script>';
@endphp
{!! $structuredData !!}

@section('content')
    <!-- Page Header -->
    <section class="relative h-[40vh] min-h-[280px] flex items-end pb-16">
        <div class="absolute inset-0">
            <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890320/contact-header_x16img.jpg" alt="Contact" class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(26,18,8,0.4), rgba(99,30,8,0.8));"></div>
        </div>
        <div class="relative z-10 max-w-7xl mx-auto px-6 w-full">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">Contact</span>
            </nav>
            <h1 class="font-bold" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.8rem, 4vw, 3.2rem); color: #ffffff;">
                {{ $contents['contact_page_title']->value ?? 'Get in Touch' }}
            </h1>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="py-16 lg:py-20" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Info -->
                <div>
                    <span class="text-sm font-semibold uppercase tracking-wider mb-3 block" style="color: #ff9729;">Contact Us</span>
                    <h2 class="font-bold mb-6" style="font-family: 'Raleway', sans-serif; font-size: clamp(1.5rem, 3vw, 2.5rem); color: #854208; line-height: 1.15;">
                        {{ $contents['contact_subtitle']->value ?? 'Plan Your Perfect Safari' }}
                    </h2>
                    <p class="text-base leading-relaxed mb-8" style="color: #111111;">
                        {{ $contents['contact_description']->value ?? 'Ready to start your adventure? Send us a message and we\'ll get back to you within 24 hours to help plan your personalized Tanzanian experience.' }}
                    </p>

                    <!-- Quick Links -->
                    <div class="mb-8 p-4 rounded-lg" style="background: rgba(255,151,41,0.1);">
                        <p class="text-sm font-semibold mb-3" style="color: #854208;">Quick Links:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('destinations') }}" class="text-xs px-3 py-1 rounded-full transition-colors hover:bg-white" style="background: rgba(8,133,41,0.1); color: #088529;">View Safari Packages</a>
                            <a href="{{ route('about') }}" class="text-xs px-3 py-1 rounded-full transition-colors hover:bg-white" style="background: rgba(8,133,41,0.1); color: #088529;">About Us</a>
                            <a href="{{ route('reviews') }}" class="text-xs px-3 py-1 rounded-full transition-colors hover:bg-white" style="background: rgba(8,133,41,0.1); color: #088529;">Read Reviews</a>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background: #088529;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1" style="font-family: 'Raleway', sans-serif; color: #854208;">Location</h3>
                                <p class="text-sm" style="color: #111111;">{{ $contents['contact_location']->value ?? 'Wakala wa Vipimo - Moshi - Kilimanjaro' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background: #088529;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1" style="font-family: 'Raleway', sans-serif; color: #854208;">Phone</h3>
                                <p class="text-sm" style="color: #111111;">{{ $contents['contact_phone']->value ?? '+255 700 000 000' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0" style="background: #088529;">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg mb-1" style="font-family: 'Raleway', sans-serif; color: #854208;">Email</h3>
                                <p class="text-sm" style="color: #111111;">{{ $contents['contact_email']->value ?? 'info@tanzaniadailytours.com' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div>
                    <div class="bg-white rounded-2xl p-8" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                        @if(session('success'))
                            <div class="mb-4 p-4 rounded-lg text-sm text-center" style="background: rgba(8,133,41,0.1); color: #088529;">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('contact.submit') }}">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="name" class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">Full Name</label>
                                    <input type="text" id="name" name="name" required class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                </div>
                                <div>
                                    <label for="email" class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">Email</label>
                                    <input type="email" id="email" name="email" required class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="interest" class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">What interests you?</label>
                                <select id="interest" name="interest" class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                    <option>Serengeti Safari</option>
                                    <option>Kilimanjaro Trek</option>
                                    <option>Zanzibar Holiday</option>
                                    <option>Day Trips</option>
                                    <option>Custom Itinerary</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="message" class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">Your Message</label>
                                <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;"></textarea>
                            </div>
                            <button type="submit" class="w-full py-3.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90" style="background: #088529;">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
