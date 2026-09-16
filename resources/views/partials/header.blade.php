@php
    $isHome = Route::currentRouteName() === 'home';
    $homeHref = $isHome ? '#hero' : route('home');
    $toursHref = $isHome ? '#tours' : route('tours.index');
    $safariHref = $isHome ? '#tours' : route('safaris');
    $destHref = $isHome ? '#destinations' : route('destinations');
    $aboutHref = $isHome ? '#about' : route('about');
    $reviewsHref = $isHome ? '#reviews' : route('reviews');
    $galleryHref = $isHome ? '#gallery' : route('gallery');
    $guideHref = $isHome ? '#guide' : route('travel-guide');
    $travelers = ['2 Adults', '1 Adult', 'Family', 'Group (4+)'];
    $brand = \App\Support\SafariContent::site();
    $logoWhite = (isset($contents) && !empty($contents['logo_white']->value ?? null)) ? $contents['logo_white']->value : $brand['logos']['white'];
    $brandTag = trim((string)($brand['tagline'] ?? ''));
    if ($brandTag !== '' && stripos($brand['name'], $brandTag) !== false) {
        $brandTop = trim(str_ireplace($brandTag, '', $brand['name']));
        $brandBottom = $brandTag;
    } else {
        $brandTop = $brand['name'];
        $brandBottom = $brandTag;
    }
@endphp

<!-- MAIN NAV -->
<header class="main-nav" id="mainNav">
  <div class="container">
    <a href="{{ $homeHref }}" class="logo logo-wrap" aria-label="Tanzania Daily Tours & Safari home">
      <img class="logo-img" src="{{ $logoWhite }}" alt="Tanzania Daily Tours & Safari" width="48" height="46" fetchpriority="high" />
      <span class="logo-text">
        <span class="logo-top">{{ $brandTop }}</span>
        <span class="logo-bottom">{{ $brandBottom }}</span>
      </span>
    </a>

    <nav aria-label="Main navigation">
      <ul class="nav-links">
        <li><a href="{{ $homeHref }}" class="{{ $isHome ? 'active' : '' }}">HOME</a></li>
        <li>
          <a href="{{ $toursHref }}" {{ $isHome ? 'data-spy="tours"' : '' }} aria-haspopup="true">TOURS <i class="fas fa-chevron-down"></i></a>
          <div class="mega-menu">
            <div class="mega-list">
              <h5>Tour Categories</h5>
              <ul>
                <li><a href="{{ route('tours.category', 'day-trips') }}">Day Trips</a></li>
                <li><a href="{{ route('tours.category', 'multi-day-safaris') }}">Multi-Day Safaris</a></li>
                <li><a href="{{ route('tours.category', 'cultural-tours') }}">Cultural Tours</a></li>
                <li><a href="{{ route('tours.category', 'kilimanjaro-trips') }}">Kilimanjaro Trips</a></li>
                <li><a href="{{ route('tours.category', 'beach-experiences') }}">Beach Experiences</a></li>
                <li><a href="{{ route('tours.category', 'custom-safaris') }}">Custom Safaris</a></li>
              </ul>
            </div>
            <div class="mega-feature">
              <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_600/v1782890323/safari-serengeti_agwjrp.jpg" alt="Serengeti safari" loading="lazy" />
              <h6>Featured</h6>
              <p>Serengeti & Ngorongoro Safari</p>
            </div>
          </div>
        </li>
        <li>
          <a href="{{ $safariHref }}" {{ $isHome ? 'data-spy="tours"' : '' }} aria-haspopup="true">SAFARIS <i class="fas fa-chevron-down"></i></a>
          <div class="mega-menu">
            <div class="mega-list">
              <h5>Safari Styles</h5>
              <ul>
                <li><a href="{{ route('safaris.style', 'budget') }}">Budget Safaris</a></li>
                <li><a href="{{ route('safaris.style', 'mid-range') }}">Mid-Range Safaris</a></li>
                <li><a href="{{ route('safaris.style', 'luxury') }}">Luxury Safaris</a></li>
                <li><a href="{{ route('safaris.style', 'private') }}">Private Safaris</a></li>
                <li><a href="{{ route('safaris.style', 'family') }}">Family Safaris</a></li>
                <li><a href="{{ route('safaris.style', 'honeymoon') }}">Honeymoon Safaris</a></li>
              </ul>
            </div>
            <div class="mega-feature">
              <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_600/v1782890323/safari-ngorongoro_j04gqg.jpg" alt="Great migration" loading="lazy" />
              <h6>Popular</h6>
              <p>Great Migration Safari</p>
            </div>
          </div>
        </li>
        <li>
          <a href="{{ $destHref }}" {{ $isHome ? 'data-spy="destinations"' : '' }}>DESTINATIONS</a>
        </li>
        <li><a href="{{ $aboutHref }}" {{ $isHome ? 'data-spy="about"' : '' }}>ABOUT</a></li>
        <li><a href="{{ $reviewsHref }}" {{ $isHome ? 'data-spy="reviews"' : '' }}>REVIEWS</a></li>
        <li><a href="{{ $galleryHref }}" {{ $isHome ? 'data-spy="gallery"' : '' }}>GALLERY</a></li>
        <li><a href="{{ route('contact') }}">CONTACT</a></li>
        <li><a href="{{ $guideHref }}" {{ $isHome ? 'data-spy="guide"' : '' }}>TRAVEL GUIDE</a></li>
      </ul>
    </nav>

    <div class="nav-cta">
      <button class="btn btn-outline btn-sm" id="searchBtn" aria-label="Search tours" style="padding:10px 13px;min-height:40px"><i class="fas fa-search"></i></button>
      <button class="btn btn-accent" data-booking="true">BOOK A TRIP</button>
      <button class="menu-btn" id="menuBtn" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>
    </div>
  </div>
</header>

<!-- MOBILE NAV -->
<nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation">
  <button class="mobile-close" id="mobileClose" aria-label="Close menu">&times;</button>
  <div class="mobile-brand">{{ $brand['name'] }}</div>
  <a href="{{ route('home') }}">HOME</a>
  <a href="{{ route('tours.index') }}">TOURS</a>
  <a href="{{ route('safaris') }}">SAFARIS</a>
  <a href="{{ route('destinations') }}">DESTINATIONS</a>
  <a href="{{ route('about') }}">ABOUT</a>
  <a href="{{ route('reviews') }}">REVIEWS</a>
  <a href="{{ route('gallery') }}">GALLERY</a>
  <a href="{{ route('travel-guide') }}">TRAVEL GUIDE</a>
  <a href="{{ route('contact') }}">CONTACT</a>
  <button class="btn btn-accent" data-booking="true">BOOK A TRIP</button>
  <div class="mobile-contact">
    <a href="tel:+255623975934">+255 623 975 934</a><br />
    <a href="mailto:info.tanzaniadailytours@gmail.com">info.tanzaniadailytours@gmail.com</a>
  </div>
</nav>