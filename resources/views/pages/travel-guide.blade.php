@extends('layouts.app')

@section('title', 'Tanzania Travel Guide - Planning Tips, Packing & Seasons')
@section('meta_title', 'Tanzania Travel Guide - Tanzania Daily Tours & Safari')
@section('meta_description', 'Everything you need to plan a Tanzania safari: best time to visit, what to pack, costs, visa & entry, safety and Kilimanjaro preparation.')
@section('meta_keywords', 'Tanzania travel guide, best time to visit Tanzania, safari packing list, Tanzania visa, Kilimanjaro preparation, safari cost')
@section('meta_image', 'https://res.cloudinary.com/aenlplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg')

@section('structured_data')
@php
    $guideSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Tanzania Travel Guide',
        'description' => 'Planning tips, packing lists, costs and everything else you need before travelling to Tanzania.',
        'url' => url()->current(),
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($guideSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://res.cloudinary.com/aenlplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg" alt="Tanzania travel guide" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Travel Guide</span>
    </nav>
    <h1>TRAVEL GUIDE</h1>
    <p class="hero-copy">Everything you need to know before you travel to Tanzania — seasons, packing, costs, visas and safety, all in one place.</p>
  </div>
</section>

<!-- GUIDE OVERVIEW CARDS -->
<section class="guide page-section">
  <div class="container">
    <div class="section-head reveal">
      <div class="eyebrow">PLAN YOUR JOURNEY</div>
      <h2 class="display-lg">TRAVEL GUIDE</h2>
      <p>Jump to the topic you need, or read straight through — we've covered the essentials.</p>
    </div>
    <div class="guide-grid">
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariSerengeti'], 600) }}" alt="Best time to visit Tanzania" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Planning</div>
          <h4>Best Time to Visit Tanzania</h4>
          <p>Understand the dry and green seasons, the Great Migration timing and the best months for each park.</p>
          <div class="guide-foot"><a href="#guide-best-time">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['tourArusha'], 600) }}" alt="What to pack for a safari" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Tips</div>
          <h4>What to Pack for a Safari</h4>
          <p>Neutral layers, binoculars, a good camera, and the small essentials that make a big difference.</p>
          <div class="guide-foot"><a href="#guide-packing">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariNgorongoro'], 600) }}" alt="Tanzania safari cost guide" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Budget</div>
          <h4>Tanzania Safari Cost Guide</h4>
          <p>What affects safari pricing, how to compare quotes, and where you can save without missing out.</p>
          <div class="guide-foot"><a href="#guide-costs">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['galleryWildlife2'], 600) }}" alt="Serengeti travel guide" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Entry</div>
          <h4>Visa, Entry & Health</h4>
          <p>Visa on arrival for most nationalities, entry requirements, and the vaccines and meds to organise in advance.</p>
          <div class="guide-foot"><a href="#guide-entry">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['galleryLandscape2'], 600) }}" alt="Safari safety tips" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Safety</div>
          <h4>Safari Safety & Wildlife Etiquette</h4>
          <p>Staying safe in the bush — vehicle rules, respecting wildlife, and staying healthy on the road.</p>
          <div class="guide-foot"><a href="#guide-safety">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
      <article class="guide-card reveal">
        <div class="guide-img"><img src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['safariKilimanjaro'], 600) }}" alt="Kilimanjaro preparation" loading="lazy" /></div>
        <div class="guide-body">
          <div class="guide-cat">Adventure</div>
          <h4>Kilimanjaro Preparation</h4>
          <p>Routes, training, gear and acclimatisation — how to give yourself the best summit chance.</p>
          <div class="guide-foot"><a href="#guide-kilimanjaro">Read <i class="fas fa-arrow-right"></i></a></div>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- TRAVEL GUIDE DETAILS -->
<section class="guide-details page-section">
  <div class="container guide-details-wrap">

    <article class="guide-detail reveal" id="guide-best-time">
      <div class="guide-num" aria-hidden="true">01</div>
      <div class="guide-detail-body">
        <div class="guide-cat">Planning</div>
        <h4>Best Time to Visit Tanzania</h4>
        <p class="lead">Tanzania's dry season runs June to October — the classic safari window. Wildlife congregates around rivers and waterholes, grass is short, and game viewing is at its best. December to March offers warm, dry conditions across the north with calving season in the southern Serengeti.</p>
        <p>The green season (November–May) brings lush landscapes, dramatically fewer crowds and lower prices — ideal for budget travellers and photographers. The Great Migration famously crosses the Mara River between July and November, so time your Serengeti visit accordingly if you want to see the crossings.</p>
      </div>
    </article>

    <article class="guide-detail reveal" id="guide-packing">
      <div class="guide-num" aria-hidden="true">02</div>
      <div class="guide-detail-body">
        <div class="guide-cat">Tips</div>
        <h4>What to Pack for a Safari</h4>
        <p class="lead">Dress in neutral, light layers — khaki, beige and olive work best in the bush. Mornings on game drives are cool, so bring a fleece or light jacket even in the dry season. Comfortable walking shoes, a wide-brim hat, sunscreen and insect repellent are non-negotiables.</p>
        <p>Binoculars and a camera with a decent zoom will change your trip. Bring a refillable water bottle, any personal medication including a small first-aid kit, and a power bank — most camps do charge devices, but at their own pace. Leave bright whites and camouflage at home.</p>
      </div>
    </article>

    <article class="guide-detail reveal" id="guide-costs">
      <div class="guide-num" aria-hidden="true">03</div>
      <div class="guide-detail-body">
        <div class="guide-cat">Budget</div>
        <h4>Tanzania Safari Cost Guide</h4>
        <p class="lead">Safari pricing is driven by three main factors: which parks you visit (Serengeti has the highest entry fees), how many nights you stay, and your accommodation and transport standard. A budget camping safari might run a few hundred dollars per person per day, while a premium lodge safari costs significantly more.</p>
        <p>When comparing quotes, check what's actually included: park fees, transport, fuel, park ranger/guide fees, meals and accommodation. The cheapest quote isn't always the best value if extras start appearing later. We believe in one transparent price — no hidden add-ons, just what's genuinely included.</p>
      </div>
    </article>

    <article class="guide-detail reveal" id="guide-entry">
      <div class="guide-num" aria-hidden="true">04</div>
      <div class="guide-detail-body">
        <div class="guide-cat">Entry</div>
        <h4>Visa, Entry & Health</h4>
        <p class="lead">Most nationalities can obtain a Tanzania visa on arrival at Kilimanjaro, Arusha or Dar es Salaam airports, or apply online in advance via the official e-visa portal. Ensure your passport is valid for at least six months from your arrival date and carry your return ticket details.</p>
        <p>For health, most travellers need a Yellow Fever vaccination certificate if arriving from a country with risk of yellow fever transmission. Malaria prophylaxis is recommended for most itineraries — speak to your doctor 4–6 weeks before you travel. Pack and drink plenty of bottled or filtered water.</p>
      </div>
    </article>

    <article class="guide-detail reveal" id="guide-safety">
      <div class="guide-num" aria-hidden="true">05</div>
      <div class="guide-detail-body">
        <div class="guide-cat">Safety</div>
        <h4>Safari Safety & Wildlife Etiquette</h4>
        <p class="lead">Stay inside your vehicle at all times during game drives — never exit to take a photo, no matter how close a lion looks. Keep arms inside the vehicle, and always follow your guide's instructions. At night, camps have their own rules; a guide will walk you to and from your tent.</p>
        <p>Respect the animals' space: no flash photography that could disturb them, no loud noises, and patience at sightings. Drinking water is safe in the big hotels and most lodges (usually filtered or bottled), and your guide will point out tap-water situations where you should stick to bottles.</p>
      </div>
    </article>

    <article class="guide-detail reveal" id="guide-kilimanjaro">
      <div class="guide-num" aria-hidden="true">06</div>
      <div class="guide-detail-body">
        <div class="guide-cat">Adventure</div>
        <h4>Kilimanjaro Preparation</h4>
        <p class="lead">Most climbers use the Marangu "Coca-Cola" route or the scenic Machame route — we arrange both, and every ascent is guided with full porter support. Fit and determined walkers with no special training can summit, but the altitude is the challenge, not the distance.</p>
        <p>Train with steady hillside walking and long day hikes, practise sleeping at altitude if you can, and invest in quality layers, a sleeping bag rated for −10°C, and boots you've already broken in. Pole-pole — slowly, slowly — is the golden rule. Your guide sets the pace, and we follow it religiously to give you the best summit chance.</p>
      </div>
    </article>

  </div>
</section>

<!-- CUSTOM CTA -->
<section class="custom-cta">
  <div class="container">
    <div class="reveal-scale">
      <div class="eyebrow eyebrow-light" style="justify-content:center;display:inline-flex;margin-bottom:18px">{{ $contents['destinations_cta_text']->value ?? 'STILL PLANNING?' }}</div>
      <h2>LET'S PLAN YOUR<br /><em>TANZANIA TRIP.</em></h2>
      <p>Questions about seasons, routes or budgets? Our safari experts reply within hours — not days.</p>
      <div class="custom-actions">
        <button class="btn btn-accent" data-custom="true">BUILD MY SAFARI</button>
        <a href="{{ route('contact') }}" class="btn btn-outline">TALK TO AN EXPERT</a>
      </div>
    </div>
  </div>
</section>

@endsection