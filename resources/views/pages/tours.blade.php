@extends('layouts.app')

@section('title', $meta_title ?? 'Tanzania Tours & Safaris - Serengeti, Kilimanjaro, Zanzibar')
@section('meta_title', $meta_title ?? 'Tanzania Tours & Safaris - Tanzania Daily Tours & Safari')
@section('meta_description', $meta_description ?? 'Browse Tanzania tours and safari packages: day trips from Moshi, Kilimanjaro hikes, cultural experiences, Zanzibar escapes and multi-day safaris.')
@section('meta_image', $heroImage ?? '')

@section('structured_data')
@php
    $collectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $pageTitle ?? 'Tanzania Tours & Safaris',
        'description' => $heroCopy ?? '',
        'url' => url()->current(),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($collectionSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="{{ $heroImage }}" alt="{{ $pageTitle }}" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      @if($crumbLabel === 'Tours' || $crumbLabel === 'Safaris')
      <span>{{ $crumbLabel }}</span>
      @elseif($crumbLabel === 'Day Trips' || $crumbLabel === 'Multi-Day Safaris' || $crumbLabel === 'Cultural Tours' || $crumbLabel === 'Kilimanjaro Trips' || $crumbLabel === 'Beach Experiences' || $crumbLabel === 'Custom Safaris')
      <a href="{{ route('tours.index') }}">Tours</a>
      <span>/</span>
      <span>{{ $crumbLabel }}</span>
      @else
      <a href="{{ route('safaris') }}">Safaris</a>
      <span>/</span>
      <span>{{ $crumbLabel }}</span>
      @endif
    </nav>
    <h1>{{ $pageTitle }}</h1>
    <p class="hero-copy">{{ $heroCopy }}</p>
  </div>
</section>

<!-- TOURS -->
<section class="tours-section page-section" id="tours">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">{{ $eyebrow }}</div>
      <h2 class="display-lg">{{ $pageTitle }}</h2>
      <p>{{ $heroCopy }}</p>
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
      @if(isset($presetFilter) && $presetFilter)
      if (window.__tdtsExt && window.__tdtsExt.setFilter) {
        window.__tdtsExt.setFilter('{{ $presetFilter }}');
      }
      @else
      var p = new URLSearchParams(window.location.search);
      var cat = p.get('cat');
      if (cat && window.__tdtsExt && window.__tdtsExt.setFilter) {
        window.__tdtsExt.setFilter(cat);
      }
      @endif
    } catch (e) {}
  });
</script>
@endpush