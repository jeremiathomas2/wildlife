@extends('layouts.app')

@section('title', 'Contact Tanzania Daily Tours & Safari - Plan Your Safari')
@section('meta_title', 'Contact Tanzania Daily Tours & Safari - Plan Your Safari')
@section('meta_description', 'Get in touch with Tanzania Daily Tours & Safari to plan your perfect Tanzania adventure. Expert consultation, custom itineraries, and 24/7 support. Book your safari today!')
@section('meta_keywords', 'contact Tanzania safari, book Tanzania safari, safari inquiry, Tanzania tour booking, Arusha tour operator contact, safari consultation')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890318/contact-header_uxkkku.jpg')

@section('structured_data')
@php
    $contactPageSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'ContactPage',
        'name' => 'Contact Tanzania Daily Tours & Safari',
        'description' => 'Get in touch with Tanzania Daily Tours & Safari to plan your perfect Tanzania adventure',
        'url' => url()->current(),
        'mainEntity' => [
            '@type' => 'TravelAgency',
            'name' => 'Tanzania Daily Tours & Safari',
            'telephone' => '+255623975934',
            'email' => 'info.tanzaniadailytours@gmail.com',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Wakala wa Vipimo, Moshi',
                'addressLocality' => 'Moshi',
                'addressRegion' => 'Kilimanjaro',
                'addressCountry' => 'TZ',
            ],
        ],
    ];
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => [
            [
                '@type' => 'Question',
                'name' => 'How do I book a Tanzania safari?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'You can book a Tanzania safari by contacting us through our website form, WhatsApp, or email. We\'ll respond within 24 hours with a customized itinerary and quote based on your preferences and travel dates.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What information do I need to provide for booking?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'To book your safari, we\'ll need your travel dates, number of travelers, preferred destinations, accommodation level (budget, mid-range, or luxury), and any special requirements or dietary restrictions.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What payment methods do you accept?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We accept bank transfers, credit cards, and mobile money payments. A 30% deposit is required to confirm your booking, with the remaining balance due 30 days before your safari begins.',
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($contactPageSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
<script type="application/ld+json">
{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890320/contact-header_x16img.jpg" alt="Contact Tanzania Daily Tours & Safari" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Contact</span>
    </nav>
    <h1>{{ $contents['contact_page_title']->value ?? 'GET IN TOUCH' }}</h1>
    <p class="hero-copy">{{ $contents['contact_description']->value ?? "Ready to start your adventure? Send us a message and we'll get back to you within 24 hours to help plan your personalized Tanzanian experience." }}</p>
  </div>
</section>

<!-- CONTACT -->
<section class="page-section">
  <div class="container">
    <div class="page-detail-grid">
      <!-- Contact Info -->
      <div class="main-col">
        <div class="detail-card">
          <h2><span class="mm">01</span>{{ $contents['contact_subtitle']->value ?? 'Plan Your Perfect Safari' }}</h2>

          <div class="page-info-grid" style="grid-template-columns:1fr;">
            <div class="info-item" style="text-align:left;display:flex;gap:18px;align-items:flex-start;">
              <i class="fas fa-map-marker-alt" style="font-size:1.3rem;margin:2px 0 0;"></i>
              <div>
                <h4>Location</h4>
                <p>{{ $contents['contact_location']->value ?? 'Wakala wa Vipimo - Moshi - Kilimanjaro' }}</p>
              </div>
            </div>
            <div class="info-item" style="text-align:left;display:flex;gap:18px;align-items:flex-start;">
              <i class="fas fa-phone-alt" style="font-size:1.3rem;margin:2px 0 0;"></i>
              <div>
                <h4>Phone / WhatsApp</h4>
                <p><a href="tel:+255623975934" style="color:var(--primary);font-weight:700;">+255 623 975 934</a></p>
              </div>
            </div>
            <div class="info-item" style="text-align:left;display:flex;gap:18px;align-items:flex-start;">
              <i class="fas fa-envelope" style="font-size:1.3rem;margin:2px 0 0;"></i>
              <div>
                <h4>Email</h4>
                <p><a href="mailto:info.tanzaniadailytours@gmail.com" style="color:var(--primary);font-weight:700;">info.tanzaniadailytours@gmail.com</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <aside class="book-sidebar" style="position:static;">
        @if(session('success'))
          <div class="alert-box">{{ session('success') }}</div>
        @endif
        <h3>Send Us a Message</h3>
        <form method="POST" action="{{ route('contact.submit') }}" novalidate>
          @csrf
          <div class="form-group-sm">
            <label class="field-sm" for="name">Full Name</label>
            <input type="text" id="name" name="name" required class="form-control" placeholder="John Doe">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="email">Email</label>
            <input type="email" id="email" name="email" required class="form-control" placeholder="your@email.com">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="interest">What interests you?</label>
            <select id="interest" name="interest" class="form-control">
              <option>Serengeti Safari</option>
              <option>Kilimanjaro Trek</option>
              <option>Zanzibar Holiday</option>
              <option>Day Trips</option>
              <option>Custom Itinerary</option>
            </select>
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="message">Your Message</label>
            <textarea id="message" name="message" rows="5" required class="form-control"></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:8px;">Send Message</button>
        </form>
      </aside>
    </div>
  </div>
</section>

@endsection