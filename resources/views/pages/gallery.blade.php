@extends('layouts.app')

@section('title', 'Tanzania Safari Photo Gallery - Wildlife, Landscapes & Culture')
@section('meta_title', 'Tanzania Safari Photo Gallery - Wildlife, Landscapes & Culture')
@section('meta_description', 'Browse our Tanzania safari photo gallery. Stunning wildlife photos, landscapes, cultural moments from Serengeti, Kilimanjaro, Zanzibar, and more.')
@section('meta_keywords', 'Tanzania safari photos, wildlife photography Tanzania, Serengeti photos, Kilimanjaro pictures, Zanzibar images, Tanzania travel photos, safari gallery')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890318/gallery-landscape-1_dxdd6x.jpg')

@section('structured_data')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'ImageGallery',
        'name' => 'Tanzania Safari Photo Gallery',
        'description' => 'Browse our Tanzania safari photo gallery featuring wildlife, landscapes, and cultural moments',
        'url' => url()->current(),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890318/gallery-landscape-1_dxdd6x.jpg" alt="Tanzania gallery" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Gallery</span>
    </nav>
    <h1>{{ $contents['gallery_page_title']->value ?? 'PHOTO GALLERY' }}</h1>
    <p class="hero-copy">Moments from the Serengeti, Ngorongoro, Kilimanjaro and the islands — captured by our travelers and guides.</p>
  </div>
</section>

<!-- GALLERY -->
<section class="gallery page-section" id="gallery">
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

@endsection