@extends('layouts.app')

@section('title', 'Tanzania Daily Tours & Safari - Expert-Guided Safaris Since 2012')
@section('meta_title', 'Tanzania Daily Tours & Safari - Expert-Guided Safaris Since 2012')
@section('meta_description', 'Discover Tanzania with our expert local guides. Serengeti safaris, Kilimanjaro climbs, Zanzibar beaches, and cultural tours. 15+ years experience, 10,000+ happy travelers. Book your adventure today!')
@section('meta_keywords', 'Tanzania safari, Serengeti safari, Kilimanjaro climbing, Zanzibar tours, Ngorongoro crater, Tarangire safari, Tanzania tour operator, safari packages, wildlife tours, cultural tours Tanzania')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg')

@section('structured_data')
@php
    $structuredData = '<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Tanzania Daily Tours & Safari - Expert-Guided Safaris Since 2012",
    "description": "Discover Tanzania with our expert local guides. Serengeti safaris, Kilimanjaro climbs, Zanzibar beaches, and cultural tours.",
    "url": "https://www.tanzaniadailytoursandsafari.com",
    "mainEntity": {
        "@type": "TravelAgency",
        "name": "Tanzania Daily Tours & Safari",
        "description": "Expert-guided Tanzania safaris, cultural tours, and Kilimanjaro adventures since 2012"
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
            "name": "What is the best time to visit Tanzania for safari?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "The best time for Tanzania safaris is during the dry season from June to October for excellent wildlife viewing. The Great Migration occurs from June to July in the Serengeti."
            }
        },
        {
            "@type": "Question",
            "name": "How much does a Tanzania safari cost?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Tanzania safari prices range from $150 to $500 per day depending on the park, accommodation level, and group size. We offer budget, mid-range, and luxury safari packages."
            }
        },
        {
            "@type": "Question",
            "name": "Do I need a visa for Tanzania?",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "Most visitors need a visa for Tanzania. You can obtain an e-visa online or get a visa on arrival at major airports and border crossings."
            }
        }
    ]
}
</script>';
@endphp
{!! $structuredData !!}

@section('content')
    @php
        $featuredTestimonials = collect($testimonials ?? [])->take(3)->values();
        $gallery = $gallery ?? [];
        $previewImages = collect($gallery)->map(function($item) {
            $src = '';
            $title = '';
            if (is_object($item)) {
                $src = $item->url ?? '';
                $title = $item->caption ?? '';
            } elseif (is_array($item)) {
                $src = $item['url'] ?? ($item[0] ?? '');
                $title = $item['caption'] ?? ($item[1] ?? '');
            }
            return ['src' => $src, 'title' => $title];
        })->take(10);

        $heroImages = [
            'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg',
            'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890322/safari-kilimanjaro_rnqbaj.jpg',
            'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-ngorongoro_j04gqg.jpg',
            'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890318/gallery-landscape-1_dxdd6x.jpg',
            'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890321/gallery-wildlife-1_tzfe6e.jpg',
            'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890319/tour-zanzibar_y2syxk.jpg',
        ];
        $ariaLabels = [
            'Serengeti safari with wildlife including lions and elephants',
            'Mount Kilimanjaro summit view with snow-capped peak',
            'Ngorongoro crater landscape with wildlife',
            'Tanzania wildlife safari in national park',
            'African animals in natural habitat including giraffes',
            'Zanzibar beach paradise with turquoise waters'
        ];
    @endphp

    @include('sections.hero')
    @include('sections.popular-tours')
    @include('sections.multi-day')
    @include('sections.experience')
    @include('sections.travel-tips')
    @include('sections.testimonials')
    @include('sections.gallery-preview')
    @include('sections.cta')
@endsection

@section('scripts')
    @vite(['resources/js/home.js'])
@endsection
