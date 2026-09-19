@extends('layouts.app')

@section('title', 'Tanzania Daily Tours & Safari — Discover Tanzania')
@section('meta_title', 'Tanzania Daily Tours & Safari — Discover Tanzania')
@section('meta_description', 'Tanzania Daily Tours & Safari — day trips, multi-day wildlife safaris, Kilimanjaro hikes, cultural tours and Zanzibar escapes. Expert local guides, private 4x4 safaris, transparent pricing.')
@section('meta_keywords', 'Tanzania safari, day tours, Serengeti, Ngorongoro, Kilimanjaro, Materuni, Chemka, Marangu, Zanzibar, Tanzania tours')

@php
    $offerTours = \App\Support\SafariContent::buildTours(
        $tours ?? \App\Models\Destination::where('status', 'Published')->get()
    );
    $offerItems = collect($offerTours)
        ->filter(function ($t) { return $t['id'] !== 'custom-safari'; })
        ->values()
        ->map(function ($t) {
            $item = [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'TouristTrip',
                    'name' => $t['title'],
                    'description' => mb_substr($t['overview'], 0, 120),
                    'image' => $t['image'],
                ],
                'priceCurrency' => 'USD',
            ];
            if ($t['price'] > 0) { $item['price'] = (string) $t['price']; }
            return $item;
        })
        ->all();
    $travelAgencySchema = [
        '@context' => 'https://schema.org',
        '@type' => 'TravelAgency',
        'name' => 'Tanzania Daily Tours & Safari',
        'url' => 'https://www.tanzaniadailytoursandsafari.com',
        'telephone' => '+255623975934',
        'email' => 'info.tanzaniadailytours@gmail.com',
        'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1200/v1782890323/safari-serengeti_agwjrp.jpg',
        'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Moshi', 'addressCountry' => 'TZ'],
        'sameAs' => [
            'https://www.instagram.com/tanzania_dailytours_and_safari/',
            'https://www.facebook.com/tanzaniadailytoursandsafari',
            'https://twitter.com/tanzaniadailytours',
            'https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html',
        ],
        'description' => 'Day trips, multi-day safaris, Kilimanjaro hikes and Zanzibar escapes in Tanzania.',
        'hasOfferCatalog' => [
            '@type' => 'OfferCatalog',
            'name' => 'Tanzania Tours & Safaris',
            'itemListElement' => $offerItems,
        ],
    ];
@endphp

@section('structured_data')
<script type="application/ld+json">
{!! json_encode($travelAgencySchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- HERO -->
<section class="hero" id="hero" aria-label="Featured Tanzania experiences">
  <div class="hero-slides" id="heroSlides"></div>

  <div class="hero-ring" aria-hidden="true"></div>
  <div class="hero-vertical" aria-hidden="true">TANZANIA • EAST AFRICA</div>
  <div class="hero-big-num" aria-hidden="true">01</div>
  <div class="hero-coords" aria-hidden="true">3.3869° S · 36.6830° E</div>

  <div class="container hero-inner">
    <div class="hero-eyebrow">TANZANIA • EAST AFRICA</div>
    <h1 id="heroTitle">DISCOVER<br /><em>TANZANIA.</em></h1>
    <div class="hero-sub" id="heroSub">SAFARIS. ADVENTURES. MEMORIES THAT LAST.</div>
    <p class="hero-copy" id="heroCopy">Experience Tanzania through unforgettable wildlife safaris, cultural adventures, mountain journeys and coastal escapes.</p>
    <div class="hero-actions">
      <a href="#tours" class="btn btn-accent">EXPLORE TOURS</a>
      <button class="btn btn-outline" data-booking="true">PLAN YOUR SAFARI</button>
    </div>
  </div>

  <div class="scroll-cue" aria-hidden="true"><span></span>Scroll</div>

  <div class="hero-controls">
    <div class="hero-dots" role="tablist" aria-label="Hero slides">
      @php($heroSlideCount = count(\App\Support\SafariContent::hero()))
      @for($i = 0; $i < $heroSlideCount; $i++)
        <button class="{{ $i === 0 ? 'active' : '' }}" role="tab" aria-selected="{{ $i === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $i + 1 }}" data-go="{{ $i }}"></button>
      @endfor
    </div>
    <div class="hero-counter"><b id="heroCurrent">01</b> / {{ str_pad($heroSlideCount, 2, '0', STR_PAD_LEFT) }}</div>
    <div class="hero-arrows">
      <button id="heroPrev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
      <button id="heroNext" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
    </div>
  </div>
</section>

<!-- TOUR FINDER -->
<div class="tour-finder" id="finder">
  <div class="finder-card">
    <div class="finder-title"><i class="fas fa-compass"></i> FIND YOUR TANZANIA EXPERIENCE</div>
    <div class="field">
      <label for="fDest">Destination</label>
      <select id="fDest">
        <option>Tanzania (All)</option>
        <option>Serengeti</option>
        <option>Ngorongoro</option>
        <option>Tarangire</option>
        <option>Lake Manyara</option>
        <option>Kilimanjaro</option>
        <option>Arusha</option>
        <option>Moshi</option>
        <option>Zanzibar</option>
      </select>
    </div>
    <div class="field">
      <label for="fType">Tour Type</label>
      <select id="fType">
        <option>Any Experience</option>
        <option>Safari</option>
        <option>Day Trip</option>
        <option>Cultural</option>
        <option>Kilimanjaro</option>
        <option>Beach</option>
      </select>
    </div>
    <div class="field">
      <label for="fDur">Duration</label>
      <select id="fDur">
        <option>Any Duration</option>
        <option>1 Day</option>
        <option>2–3 Days</option>
        <option>4–7 Days</option>
        <option>8+ Days</option>
      </select>
    </div>
    <div class="field">
      <label for="fTrav">Travelers</label>
      <select id="fTrav">
        <option>2 Adults</option>
        <option>1 Adult</option>
        <option>Family</option>
        <option>Group (4+)</option>
      </select>
    </div>
    <button class="btn btn-primary" id="finderBtn">FIND MY TOUR</button>
  </div>
</div>

<!-- INTRO -->
<section class="intro section-lg" id="about">
  <div class="container">
    <div class="intro-text reveal-left">
      <span class="intro-big-num" aria-hidden="true">01</span>
      <div class="eyebrow">THE TANZANIA DAILY STORY</div>
      <h2 class="display-lg">TANZANIA,<br /><em>BEYOND EXPECTATIONS.</em></h2>
      <p>Tanzania Daily Tours & Safari offers experiences that range from single unforgettable day trips to fully guided multi-day wildlife safaris. From the Materuni waterfall and the warm waters of Chemka, to the Ngorongoro Crater and the endless Serengeti plains — we design journeys that stay with you long after you leave.</p>
      <p>Our local guides are born and based in Tanzania, so every route, viewpoint and cultural encounter is delivered with genuine insight.</p>
      <a href="{{ route('about') }}" class="btn btn-primary">DISCOVER OUR STORY</a>
    </div>
    <div class="intro-imgs reveal-right">
      <img class="intro-img-main" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['pxClark'], 800) }}" alt="Campfire evening under the Tanzania sky" loading="lazy" />
      <img class="intro-img-sub" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['pxNing'], 600) }}" alt="Serengeti dawn" loading="lazy" />
      <div class="intro-deco" aria-hidden="true"></div>
      <div class="intro-badge">15+ Years<small>Local Expertise</small></div>
    </div>
  </div>
</section>

<!-- CATEGORIES -->
<section class="categories" id="categories">
  <div class="container">
    <div class="section-head light reveal">
      <div class="eyebrow eyebrow-light">CHOOSE YOUR ADVENTURE</div>
      <h2 class="display-lg light">EXPLORE BY CATEGORY</h2>
      <p>Six ways to experience Tanzania — from a single day to a once-in-a-lifetime journey.</p>
    </div>
    <div class="cat-grid">
      <article class="cat-card reveal-scale" data-filter="safari">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['catMultiDay'], 900) }}" alt="Multi-day safari" loading="lazy" />
        <div class="cat-overlay">
          <div class="cat-num">01</div>
          <h3>MULTI-DAY SAFARIS</h3>
          <p>3, 4, 5, 7 & 10+ day journeys through the northern circuit.</p>
          <span class="cat-link">VIEW SAFARIS <i class="fas fa-arrow-right"></i></span>
        </div>
      </article>
      <article class="cat-card reveal-scale" data-filter="day-trip">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['catDayTrip'], 700) }}" alt="Day trip adventure" loading="lazy" />
        <div class="cat-overlay">
          <div class="cat-num">02</div>
          <h3>DAY TRIPS</h3>
          <p>Waterfalls, hot springs and cultural tours from Moshi or Arusha.</p>
          <span class="cat-link">VIEW DAY TRIPS <i class="fas fa-arrow-right"></i></span>
        </div>
      </article>
      <article class="cat-card reveal-scale" data-filter="kilimanjaro">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariKilimanjaro'], 700) }}" alt="Kilimanjaro" loading="lazy" />
        <div class="cat-overlay">
          <div class="cat-num">03</div>
          <h3>KILIMANJARO</h3>
          <p>Day hikes and full summit expeditions on Africa's highest peak.</p>
          <span class="cat-link">EXPLORE KILIMANJARO <i class="fas fa-arrow-right"></i></span>
        </div>
      </article>
      <article class="cat-card reveal-scale" data-filter="cultural">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['catCultural'], 700) }}" alt="Maasai culture" loading="lazy" />
        <div class="cat-overlay">
          <div class="cat-num">04</div>
          <h3>CULTURAL TOURS</h3>
          <p>Chagga and Maasai communities, coffee farms and village life.</p>
          <span class="cat-link">DISCOVER CULTURE <i class="fas fa-arrow-right"></i></span>
        </div>
      </article>
      <article class="cat-card reveal-scale" data-filter="beach">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['zanzibarBeach'], 700) }}" alt="Zanzibar" loading="lazy" />
        <div class="cat-overlay">
          <div class="cat-num">05</div>
          <h3>ZANZIBAR</h3>
          <p>Beach escapes, Stone Town, spice tours and snorkelling.</p>
          <span class="cat-link">DISCOVER ZANZIBAR <i class="fas fa-arrow-right"></i></span>
        </div>
      </article>
      <article class="cat-card reveal-scale" data-filter="custom">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['catCustom'], 700) }}" alt="Custom safari" loading="lazy" />
        <div class="cat-overlay">
          <div class="cat-num">06</div>
          <h3>CUSTOM SAFARIS</h3>
          <p>Tell us your dream and we'll design the perfect Tanzania itinerary.</p>
          <span class="cat-link">BUILD MY SAFARI <i class="fas fa-arrow-right"></i></span>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- TOURS -->
<section class="tours-section section-lg" id="tours">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">OUR TOURS & SAFARIS</div>
      <h2 class="display-lg">DAY TRIPS & SAFARIS</h2>
      <p>Complete, transparent itineraries — from a single day at Materuni to a multi-day Serengeti safari.</p>
    </div>

    <div class="filter-bar reveal">
      <div class="filter-tabs" role="tablist">
        <button class="active" data-filter="all">All Tours</button>
        <button data-filter="day-trip">Day Trips</button>
        <button data-filter="safari">Safaris</button>
        <button data-filter="kilimanjaro">Kilimanjaro</button>
        <button data-filter="cultural">Cultural</button>
        <button data-filter="beach">Beach</button>
      </div>
      <div class="sort-select">
        <label for="sortSel">Sort:</label>
        <select id="sortSel">
          <option value="popular">Popular</option>
          <option value="price-asc">Price: Low → High</option>
          <option value="price-desc">Price: High → Low</option>
          <option value="duration">Duration</option>
        </select>
      </div>
    </div>

    <div class="tours-grid" id="toursGrid" data-limit="6"></div>
    <div class="tours-more">
      <a class="btn btn-primary" href="{{ route('destinations') }}">EXPLORE MORE TOURS <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- DESTINATIONS -->
<section class="destinations" id="destinations">
  <div class="container">
    <div class="section-head light reveal">
      <div class="eyebrow eyebrow-light">WHERE TO GO</div>
      <h2 class="display-lg light">ICONIC DESTINATIONS</h2>
      <p>From the endless plains of the Serengeti to the spice-scented shores of Zanzibar.</p>
    </div>
    <div class="dest-grid">
      <a class="dest-card reveal-scale" data-dest="Serengeti" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariSerengeti'], 1000) }}" alt="Serengeti National Park" loading="lazy" />
        <div class="dest-overlay">
          <h3>SERENGETI</h3>
          <div class="dest-stats">14,750 km² • Great Migration</div>
          <span class="dest-link">EXPLORE DESTINATION <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Ngorongoro" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariNgorongoro'], 700) }}" alt="Ngorongoro Crater" loading="lazy" />
        <div class="dest-overlay">
          <h3>NGORONGORO</h3>
          <div class="dest-stats">UNESCO • Big Five</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Tarangire" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['galleryWildlife2'], 700) }}" alt="Tarangire elephants" loading="lazy" />
        <div class="dest-overlay">
          <h3>TARANGIRE</h3>
          <div class="dest-stats">Elephants • Baobabs</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Kilimanjaro" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariKilimanjaro'], 700) }}" alt="Kilimanjaro" loading="lazy" />
        <div class="dest-overlay">
          <h3>KILIMANJARO</h3>
          <div class="dest-stats">5,895 m • Roof of Africa</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Arusha" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['tourArusha'], 700) }}" alt="Arusha" loading="lazy" />
        <div class="dest-overlay">
          <h3>ARUSHA</h3>
          <div class="dest-stats">Gateway to the North</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Zanzibar" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['zanzibarBeach'], 700) }}" alt="Zanzibar" loading="lazy" />
        <div class="dest-overlay">
          <h3>ZANZIBAR</h3>
          <div class="dest-stats">Spice Island • Beaches</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Lake Manyara" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['aboutHero'], 700) }}" alt="Lake Manyara" loading="lazy" />
        <div class="dest-overlay">
          <h3>LAKE MANYARA</h3>
          <div class="dest-stats">Tree-climbing lions</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
      <a class="dest-card reveal-scale" data-dest="Nyerere" href="{{ route('destinations') }}">
        <img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['galleryLandscape2'], 700) }}" alt="Nyerere National Park" loading="lazy" />
        <div class="dest-overlay">
          <h3>NYERERE</h3>
          <div class="dest-stats">Wild & Remote</div>
          <span class="dest-link">EXPLORE <i class="fas fa-arrow-right"></i></span>
        </div>
      </a>
    </div>
  </div>
</section>

<!-- WHY US -->
<section class="why" id="why">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">WHY BOOK WITH US</div>
      <h2 class="display-lg">THE TANZANIA DAILY DIFFERENCE</h2>
    </div>
    <div class="why-grid">
      <div class="why-item reveal">
        <div class="why-icon"><i class="fas fa-truck-monster"></i></div>
        <h4>Private 4x4 Safaris</h4>
        <p>Custom safari vehicles with pop-up roofs, large windows and guaranteed window seats for every guest.</p>
      </div>
      <div class="why-item reveal">
        <div class="why-icon"><i class="fas fa-user-tie"></i></div>
        <h4>Expert Local Guides</h4>
        <p>Born and based in Tanzania, our guides know every route, watering hole and cultural encounter.</p>
      </div>
      <div class="why-item reveal">
        <div class="why-icon"><i class="fas fa-tag"></i></div>
        <h4>Transparent Pricing</h4>
        <p>Clear inclusions, exclusions and pricing. No hidden fees — what you see is what you pay.</p>
      </div>
      <div class="why-item reveal">
        <div class="why-icon"><i class="fas fa-calendar-check"></i></div>
        <h4>Flexible Booking</h4>
        <p>Free date changes on most bookings. We work around your travel plans, not the other way around.</p>
      </div>
      <div class="why-item reveal">
        <div class="why-icon"><i class="fas fa-headset"></i></div>
        <h4>Local Support</h4>
        <p>Real people, based in Tanzania, ready to help before, during and after your journey.</p>
      </div>
      <div class="why-item reveal">
        <div class="why-icon"><i class="fas fa-clock"></i></div>
        <h4>24/7 On-Ground Assistance</h4>
        <p>From arrival to departure, our team is only a phone call away — day or night.</p>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats">
  <div class="container">
    <div class="stats-grid">
      <div class="stat reveal">
        <span class="stat-num" data-count="15">0</span>
        <div class="stat-label">Years Experience</div>
        <div class="stat-note">Local operator</div>
      </div>
      <div class="stat reveal">
        <span class="stat-num" data-count="10000" data-suffix="+">0</span>
        <div class="stat-label">Happy Travelers</div>
        <div class="stat-note">Since 2009</div>
      </div>
      <div class="stat reveal">
        <span class="stat-num" data-count="50" data-suffix="+">0</span>
        <div class="stat-label">Expert Guides</div>
        <div class="stat-note">Across Tanzania</div>
      </div>
      <div class="stat reveal">
        <span class="stat-num" data-count="100" data-suffix="%">0</span>
        <div class="stat-label">Satisfaction</div>
        <div class="stat-note">Guest feedback</div>
      </div>
    </div>
  </div>
</section>

<!-- KILIMANJARO -->
<section class="kili" id="kilimanjaro">
  <img class="bg" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariKilimanjaro'], 1800) }}" alt="Mount Kilimanjaro" loading="lazy" />
  <div class="kili-overlay"></div>
  <div class="container">
    <div class="kili-content reveal-left">
      <div class="kili-label">MOUNT KILIMANJARO • 5,895 M</div>
      <h2>CONQUER<br /><em>AFRICA'S ROOF.</em></h2>
      <p>From a single-day hike to Mandara Hut on the Marangu Route, to a full Machame summit expedition — we'll help you prepare, acclimatise and reach the top safely.</p>
      <div class="kili-features">
        <span><i class="fas fa-check"></i> Marangu Day Hike</span>
        <span><i class="fas fa-check"></i> Machame Route</span>
        <span><i class="fas fa-check"></i> Expert Mountain Crews</span>
        <span><i class="fas fa-check"></i> Full Gear Support</span>
      </div>
      <a class="btn btn-accent" href="{{ route('destination.detail', 'kilimanjaro-day-hike') }}">EXPLORE KILIMANJARO</a>
    </div>
  </div>
</section>

<!-- ZANZIBAR -->
<section class="zanzibar" id="zanzibar">
  <div class="container">
    <div class="zanzibar-imgs reveal-left">
    <img class="zanzibar-img-sub" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['pxKeegan'], 600) }}" alt="From safari to sea — game viewing on the way to the coast" loading="lazy" />  
    <img class="zanzibar-img-main" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['zanzibarMain'], 800) }}" alt="Zanzibar beach" loading="lazy" />
    </div>
    <div class="zanzibar-text reveal-right">
      <div class="eyebrow">ZANZIBAR ESCAPES</div>
      <h2 class="display-lg">FROM SAVANNAH<br /><em>TO SEA.</em></h2>
      <p>After the plains and the crater, unwind on Zanzibar's powder-white beaches. Explore historic Stone Town, tour spice farms, snorkel the reefs and watch the sunset from a traditional dhow.</p>
      <div class="zanzibar-list">
        <span>Stone Town</span>
        <span>Spice Tours</span>
        <span>Snorkelling</span>
        <span>Sunset Dhow</span>
        <span>Beach Resorts</span>
      </div>
      <a class="btn btn-primary" href="{{ route('destination.detail', 'zanzibar-escape') }}">DISCOVER ZANZIBAR</a>
    </div>
  </div>
</section>

<!-- CUSTOM CTA -->
<section class="custom-cta">
  <div class="container">
    <div class="reveal-scale">
      <div class="eyebrow eyebrow-light" style="justify-content:center;display:inline-flex;margin-bottom:18px">TAILOR-MADE JOURNEYS</div>
      <h2>YOUR TANZANIA.<br /><em>YOUR WAY.</em></h2>
      <p>Tell us what you want to experience and our safari experts will help design a journey around your time, interests and travel style.</p>
      <div class="custom-actions">
        <button class="btn btn-accent" data-custom="true">BUILD MY SAFARI</button>
        <button class="btn btn-outline" data-booking="true">TALK TO AN EXPERT</button>
      </div>
    </div>
  </div>
</section>

<!-- TRAVEL GUIDE -->
<section class="guide" id="guide">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">PLAN YOUR JOURNEY</div>
      <h2 class="display-lg">TRAVEL GUIDE</h2>
      <p>Everything you need to know before you travel to Tanzania.</p>
    </div>
    <div class="guide-grid">
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['clipC6'], 600) }}" alt="Best time to visit Tanzania" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Planning</div>
          <h4>Best Time to Visit Tanzania</h4>
          <p>Understand the dry and green seasons, the Great Migration timing and the best months for each park.</p>
          <div class="guide-foot"><span>12 Jan 2026</span><a href="{{ route('travel-guide') }}#guide-best-time">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['tourArusha'], 600) }}" alt="What to pack for a safari" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Tips</div>
          <h4>What to Pack for a Safari</h4>
          <p>Neutral layers, binoculars, a good camera, and the small essentials that make a big difference.</p>
          <div class="guide-foot"><span>08 Jan 2026</span><a href="{{ route('travel-guide') }}#guide-packing">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariNgorongoro'], 600) }}" alt="Tanzania safari cost guide" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Budget</div>
          <h4>Tanzania Safari Cost Guide</h4>
          <p>What affects safari pricing, how to compare quotes, and where you can save without missing out.</p>
          <div class="guide-foot"><span>04 Jan 2026</span><a href="{{ route('travel-guide') }}#guide-costs">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['galleryWildlife2'], 600) }}" alt="Serengeti travel guide" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Destinations</div>
          <h4>Serengeti Travel Guide</h4>
          <p>Regions, seasons and where to stay for the best wildlife viewing across the Serengeti.</p>
          <div class="guide-foot"><span>28 Dec 2025</span><a href="{{ route('travel-guide') }}#guide-entry">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['galleryLandscape2'], 600) }}" alt="Ngorongoro travel guide" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Destinations</div>
          <h4>Ngorongoro Travel Guide</h4>
          <p>Inside the crater — wildlife, best times, and how to combine it with Tarangire and the Serengeti.</p>
          <div class="guide-foot"><span>20 Dec 2025</span><a href="{{ route('travel-guide') }}#guide-safety">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariKilimanjaro'], 600) }}" alt="Kilimanjaro preparation" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Adventure</div>
          <h4>Kilimanjaro Preparation Guide</h4>
          <p>Routes, training, gear and acclimatisation — how to give yourself the best summit chance.</p>
          <div class="guide-foot"><span>15 Dec 2025</span><a href="{{ route('travel-guide') }}#guide-kilimanjaro">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section class="gallery" id="gallery">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">VISUAL JOURNEY</div>
      <h2 class="display-lg">GALLERY</h2>
    </div>
    <div class="gal-filters" role="tablist">
      <button class="active" data-gal="all">All</button>
      <button data-gal="wildlife">Wildlife</button>
      <button data-gal="landscapes">Landscapes</button>
      <button data-gal="safaris">Safaris</button>
      <button data-gal="kilimanjaro">Kilimanjaro</button>
      <button data-gal="culture">Culture</button>
      <button data-gal="zanzibar">Zanzibar</button>
    </div>
    <div class="gal-grid" id="galGrid"></div>
  </div>
</section>

<!-- REVIEWS -->
<section class="reviews" id="reviews">
  <div class="container">
    <div class="section-head light reveal">
      <div class="eyebrow eyebrow-light">TRAVELER STORIES</div>
      <h2 class="display-lg light">WHAT OUR GUESTS SAY</h2>
    </div>
    <div class="reviews-slider" id="reviewsSlider"></div>
    <div class="review-dots" id="revDots" role="tablist" aria-label="Reviews"></div>
    <div class="review-nav">
      <button id="revPrev" aria-label="Previous review"><i class="fas fa-chevron-left"></i></button>
      <button id="revNext" aria-label="Next review"><i class="fas fa-chevron-right"></i></button>
    </div>
    <p class="review-note" id="reviewsNote">Trusted by travelers worldwide.</p>
  </div>
</section>

<!-- BOOKING CTA -->
<section class="booking-cta" id="contact">
  <div class="container">
    <div class="reveal-scale">
      <h2>READY FOR TANZANIA?</h2>
      <p>From a single unforgettable day to a once-in-a-lifetime safari, your journey starts here.</p>
      <div class="booking-actions">
        <button class="btn btn-primary" data-booking="true">BOOK A TRIP</button>
        <a href="mailto:info.tanzaniadailytours@gmail.com" class="btn btn-outline-dark">CONTACT US</a>
        <a href="https://wa.me/255623975934" target="_blank" rel="noopener" class="btn btn-outline-dark"><i class="fab fa-whatsapp"></i> WHATSAPP US</a>
      </div>
    </div>
  </div>
</section>

<!-- TRUST / PARTNERS -->
<section class="trust-strip" aria-label="Certifications and partners">
  <img class="trust-bg" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['pxKeegan'], 1600) }}" alt="" aria-hidden="true" loading="lazy" />
  <div class="container">
    <div class="trust-grid">
      <div class="trust-note">
        <em>BACKED BY REAL ADVENTURES</em>
        Rated by travelers and committed to responsible tourism.
      </div>
      <div class="trust-certs">
        <a href="https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html" target="_blank" rel="noopener noreferrer" aria-label="Rated on TripAdvisor">
          <img class="tripadvisor" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['tripadvisor'], 100) }}" alt="TripAdvisor" loading="lazy" />
          <span>Rated on TripAdvisor</span>
        </a>
        <a href="#" aria-label="Sustainable Association Partners">
          <img class="partner" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['sustainable'], 640) }}" alt="Sustainable Association Partners" loading="lazy" />
        </a>
      </div>
    </div>
  </div>
</section>

<!-- NEWSLETTER -->
<section class="newsletter">
  <div class="container">
    <div class="reveal">
      <h2>TANZANIA TRAVEL STORIES,<br />STRAIGHT TO YOUR INBOX.</h2>
      <p>Safari inspiration, travel tips and seasonal offers — a few times a year, never spam.</p>
      <form class="newsletter-form" id="newsletterForm" novalidate>
        <label for="nlEmail" class="sr-only">Email address</label>
        <input type="email" id="nlEmail" placeholder="Your email address" required />
        <button type="submit" class="btn btn-primary">SUBSCRIBE</button>
      </form>
      <p class="privacy-note">We respect your privacy. Unsubscribe at any time.</p>
    </div>
  </div>
</section>

@endsection