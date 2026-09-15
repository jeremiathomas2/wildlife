<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Tanzania Daily Tours & Safari - Best Safari & Tours in Tanzania')</title>
    <meta name="title" content="@yield('meta_title', 'Tanzania Daily Tours & Safari - Best Safari & Tours in Tanzania')">
    <meta name="description" content="@yield('meta_description', 'Experience the best of Tanzania with expert-guided safaris, cultural tours, and Kilimanjaro adventures. Explore Serengeti, Ngorongoro, Zanzibar & more!')">
    <meta name="keywords" content="@yield('meta_keywords', 'Tanzania safari, Kilimanjaro trek, Serengeti, Zanzibar, Ngorongoro, day trips, wildlife tours')">
    <meta name="author" content="Tanzania Daily Tours & Safari">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="theme-color" content="#6e2f0a">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', 'Tanzania Daily Tours & Safari - Best Safari & Tours in Tanzania')">
    <meta property="og:description" content="@yield('meta_description', 'Experience the best of Tanzania with expert-guided safaris, cultural tours, and Kilimanjaro adventures. Explore Serengeti, Ngorongoro, Zanzibar & more!')">
    <meta property="og:image" content="@yield('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg')">
    <meta property="og:site_name" content="Tanzania Daily Tours & Safari">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('meta_title', 'Tanzania Daily Tours & Safari - Best Safari & Tours in Tanzania')">
    <meta name="twitter:description" content="@yield('meta_description', 'Experience the best of Tanzania with expert-guided safaris, cultural tours, and Kilimanjaro adventures. Explore Serengeti, Ngorongoro, Zanzibar & more!')">
    <meta name="twitter:image" content="@yield('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg')">

    <!-- JSON-LD Structured Data -->
    @yield('structured_data')

    @php
        $organizationSchema = '<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "TravelAgency",
        "name": "Tanzania Daily Tours & Safari",
        "description": "Expert-guided Tanzania safaris, cultural tours, and Kilimanjaro adventures since 2012",
        "url": "https://www.tanzaniadailytoursandsafari.com",
        "logo": "https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_200/v1782890324/safari-logo-brown_d1vgxe.png",
        "image": "https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg",
        "telephone": "+255623975934",
        "email": "info@tanzaniadailytoursandsafari.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Wakala wa Vipimo",
            "addressLocality": "Moshi",
            "addressRegion": "Kilimanjaro",
            "postalCode": "25113",
            "addressCountry": "TZ"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "-3.3546",
            "longitude": "37.3414"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            "opens": "08:00",
            "closes": "18:00"
        },
        "priceRange": "$$",
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.8",
            "reviewCount": "500",
            "bestRating": "5",
            "worstRating": "1"
        },
        "sameAs": [
            "https://www.instagram.com/tanzania_dailytours_and_safari/",
            "https://www.facebook.com/tanzaniadailytoursandsafari",
            "https://twitter.com/tanzaniadailytours"
        ],
        "founder": { "@type": "Person", "name": "Petro Mihambo", "jobTitle": "Senior Tour Guide" },
        "foundingDate": "2012",
        "areaServed": { "@type": "Country", "name": "Tanzania" },
        "knowsAbout": [
            "Serengeti National Park", "Ngorongoro Crater", "Mount Kilimanjaro",
            "Tarangire National Park", "Lake Manyara", "Zanzibar",
            "Tanzania wildlife", "Great Migration", "Big Five Africa"
        ]
    }
    </script>';

        $localBusinessSchema = '<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Tanzania Daily Tours & Safari",
        "description": "Expert-guided Tanzania safaris, cultural tours, and Kilimanjaro adventures since 2012",
        "url": "https://www.tanzaniadailytoursandsafari.com",
        "telephone": "+255623975934",
        "email": "info@tanzaniadailytoursandsafari.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Wakala wa Vipimo",
            "addressLocality": "Moshi",
            "addressRegion": "Kilimanjaro",
            "postalCode": "25113",
            "addressCountry": "TZ"
        },
        "geo": { "@type": "GeoCoordinates", "latitude": "-3.3546", "longitude": "37.3414" },
        "openingHours": "Mo-Sa 08:00-18:00",
        "priceRange": "$$",
        "aggregateRating": {
            "@type": "AggregateRating", "ratingValue": "4.8", "reviewCount": "500"
        }
    }
    </script>';

        $websiteSchema = '<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Tanzania Daily Tours & Safari",
        "url": "https://www.tanzaniadailytoursandsafari.com",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "https://www.tanzaniadailytoursandsafari.com/destinations?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>';
    @endphp
    {!! $organizationSchema !!}
    {!! $localBusinessSchema !!}
    {!! $websiteSchema !!}

    <!-- Breadcrumb Schema -->
    @php
        $showBreadcrumb = request()->path() != '/';
        $showSecondItem = request()->path() != 'destinations';
        $segment1 = request()->segment(1) ? ucfirst(str_replace('-', ' ', request()->segment(1))) : '';
        $breadcrumbItems = [
            ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => "https://www.tanzaniadailytoursandsafari.com"]
        ];
        if ($showSecondItem && $segment1) {
            $breadcrumbItems[] = [
                "@type" => "ListItem",
                "position" => 2,
                "name" => $segment1,
                "item" => "https://www.tanzaniadailytoursandsafari.com/" . request()->segment(1)
            ];
        }
        $breadcrumbJson = json_encode($breadcrumbItems);
        $breadcrumbScript = '';
        if ($showBreadcrumb) {
            $breadcrumbScript = '<script type="application/ld+json">{
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": ' . $breadcrumbJson . '
    }</script>';
        }
    @endphp
    {!! $breadcrumbScript !!}

    <!-- Fonts + Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;800;900&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://res.cloudinary.com" />
    <link rel="dns-prefetch" href="https://res.cloudinary.com" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-chrome-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon/android-chrome-512x512.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    @stack('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/safari.css') }}" />
</head>
<body>

@include('partials.preloader')
@include('partials.header')

<main id="siteMain">
    @yield('content')
</main>

@include('partials.footer')
@include('partials.modals')

<script src="{{ asset('assets/js/safari-data.js') }}"></script>
@include('partials.safari-data')
<script src="{{ asset('assets/js/safari.js') }}"></script>
@yield('scripts')
@stack('scripts')

</body>
</html>