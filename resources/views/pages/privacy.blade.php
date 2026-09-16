@extends('layouts.app')

@section('title', 'Privacy Policy - Tanzania Daily Tours & Safari')
@section('meta_title', 'Privacy Policy - Tanzania Daily Tours & Safari')
@section('meta_description', 'Read our privacy policy. Learn how we collect, use, and protect your personal information when booking Tanzania safaris and tours.')
@section('meta_keywords', 'Tanzania safari privacy policy, data protection, GDPR compliance, personal information security')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg')

@section('structured_data')
@php
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => 'Privacy Policy',
        'description' => 'Read our privacy policy. Learn how we collect, use, and protect your personal information',
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
  <img class="hero-bg" src="{{ \App\Support\SafariContent::cld(\App\Support\SafariContent::F['pxParretti'], 1920) }}" alt="Privacy policy" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <span>Privacy Policy</span>
    </nav>
    <h1>PRIVACY POLICY</h1>
    <p class="hero-copy">Last updated: {{ now()->format('F j, Y') }}</p>
  </div>
</section>

<!-- CONTENT -->
<section class="page-section">
  <div class="container">
    <div class="prose">
      <h2>1. Information We Collect</h2>
      <p>At Tanzania Daily Tours & Safari, we collect information you provide directly to us when you book a safari, inquire about our services, or subscribe to our newsletter. This includes:</p>
      <ul>
        <li>Name and contact information (email, phone, address)</li>
        <li>Travel preferences and requirements</li>
        <li>Payment information (processed securely through third-party providers)</li>
        <li>Passport details for visa processing</li>
      </ul>

      <h2>2. How We Use Your Information</h2>
      <p>We use your information to:</p>
      <ul>
        <li>Process your bookings and reservations</li>
        <li>Communicate with you about your safari arrangements</li>
        <li>Provide customer support</li>
        <li>Send you relevant travel information and updates</li>
        <li>Improve our services</li>
      </ul>

      <h2>3. Data Security</h2>
      <p>We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. Your payment information is processed through secure payment gateways and is not stored on our servers.</p>

      <h2>4. Third-Party Services</h2>
      <p>We may share your information with trusted third parties who assist us in operating our services, such as hotels, lodges, and transport providers. We only share information necessary for them to provide their services.</p>

      <h2>5. Cookies</h2>
      <p>Our website may use "cookies" to enhance your browsing experience. You can choose to set your web browser to refuse cookies, though some parts of the site may not function properly as a result. You can manage your preferences at any time using the <a href="#" data-cookie="manage">Cookie Preferences</a> tool.</p>

      <h2>6. Your Rights</h2>
      <p>You have the right to:</p>
      <ul>
        <li>Access your personal data</li>
        <li>Request correction of inaccurate data</li>
        <li>Request deletion of your personal data</li>
        <li>Opt-out of marketing communications</li>
      </ul>

      <h2>7. Contact Us</h2>
      <p>If you have questions about this privacy policy or your personal data, please contact us at:</p>
      <ul>
        <li><strong>Email:</strong> <a href="mailto:info.tanzaniadailytours@gmail.com">info.tanzaniadailytours@gmail.com</a></li>
        <li><strong>Phone:</strong> <a href="tel:+255623975934">+255 623 975 934</a></li>
        <li><strong>Address:</strong> Wakala wa Vipimo Building, Moshi, Kilimanjaro, Tanzania</li>
      </ul>

      <div class="note">
        This privacy policy is part of our commitment to transparency and protecting your privacy. By using our services, you agree to the collection and use of information as described in this policy.
      </div>
    </div>
  </div>
</section>

@endsection