@extends('layouts.app')

@section('title', 'Privacy Policy - Tanzania Daily Tours & Safari')
@section('meta_title', 'Privacy Policy - Tanzania Daily Tours & Safari')
@section('meta_description', 'Read our privacy policy. Learn how we collect, use, and protect your personal information when booking Tanzania safaris and tours.')
@section('meta_keywords', 'Tanzania safari privacy policy, data protection, GDPR compliance, personal information security')
@section('meta_image', 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-serengeti_agwjrp.jpg')

@section('structured_data')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Privacy Policy",
    "description": "Read our privacy policy. Learn how we collect, use, and protect your personal information",
    "url": "https://www.tanzaniadailytoursandsafari.com/privacy"
}
</script>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="relative flex items-end" style="height: 50vh; min-height: 400px; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(101, 30, 8, 0.7)), url('https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-serengeti_agwjrp.jpg') center/cover no-repeat;">
        <div class="max-w-[1280px] mx-auto px-6 pb-12">
            <nav class="text-xs mb-3" style="color: rgba(255,255,255,0.7);">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                <span class="mx-2">/</span>
                <span style="color: #ffffff;">Privacy Policy</span>
            </nav>
            <h1 class="text-3xl md:text-5xl font-bold" style="font-family: 'Raleway', sans-serif; color: #ffffff;">
                Privacy Policy
            </h1>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-12 lg:py-20" style="background: #ffffff;">
        <div class="max-w-4xl mx-auto px-6">
            <div class="prose prose-lg max-w-none" style="color: #111111;">
                <p class="mb-6" style="color: #5a3e2b;">Last updated: {{ now()->format('F j, Y') }}</p>

                <h2 class="font-bold text-2xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">1. Information We Collect</h2>
                <p class="mb-4">At Tanzania Daily Tours & Safari, we collect information you provide directly to us when you book a safari, inquire about our services, or subscribe to our newsletter. This includes:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Name and contact information (email, phone, address)</li>
                    <li>Travel preferences and requirements</li>
                    <li>Payment information (processed securely through third-party providers)</li>
                    <li>Passport details for visa processing</li>
                </ul>

                <h2 class="font-bold text-2xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">2. How We Use Your Information</h2>
                <p class="mb-4">We use your information to:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Process your bookings and reservations</li>
                    <li>Communicate with you about your safari arrangements</li>
                    <li>Provide customer support</li>
                    <li>Send you relevant travel information and updates</li>
                    <li>Improve our services</li>
                </ul>

                <h2 class="font-bold text-2xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">3. Data Security</h2>
                <p class="mb-6">We implement appropriate technical and organizational measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. Your payment information is processed through secure payment gateways and is not stored on our servers.</p>

                <h2 class="font-bold text-2xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">4. Third-Party Services</h2>
                <p class="mb-6">We may share your information with trusted third parties who assist us in operating our services, such as hotels, lodges, and transport providers. We only share information necessary for them to provide their services.</p>

                <h2 class="font-bold text-2xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">5. Your Rights</h2>
                <p class="mb-4">You have the right to:</p>
                <ul class="list-disc pl-6 mb-6 space-y-2">
                    <li>Access your personal data</li>
                    <li>Request correction of inaccurate data</li>
                    <li>Request deletion of your personal data</li>
                    <li>Opt-out of marketing communications</li>
                </ul>

                <h2 class="font-bold text-2xl mb-4" style="font-family: 'Raleway', sans-serif; color: #854208;">6. Contact Us</h2>
                <p class="mb-6">If you have questions about this privacy policy or your personal data, please contact us at:</p>
                <p class="mb-6">
                    <strong>Email:</strong> info@tanzaniadailytoursandsafari.com<br>
                    <strong>Phone:</strong> +255 700 000 000<br>
                    <strong>Address:</strong> Arusha, Tanzania
                </p>

                <div class="mt-8 p-6 rounded-lg" style="background: #f8f4f0;">
                    <p class="text-sm" style="color: #5a3e2b;">
                        This privacy policy is part of our commitment to transparency and protecting your privacy. By using our services, you agree to the collection and use of information as described in this policy.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
