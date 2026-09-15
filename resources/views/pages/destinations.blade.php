@extends('layouts.app')

@section('title', 'Tanzania Safari Destinations - Serengeti, Kilimanjaro, Zanzibar Tours')
@section('meta_title', 'Tanzania Safari Destinations - Serengeti, Kilimanjaro, Zanzibar Tours')
@section('meta_description', 'Explore our Tanzania safari destinations. Serengeti safaris, Kilimanjaro climbs, Zanzibar beaches, Ngorongoro crater, Tarangire park. Day trips & multi-day packages available.')
@section('meta_keywords', 'Tanzania destinations, Serengeti safari, Kilimanjaro tours, Zanzibar beaches, Ngorongoro crater, Tarangire safari, Tanzania national parks, safari destinations Tanzania')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890322/safari-kilimanjaro_rnqbaj.jpg')

@section('structured_data')
@php
    $collectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Tanzania Safari Destinations',
        'description' => 'Explore our Tanzania safari destinations including Serengeti, Kilimanjaro, Zanzibar, and more',
        'url' => url()->current(),
    ];
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'What are the best Tanzania safari destinations?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'The best Tanzania safari destinations include Serengeti National Park for the Great Migration, Ngorongoro Crater for wildlife density, Tarangire for elephants, Lake Manyara for tree-climbing lions, and Mount Kilimanjaro for trekking adventures.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How many days should I spend on safari in Tanzania?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We recommend 5-7 days for a comprehensive Tanzania safari experience. This allows you to visit 2-3 parks including Serengeti and Ngorongoro. Day trips are available for travelers with limited time.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What wildlife can I see in Tanzania?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Tanzania is home to the Big Five (lions, elephants, buffalo, leopards, rhinos), plus cheetahs, giraffes, zebras, wildebeest, hippos, crocodiles, and over 1,000 bird species. The Great Migration features millions of wildebeest and zebras.',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($collectionSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg" alt="Tanzania safari" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Destinations</span>
    </nav>
    <h1>{{ $contents['destinations_page_title']->value ?? 'OUR DESTINATIONS' }}</h1>
    <p class="hero-copy">Day trips, cultural experiences, Kilimanjaro adventures and multi-day wildlife safaris — complete, transparent itineraries.</p>
  </div>
</section>

<!-- TOURS -->
<section class="tours-section page-section" id="tours">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">OUR TOURS & SAFARIS</div>
      <h2 class="display-lg">DAY TRIPS & SAFARIS</h2>
      <p>From a single day at Materuni to a multi-day Serengeti safari — filtered by your travel style.</p>
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

    <div class="tours-grid" id="toursGrid"></div>
  </div>
</section>

<!-- CUSTOM CTA -->
<section class="custom-cta">
  <div class="container">
    <div class="reveal-scale">
      <div class="eyebrow eyebrow-light" style="justify-content:center;display:inline-flex;margin-bottom:18px">{{ $contents['destinations_cta_text']->value ?? 'TAILOR-MADE JOURNEYS' }}</div>
      <h2>YOUR TANZANIA.<br /><em>YOUR WAY.</em></h2>
      <p>{{ $contents['destinations_cta_button']->value ?? 'Tell us your dream and our safari experts will design the perfect itinerary.' }}</p>
      <div class="custom-actions">
        <button class="btn btn-accent" data-custom="true">BUILD MY SAFARI</button>
        <a href="{{ route('contact') }}" class="btn btn-outline">TALK TO AN EXPERT</a>
      </div>
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    try {
      var p = new URLSearchParams(window.location.search);
      var cat = p.get('cat');
      if (cat && window.__tdtsExt && window.__tdtsExt.setFilter) {
        window.__tdtsExt.setFilter(cat);
      }
    } catch (e) {}
  });
</script>
@endpush