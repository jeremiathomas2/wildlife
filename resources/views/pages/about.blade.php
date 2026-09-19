@extends('layouts.app')

@section('title', 'About Tanzania Daily Tours & Safari - Local Experts Since 2012')
@section('meta_title', 'About Tanzania Daily Tours & Safari - Local Experts Since 2012')
@section('meta_description', 'Learn about Tanzania Daily Tours & Safari - your trusted local tour operator since 2012. Expert guides, authentic experiences, and unforgettable adventures across Tanzania.')
@section('meta_keywords', 'Tanzania tour operator, local safari guides, about Tanzania tours, Tanzania safari company, Arusha tour operator, experienced safari guides, authentic Tanzania experiences')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890318/about-story_of4wth.jpg')

@section('structured_data')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => 'About Tanzania Daily Tours & Safari',
        'description' => 'Learn about Tanzania Daily Tours & Safari - your trusted local tour operator since 2012',
        'url' => url()->current(),
        'mainEntity' => [
            '@type' => 'Organization',
            'name' => 'Tanzania Daily Tours & Safari',
            'foundingDate' => '2012',
            'description' => 'Expert-guided Tanzania safaris, cultural tours, and Kilimanjaro adventures',
            'employee' => [
                '@type' => 'Person',
                'name' => 'Petro Mihambo',
                'jobTitle' => 'Senior Tour Guide',
                'description' => 'Expert Tanzania safari guide with over 10 years of experience',
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890320/about-hero_dbeshf.jpg" alt="About Tanzania Daily Tours & Safari" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>About</span>
    </nav>
    <h1>{{ $contents['about_page_title']->value ?? 'ABOUT OUR STORY' }}</h1>
    <p class="hero-copy">Born and based in Tanzania — expert guides, authentic experiences and unforgettable adventures since 2012.</p>
  </div>
</section>

<!-- OUR STORY -->
<section class="intro page-section">
  <div class="container">
    <div class="intro-text reveal-left">
      <span class="intro-big-num" aria-hidden="true">01</span>
      <div class="eyebrow">{{ $contents['about_story_label']->value ?? 'Our Story' }}</div>
      <h2 class="display-lg">{{ $contents['about_story_title']->value ?? 'PASSIONATE ABOUT TANZANIA\'S NATURAL HERITAGE.' }}</h2>
      <div class="story-prose prose">
        {!! $contents['about_story_text']->value ?? '<p>Founded by local guides with deep knowledge of Tanzania\'s parks and cultures, Tanzania Daily Tours was born from a love of sharing our incredible homeland with visitors from around the world.</p><p>What started as a small team of passionate safari guides has grown into one of the most trusted tour operators in the region. We\'ve spent over a decade crafting unforgettable experiences, from Kilimanjaro\'s summit to the Serengeti\'s endless plains.</p><p>Our mission is simple: to show you the real Tanzania. Not just the postcard views, but the warmth of our people, the depth of our cultures, and the raw beauty of our wilderness.</p>' !!}
      </div>
    </div>
    <div class="story-media reveal-right">
      <div class="story-frame">
        <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_800/v1783621533/Tanzania_Daily_Tours_and_Safari_guide-Picsart-AiImageEnhancer_qisc5z.png" alt="{{ $contents['about_story_label']->value ?? 'Our Story' }}" />
        <span class="story-badge"><strong>15+</strong>Years of Trust</span>
      </div>
    </div>
  </div>
</section>

<!-- VALUES -->
<section class="page-section alt">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">{{ $contents['about_values_label']->value ?? 'Our Values' }}</div>
      <h2 class="display-lg">{{ $contents['about_values_title']->value ?? 'WHAT DRIVES US' }}</h2>
    </div>
    <div class="page-info-grid">
      <div class="info-item reveal">
        <i class="fas fa-earth-africa"></i>
        <h4>Sustainability</h4>
        <p>We practice responsible tourism that protects wildlife and supports local communities.</p>
      </div>
      <div class="info-item reveal">
        <i class="fas fa-heart"></i>
        <h4>Authenticity</h4>
        <p>Real experiences with real people. No staged cultural performances.</p>
      </div>
      <div class="info-item reveal">
        <i class="fas fa-award"></i>
        <h4>Excellence</h4>
        <p>From our vehicles to our guides, we settle for nothing less than the best.</p>
      </div>
    </div>
  </div>
</section>

<!-- TEAM -->
<section class="page-section">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">Your Host</div>
      <h2 class="display-lg">MEET THE EXPERT</h2>
    </div>
    <div class="reveal-scale" style="max-width:560px;margin:0 auto;">
      <div class="detail-card" style="text-align:center;margin-bottom:0;">
        <div style="width:150px;height:150px;border-radius:50%;overflow:hidden;margin:0 auto 22px;border:4px solid var(--secondary);">
          <img src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_400/v1783677911/ally_h4ud4z.png" alt="Petro Mihambo" style="width:100%;height:100%;object-fit:cover;" loading="lazy" />
        </div>
        <div class="eyebrow" style="justify-content:center;color:var(--secondary);">Senior Tour Guide</div>
        <h2 style="color:var(--primary);margin:12px 0 6px;">PETRO MIHAMBO</h2>
        <p style="font-size:1.05rem;color:var(--dark);">Let us plan your dream safari journey.</p>
        <p style="font-size:.9rem;color:var(--muted);margin-top:8px;">Enquire now and our travel expert will get back to you within 24 hours.</p>
        <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-top:24px;">
          <a href="{{ route('contact') }}" class="btn btn-primary">HELP ME PLAN</a>
          <a href="https://wa.me/255623975934" target="_blank" rel="noopener noreferrer" class="btn" style="background:#25D366;border-color:#25D366;color:#fff;"><i class="fab fa-whatsapp"></i> WHATSAPP</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats">
  <div class="container">
    <div class="stats-grid">
      <div class="stat reveal">
        <span class="stat-num" data-count="10" data-suffix="+">0</span>
        <div class="stat-label">Years of Experience</div>
        <div class="stat-note">Local operator</div>
      </div>
      <div class="stat reveal">
        <span class="stat-num" data-count="5000" data-suffix="+">0</span>
        <div class="stat-label">Happy Travelers</div>
        <div class="stat-note">Since 2012</div>
      </div>
      <div class="stat reveal">
        <span class="stat-num" data-count="12">0</span>
        <div class="stat-label">National Parks</div>
        <div class="stat-note">Across Tanzania</div>
      </div>
      <div class="stat reveal">
        <span class="stat-num" data-count="100" data-suffix="%">0</span>
        <div class="stat-label">Local Team</div>
        <div class="stat-note">Born & based in TZ</div>
      </div>
    </div>
  </div>
</section>

@endsection