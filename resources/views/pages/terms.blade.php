@extends('layouts.app')

@section('title', 'Terms & Conditions - Tanzania Daily Tours & Safari')
@section('meta_title', 'Terms & Conditions - Tanzania Daily Tours & Safari')
@section('meta_description', 'Read our terms and conditions for booking Tanzania safaris. Cancellation policy, payment terms, booking requirements, and travel insurance information.')
@section('meta_keywords', 'Tanzania safari terms, safari booking conditions, cancellation policy Tanzania, safari payment terms, Tanzania tour terms and conditions')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg')

@section('structured_data')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'TermsPage',
        'name' => 'Terms and Conditions',
        'description' => 'Read our terms and conditions for booking Tanzania safaris',
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
  <img class="hero-bg" src="https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/tour-zanzibar_y2syxk.jpg" alt="Terms and conditions" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Terms & Conditions</span>
    </nav>
    <h1>TERMS & CONDITIONS</h1>
    <p class="hero-copy"><strong>Last Updated:</strong> July 2026</p>
  </div>
</section>

<!-- CONTENT -->
<section class="page-section">
  <div class="container">
    <div class="prose">
      <p>Welcome to Tanzania Daily Tours & Safari. These terms and conditions outline the rules and regulations for the use of our services and website. By booking a tour with us, you agree to be bound by the following terms:</p>

      <h2>A. Booking and Deposit</h2>
      <ul>
        <li>A deposit of 30% is required at the time of booking to secure your reservation.</li>
        <li>The remaining balance must be paid at least 30 days before the commencement of the tour.</li>
        <li>For bookings made within 30 days of departure, full payment is required immediately.</li>
      </ul>

      <h2 id="cancellation">B. Cancellation & Refund Policy</h2>
      <p>Cancellations must be submitted in writing. The following fees apply based on when the notice is received:</p>
      <ul>
        <li>60+ days before arrival: 10% of the total cost is retained.</li>
        <li>30-59 days before arrival: 50% of the total cost is retained.</li>
        <li>Less than 30 days before arrival: 100% of the total cost is retained (No refund).</li>
      </ul>

      <h2>C. Travel Insurance</h2>
      <p>Tanzania Daily Tours & Safari does not provide travel insurance. It is a mandatory requirement for all clients to have comprehensive travel insurance covering medical expenses, emergency repatriation, personal accident, and trip cancellation.</p>

      <h2>D. Alteration of Tours</h2>
      <p>The company reserves the right to alter arrangements or cancel a route due to logistical reasons, safety concerns, or weather conditions. In such cases, we will provide an alternative of similar value.</p>

      <h2>E. Liability</h2>
      <p>While we take every precaution to ensure your safety, the company is not liable for personal injury, loss of luggage, or delays caused by circumstances beyond our control (Force Majeure).</p>

      <div class="note">
        For questions about these terms, contact us at
        <a href="mailto:info.tanzaniadailytours@gmail.com">info.tanzaniadailytours@gmail.com</a> or
        <a href="tel:+255623975934">+255 623 975 934</a>.
      </div>
    </div>
  </div>
</section>

@endsection