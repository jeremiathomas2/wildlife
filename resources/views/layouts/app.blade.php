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
    <meta name="keywords" content="@yield('meta_keywords', 'Tanzania Wild safari, daily tour, Best Tanzania Tourist, Tanzania safari, Tanzania safari packages, Serengeti safari, Serengeti tours, Mount Kilimanjaro climbing, Zanzibar holidays, Tanzania travel, Tanzania wildlife safari, Ngorongoro safari, Tarangire National Park, Mikumi safari, Ruaha safari, Tanzania honeymoon safari, Family safari Tanzania, Luxury safari Tanzania, Budget safari Tanzania')">
    <meta name="author" content="Tanzania Daily Tours & Safari">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('meta_title', 'Tanzania Daily Tours & Safari - Best Safari & Tours in Tanzania')">
    <meta property="og:description" content="@yield('meta_description', 'Experience the best of Tanzania with expert-guided safaris, cultural tours, and Kilimanjaro adventures. Explore Serengeti, Ngorongoro, Zanzibar & more!')">
    <meta property="og:image" content="@yield('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-serengeti_agwjrp.jpg')">
    <meta property="og:site_name" content="Tanzania Daily Tours & Safari">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('meta_title', 'Tanzania Daily Tours & Safari - Best Safari & Tours in Tanzania')">
    <meta name="twitter:description" content="@yield('meta_description', 'Experience the best of Tanzania with expert-guided safaris, cultural tours, and Kilimanjaro adventures. Explore Serengeti, Ngorongoro, Zanzibar & more!')">
    <meta name="twitter:image" content="@yield('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-serengeti_agwjrp.jpg')">
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JS83PTXEYM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-JS83PTXEYM');
    </script>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: ["class"],
            theme: {
                extend: {
                    colors: {
                        border: "hsl(var(--border))",
                        input: "hsl(var(--input))",
                        ring: "hsl(var(--ring))",
                        background: "hsl(var(--background))",
                        foreground: "hsl(var(--foreground))",
                        primary: {
                            DEFAULT: "hsl(var(--primary))",
                            foreground: "hsl(var(--primary-foreground))",
                        },
                        secondary: {
                            DEFAULT: "hsl(var(--secondary))",
                            foreground: "hsl(var(--secondary-foreground))",
                        },
                        destructive: {
                            DEFAULT: "hsl(var(--destructive))",
                            foreground: "hsl(var(--destructive-foreground))",
                        },
                        muted: {
                            DEFAULT: "hsl(var(--muted))",
                            foreground: "hsl(var(--muted-foreground))",
                        },
                        accent: {
                            DEFAULT: "hsl(var(--accent))",
                            foreground: "hsl(var(--accent-foreground))",
                        },
                        popover: {
                            DEFAULT: "hsl(var(--popover))",
                            foreground: "hsl(var(--popover-foreground))",
                        },
                        card: {
                            DEFAULT: "hsl(var(--card))",
                            foreground: "hsl(var(--card-foreground))",
                        },
                        sidebar: {
                            DEFAULT: "hsl(var(--sidebar-background))",
                            foreground: "hsl(var(--sidebar-foreground))",
                            primary: "hsl(var(--sidebar-primary))",
                            "primary-foreground": "hsl(var(--sidebar-primary-foreground))",
                            accent: "hsl(var(--sidebar-accent))",
                            "accent-foreground": "hsl(var(--sidebar-accent-foreground))",
                            border: "hsl(var(--sidebar-border))",
                            ring: "hsl(var(--sidebar-ring))",
                        },
                    },
                    borderRadius: {
                        xl: "calc(var(--radius) + 4px)",
                        lg: "var(--radius)",
                        md: "calc(var(--radius) - 2px)",
                        sm: "calc(var(--radius) - 4px)",
                        xs: "calc(var(--radius) - 6px)",
                    },
                    boxShadow: {
                        xs: "0 1px 2px 0 rgb(0 0 0 / 0.05)",
                    },
                    keyframes: {
                        "accordion-down": {
                            from: { height: "0" },
                            to: { height: "var(--radix-accordion-content-height)" },
                        },
                        "accordion-up": {
                            from: { height: "var(--radix-accordion-content-height)" },
                            to: { height: "0" },
                        },
                        "caret-blink": {
                            "0%,70%,100%": { opacity: "1" },
                            "20%,50%": { opacity: "0" },
                        },
                    },
                    animation: {
                        "accordion-down": "accordion-down 0.2s ease-out",
                        "accordion-up": "accordion-up 0.2s ease-out",
                        "caret-blink": "caret-blink 1.25s ease-out infinite",
                    },
                },
            },
        }
    </script>
    <style>
        @layer base {
            body {
                font-family: 'Lato', sans-serif;
                color: #111111;
                background: #f8f4f0;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            h1, h2, h3, h4, h5, h6 {
                font-family: 'Playfair Display', serif;
            }
        }

        @layer components {
            .glow-text {
                position: relative;
                display: inline-block;
                font-family: 'Playfair Display', serif;
                font-weight: 700;
                font-size: clamp(2rem, 5vw, 3.5rem);
                color: #ffffff;
                letter-spacing: 0.02em;
                padding: 0 0.5em;
                border-radius: 0.15em;
                text-shadow:
                    0 0 0.1em #088529,
                    0 0 0.2em #088529,
                    0 0 0.3em #088529,
                    0 0 0.4em #088529,
                    0 0 0.6em #088529,
                    0 0 0.8em #088529,
                    0 0 1em #088529;
                box-shadow:
                    inset 0 0 0.5em #088529,
                    inset 0 0 1em #088529,
                    0 0 0.5em #088529;
                animation: glowCycle 12s infinite linear, glowPulse 3s infinite ease-in-out;
            }

            .glow-text::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                border-radius: inherit;
                background: linear-gradient(45deg, #088529, #ff9729, #854208);
                z-index: -1;
                opacity: 0.25;
                animation: glowCycle 12s infinite linear, glowPulse 3s infinite ease-in-out;
            }

            .glow-text::selection {
                background: #088529;
                color: #fff;
            }
        }

        @keyframes glowCycle {
            0%,100% {
                filter: hue-rotate(0deg);
            }
            33.33% {
                filter: hue-rotate(-30deg);
            }
            66.66% {
                filter: hue-rotate(30deg);
            }
        }

        @keyframes glowPulse {
            0%,100% {
                opacity: 1;
            }
            50% {
                opacity: 0.82;
            }
        }

        @keyframes zoomInOut {
            0%,100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }
    </style>
    <style>
        /* Custom responsive styles */
        * {
            box-sizing: border-box;
        }
        
        body {
            overflow-x: hidden;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes zoomInOut {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        /* Hide overflow on mobile */
        @media (max-width: 768px) {
            .hero-content {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .section-padding {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        /* Touch-friendly buttons */
        button, a {
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Smooth image loading */
        img {
            display: block;
            max-width: 100%;
            height: auto;
        }
        
        /* Improve scrollbar on mobile */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f8f4f0;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #854208;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #ff9729;
        }
        
        /* Mobile menu styles */
        .mobile-menu-item {
            position: relative;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            transition: background-color 0.2s ease;
        }
        
        .mobile-menu-item:hover {
            background: rgba(255, 151, 41, 0.05);
        }
        
        .mobile-menu-item::after {
            content: '';
            position: absolute;
            left: 24px;
            right: 24px;
            bottom: 0;
            height: 1px;
            background: rgba(133, 66, 8, 0.1);
        }
        
        .mobile-menu-item:last-child::after {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Loading Screen - Only show on home page -->
    @if(Route::currentRouteName() === 'home')
    <div id="loadingScreen" class="fixed inset-0 z-[100] flex flex-col items-center justify-center" style="background: #f8f4f0; opacity: 1; transition: opacity 0.5s ease;">
    <script>
        (function() {
            const hasSeenSplash = localStorage.getItem('hasSeenSplash');
            const loadingScreen = document.getElementById('loadingScreen');
            if (hasSeenSplash) {
                loadingScreen.style.display = 'none';
            }
        })();
    </script>
        <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-brown_d1vgxe.png" alt="Tanzania Daily Tours & Safari" style="height: 120px; width: auto; object-fit: contain; margin-bottom: 20px; animation: zoomInOut 2s ease-in-out infinite;">
        <h2 class="text-2xl font-bold italic mb-6" style="font-family: 'Playfair Display', serif; color: #854208;">Tanzania Daily Tour and Safari</h2>
        <span class="w-2 h-2 rounded-full animate-pulse" style="background: #ff9729;"></span>
        <style>
            @keyframes zoomInOut {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.2); }
            }
        </style>
    </div>
    @endif

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-400" id="mainNav">
        <div class="max-w-[1280px] mx-auto px-6 flex items-center justify-between" style="height: 72px;">
            @php
                $navLinks = [
                    ['label' => 'Home', 'route' => 'home', 'icon' => 'home'],
                    ['label' => 'Destinations', 'route' => 'destinations', 'icon' => 'destination'],
                    ['label' => 'About', 'route' => 'about', 'icon' => 'about'],
                    ['label' => 'Reviews', 'route' => 'reviews', 'icon' => 'reviews'],
                    ['label' => 'Gallery', 'route' => 'gallery', 'icon' => 'gallery'],
                    ['label' => 'Contact', 'route' => 'contact', 'icon' => 'contact'],
                ];
                $currentRoute = Route::currentRouteName();
            @endphp
            
            <a href="{{ route('home') }}" class="flex items-center gap-3" style="transition: all 0.4s ease;">
            <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-white_bexcal.png" id="navLogo" alt="Tanzania Daily Tours & Safari" style="height: 50px; object-fit: contain;">
            <span class="text-xl font-bold italic hidden sm:block" id="navTitle" style="font-family: 'Playfair Display', serif; color: #ffffff; transition: color 0.4s ease;">
                Tanzania Daily Tours and Safari
            </span>
        </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-8">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" 
                       class="text-sm font-semibold relative py-1" 
                       style="
                           color: {{ $currentRoute === $link['route'] ? '#ff9729' : '#ffffff' }}; 
                           font-family: 'Lato', sans-serif;
                           transition: all 0.3s ease;
                       "
                       onmouseover="this.querySelector('span').style.width = '100%'; this.querySelector('span').style.left = '0';"
                       onmouseout="
                           @if($currentRoute !== $link['route'])
                               this.querySelector('span').style.width = '0'; 
                               this.querySelector('span').style.left = '50%';
                           @endif
                       "
                    >
                        {{ $link['label'] }}
                        <span class="absolute bottom-0 h-0.5" style="
                            background: #ff9729;
                            left: {{ $currentRoute === $link['route'] ? '0' : '50%' }};
                            width: {{ $currentRoute === $link['route'] ? '100%' : '0' }};
                            transition: all 0.3s ease;
                        "></span>
                    </a>
                @endforeach
            </div>

            <div class="hidden lg:block">
                <a href="{{ route('destinations') }}" class="inline-flex items-center px-6 py-2.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90" style="background: #088529;">
                    Book a Trip
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <button id="mobileMenuBtn" class="lg:hidden flex flex-col gap-1.5 p-2" aria-label="Toggle menu">
                <span class="block w-6 h-0.5 transition-all duration-300" id="hamburger1" style="background: #ffffff;"></span>
                <span class="block w-6 h-0.5 transition-all duration-300" id="hamburger2" style="background: #ffffff;"></span>
                <span class="block w-6 h-0.5 transition-all duration-300" id="hamburger3" style="background: #ffffff;"></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobileMenu" class="fixed inset-0 z-40 hidden flex-col bg-white" style="padding-top: 80px;">
        <!-- Mobile menu header -->
        <div class="absolute top-0 left-0 right-0 px-6 flex items-center justify-between" style="height: 72px; background: #854208;">
            <a href="{{ route('home') }}" class="flex items-center gap-3" onclick="closeMobileMenu()">
                <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-white_bexcal.png" alt="Tanzania Daily Tours & Safari" style="height: 50px; object-fit: contain;">
                <span class="text-xl font-bold italic" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                    Tanzania Daily Tours and Safari
                </span>
            </a>
            <button onclick="closeMobileMenu()" class="p-2" aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" style="color: #ffffff;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <!-- Mobile menu items -->
        <div class="flex-1 overflow-y-auto bg-white">
            @foreach($navLinks as $index => $link)
                <a href="{{ route($link['route']) }}" 
                   class="mobile-menu-item" 
                   style="
                       color: {{ $currentRoute === $link['route'] ? '#ff9729' : '#854208' }};
                       font-family: 'Lato', sans-serif;
                       font-size: 18px;
                       font-weight: {{ $currentRoute === $link['route'] ? '700' : '500' }};
                       background: {{ $currentRoute === $link['route'] ? 'rgba(255, 151, 41, 0.08)' : 'transparent' }};
                   " 
                   onclick="closeMobileMenu()">
                    <span>{{ $link['label'] }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" style="color: {{ $currentRoute === $link['route'] ? '#ff9729' : '#854208' }};" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 6l6 6-6 6"/>
                    </svg>
                </a>
            @endforeach
        </div>
        
        <!-- Mobile menu footer -->
        <div class="p-6" style="background: #f8f4f0;">
            <a href="{{ route('destinations') }}" 
               class="w-full inline-flex items-center justify-center px-6 py-3.5 rounded-full text-lg font-semibold text-white transition-all duration-300 hover:opacity-90" 
               style="background: #088529;" 
               onclick="closeMobileMenu()">
                Book a Trip
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        <div id="pageContent" style="opacity: 0; transform: translateY(20px); transition: opacity 0.5s ease, transform 0.5s ease;">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #854208;">
        <div class="max-w-[1280px] mx-auto px-6 py-16">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
                <!-- Brand -->
                <div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                        <img src="https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-white_bexcal.png" alt="Tanzania Daily Tours & Safari" style="height: 50px; object-fit: contain;">
                        <span class="text-xl font-bold italic" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                            Tanzania Daily Tours and Safari
                        </span>
                    </a>
                    <p class="text-sm leading-relaxed" style="color: rgba(255, 255, 255, 0.7);">
                        Authentic African safari experiences since 2012. We craft unforgettable journeys through Tanzania's most spectacular landscapes.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-4" style="color: #ff9729;">
                        Quick Links
                    </h4>
                    <ul class="space-y-2.5">
                        @php
                            $quickLinks = [
                                ['label' => 'Home', 'route' => 'home'],
                                ['label' => 'About Us', 'route' => 'about'],
                                ['label' => 'Destinations', 'route' => 'destinations'],
                                ['label' => 'Reviews', 'route' => 'reviews'],
                                ['label' => 'Gallery', 'route' => 'gallery'],
                                ['label' => 'Contact', 'route' => 'contact'],
                            ];
                        @endphp
                        @foreach($quickLinks as $link)
                            <li>
                                <a href="{{ route($link['route']) }}" class="text-sm transition-colors duration-300 hover:text-white" style="color: rgba(255, 255, 255, 0.7);">
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Popular Tours -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-4" style="color: #ff9729;">
                        Popular Tours
                    </h4>
                    <ul class="space-y-2.5">
                        @php
                            $popularTours = [
                                'Materuni Waterfall',
                                'Chemka Hot Springs',
                                'Kilimanjaro Day Hike',
                                'Serengeti Safari',
                            ];
                        @endphp
                        @foreach($popularTours as $tour)
                            <li>
                                <a href="{{ route('destinations') }}" class="text-sm transition-colors duration-300 hover:text-white" style="color: rgba(255, 255, 255, 0.7);">
                                    {{ $tour }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider mb-4" style="color: #ff9729;">
                        Contact Us
                    </h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" style="color: #ff9729;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                            <a href="tel:+255623975934" class="text-sm" style="color: rgba(255, 255, 255, 0.7);">
                                +255 623 975 934
                            </a>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" style="color: #ff9729;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                            <span class="text-sm" style="color: rgba(255, 255, 255, 0.7);">
                                WhatsApp: +255 623 975 934
                            </span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" style="color: #ff9729;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <a href="mailto:info@tanzaniadailytours.com" class="text-sm" style="color: rgba(255, 255, 255, 0.7);">
                                info@tanzaniadailytours.com
                            </a>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" style="color: #ff9729; margin-top: 3px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            <span class="text-sm" style="color: rgba(255, 255, 255, 0.7);">
                                Tanzania, East Africa
                            </span>
                        </li>
                    </ul>

                    <!-- Social Icons -->
                    <div class="flex items-center gap-4 mt-6">
                        <a href="https://www.instagram.com/tanzania_dailytours_and_safari/" target="_blank" rel="noopener noreferrer" class="transition-opacity duration-300 hover:opacity-70" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" color="#ffffff" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                            </svg>
                        </a>
                        <a href="#" class="transition-opacity duration-300 hover:opacity-70" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" color="#ffffff" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                            </svg>
                        </a>
                        <a href="#" class="transition-opacity duration-300 hover:opacity-70" aria-label="Twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" color="#ffffff" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t" style="border-color: rgba(255, 255, 255, 0.15);">
            <div class="max-w-[1280px] mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-xs" style="color: rgba(255, 255, 255, 0.6);">
                    &copy; {{ date('Y') }} Tanzania Daily Tours & Safari. All rights reserved.
                </p>
                <div class="flex items-center gap-4">
                    <a href="{{ route('terms') }}" class="text-xs transition-colors duration-300 hover:text-white" style="color: rgba(255, 255, 255, 0.6);">
                        Terms of Service
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/255623975934" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 left-6 z-50 w-16 h-16 rounded-full flex items-center justify-center shadow-lg transition-all hover:scale-110" style="background: #25D366;">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.488-.492-.67-.5-.173-.01-.372-.01-.572-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>
    </a>

    <script>
        // Smooth scroll
        let lenis;
        let nav, navLogo, navTitle, hamburger1, hamburger2, hamburger3;
        
        function updateNav() {
            if (!nav) return;
            const scrolled = window.scrollY > window.innerHeight * 0.5;
            
            if (scrolled) {
                nav.style.background = 'rgba(255, 255, 255, 0.92)';
                nav.style.backdropFilter = 'blur(12px)';
                nav.style.borderBottom = '1px solid rgba(133, 66, 8, 0.08)';
                
                navLogo.src = "https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-brown_d1vgxe.png";
                navTitle.style.color = '#854208';
                
                hamburger1.style.background = '#854208';
                hamburger2.style.background = '#854208';
                hamburger3.style.background = '#854208';
                
                // Update desktop nav links color
                const desktopLinks = nav.querySelectorAll('a');
                desktopLinks.forEach(link => {
                    if (!link.style.background || link.style.background === 'transparent') {
                        link.style.color = '#111111';
                    }
                });
            } else {
                nav.style.background = 'transparent';
                nav.style.backdropFilter = 'none';
                nav.style.borderBottom = '1px solid transparent';
                
                navLogo.src = "https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/safari-logo-white_bexcal.png";
                navTitle.style.color = '#ffffff';
                
                hamburger1.style.background = '#ffffff';
                hamburger2.style.background = '#ffffff';
                hamburger3.style.background = '#ffffff';
                
                // Update desktop nav links color
                const desktopLinks = nav.querySelectorAll('a');
                desktopLinks.forEach(link => {
                    if (!link.style.background || link.style.background === 'transparent') {
                        link.style.color = '#ffffff';
                    }
                });
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Loading screen
            const loadingScreen = document.getElementById('loadingScreen');
            
            if (loadingScreen) {
                // Check if splash screen has been shown before
                const hasSeenSplash = localStorage.getItem('hasSeenSplash');
                
                if (hasSeenSplash) {
                    // Hide immediately if already seen
                    loadingScreen.style.opacity = '0';
                    loadingScreen.style.display = 'none';
                } else {
                    // Show splash screen and set flag
                    setTimeout(function() {
                        loadingScreen.style.opacity = '0';
                        setTimeout(function() {
                            loadingScreen.style.display = 'none';
                            localStorage.setItem('hasSeenSplash', 'true');
                        }, 500);
                    }, 5000);
                }
            }
            
            // Page transition animation
            const pageContent = document.getElementById('pageContent');
            setTimeout(function() {
                pageContent.style.opacity = '1';
                pageContent.style.transform = 'translateY(0)';
            }, 100);
            
            // Scroll to top on page load
            window.scrollTo(0, 0);
            
            // Initialize Lenis for smooth scrolling
            lenis = new Lenis({
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                smoothWheel: true
            });
            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);
            
            // Navbar setup
            nav = document.getElementById('mainNav');
            navLogo = document.getElementById('navLogo');
            navTitle = document.getElementById('navTitle');
            hamburger1 = document.getElementById('hamburger1');
            hamburger2 = document.getElementById('hamburger2');
            hamburger3 = document.getElementById('hamburger3');
            
            // Listen to scroll
            lenis.on('scroll', updateNav);
            window.addEventListener('scroll', updateNav);
            updateNav();
        });

        // Mobile menu
        let mobileOpen = false;
        function toggleMobileMenu() {
            mobileOpen = !mobileOpen;
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileOpen) {
                mobileMenu.classList.remove('hidden');
                hamburger1.style.transform = 'rotate(45deg) translate(4px, 4px)';
                hamburger2.style.opacity = '0';
                hamburger3.style.transform = 'rotate(-45deg) translate(4px, -4px)';
                document.body.style.overflow = 'hidden';
            } else {
                mobileMenu.classList.add('hidden');
                hamburger1.style.transform = 'none';
                hamburger2.style.opacity = '1';
                hamburger3.style.transform = 'none';
                document.body.style.overflow = '';
            }
        }
        function closeMobileMenu() {
            mobileOpen = false;
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.add('hidden');
            hamburger1.style.transform = 'none';
            hamburger2.style.opacity = '1';
            hamburger3.style.transform = 'none';
            document.body.style.overflow = '';
        }
        document.getElementById('mobileMenuBtn').addEventListener('click', toggleMobileMenu);
    </script>
    @yield('scripts')

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/6a452b6d59a11c1d46cc69ff/1jsf339th';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
</body>
</html>
