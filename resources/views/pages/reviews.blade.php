@extends('layouts.app')

@section('title', 'Tanzania Safari Reviews - What Our Travelers Say')
@section('meta_title', 'Tanzania Safari Reviews - What Our Travelers Say')
@section('meta_description', 'Read genuine Tanzania safari reviews from our travelers. See why people choose us for Serengeti safaris, Kilimanjaro treks, and Moshi day trips.')
@section('meta_keywords', 'Tanzania safari reviews, Tanzania tour operator reviews, Serengeti safari reviews, Kilimanjaro climb reviews, Zanzibar tour reviews, customer testimonials Tanzania')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890322/safari-ngorongoro_j04gqg.jpg')

@section('structured_data')
@php
    $reviews = collect($testimonials ?? []);
    $reviewCount = $reviews->count();
    $avgRating = $reviewCount > 0 ? round($reviews->avg('rating'), 1) : 0;

    $mainEntity = [
        '@type' => 'TravelAgency',
        'name' => 'Tanzania Daily Tours & Safari',
    ];
    if ($reviewCount > 0) {
        $mainEntity['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $avgRating,
            'reviewCount' => (string) $reviewCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'ReviewPage',
        'name' => 'Tanzania Safari Reviews',
        'description' => 'Read genuine Tanzania safari reviews from our travelers',
        'url' => url()->current(),
        'mainEntity' => $mainEntity,
    ];
@endphp
<script type="application/ld+json">{!! json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890322/reviews-header_wnccc3.jpg" alt="Traveler reviews" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Reviews</span>
    </nav>
    <h1>{{ $contents['reviews_page_title']->value ?? 'TRAVELER REVIEWS' }}</h1>
    <p class="hero-copy">
      @for($i = 1; $i <= 5; $i++)
        <i class="fas fa-star" style="color:var(--accent);{{ $i <= round($avgRating) ? '' : 'opacity:.35' }}"></i>
      @endfor
      {{ $reviewCount > 0 ? number_format($avgRating, 1) : '—' }}
      <span style="color:rgba(255,255,255,.7);"> ({{ $reviewCount }} reviews)</span>
    </p>
  </div>
</section>

<!-- REVIEWS SLIDER -->
<section class="reviews page-section" id="reviews" style="padding-top:110px;">
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

<!-- REVIEW CTA + TRIPADVISOR -->
<section class="page-section alt" style="padding-top:70px;padding-bottom:90px;">
  <div class="container">
    <div class="page-detail-grid" style="grid-template-columns:1fr 1fr;gap:26px;">
      <div class="detail-card reveal">
        <h2><span class="mm">+</span>{{ $contents['reviews_cta_text']->value ?? 'Traveled with us? Share your experience!' }}</h2>
        <p style="color:var(--muted);margin-bottom:22px;">Your story helps other travelers discover Tanzania with confidence.</p>
        <a href="https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html" target="_blank" rel="noopener noreferrer" class="btn btn-primary">{{ $contents['reviews_cta_button']->value ?? 'Write a Review' }}</a>
      </div>
      <div class="detail-card reveal">
        <h2 style="display:flex;align-items:center;gap:10px;"><span class="mm">★</span>TripAdvisor</h2>
        <p style="color:var(--muted);margin-bottom:22px;">Share your experience on TripAdvisor and help travelers discover Tanzania with us.</p>
        <div id="TA_rated458" class="TA_rated">
          <ul id="OEQBtiJT1z9h" class="TA_links fjINTJ8nYkf" style="list-style:none;display:flex;gap:16px;align-items:center;">
            <li id="GLvFwnFD" class="0neu5M">
              <a target="_blank" href="https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html">
                <img src="https://www.tripadvisor.com/img/cdsi/img2/badges/ollie-11424-2.gif" alt="TripAdvisor" loading="lazy" />
              </a>
            </li>
          </ul>
        </div>
        <script async src="https://www.jscache.com/wejs?wtype=rated&uniq=458&locationId=34526433&lang=en_US&display_version=2" data-loadtrk onload="this.loadtrk=true"></script>
      </div>
    </div>
  </div>
</section>

@endsection