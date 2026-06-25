@extends('layouts.app')

@section('title', 'Terms and Conditions - Tanzania Daily Tours & Safaris')

@section('content')
    <!-- Hero Section -->
    <section class="relative flex items-end" style="height: 50vh; min-height: 400px; background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(101, 30, 8, 0.7)), url('{{ asset('images/tour-5.jpg') }}') center/cover no-repeat;">
        <div class="max-w-[1280px] mx-auto px-6 pb-12">
            <h1 class="text-3xl md:text-5xl font-bold" style="font-family: 'Playfair Display', serif; color: #ffffff;">
                Terms and Conditions
            </h1>
        </div>
    </section>

    <!-- Content Section -->
    <section class="py-12 lg:py-20" style="background: #ffffff;">
        <div class="max-w-4xl mx-auto px-6">
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-2" style="font-family: 'Playfair Display', serif; color: #854208;">
                    Tanzania Daily Tours & Safaris
                </h2>
                <p class="text-sm" style="color: #666666;">
                    <strong>Effective Date:</strong> June 2026<br>
                    <strong>Last Updated:</strong> June 2026
                </p>
            </div>

            <div class="space-y-8" style="color: #333333; font-family: 'Lato', sans-serif;">
                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">1. Introduction</h3>
                    <p class="mb-3 leading-relaxed">
                        Welcome to Tanzania Daily Tours & Safaris ("Company", "we", "our", "us").
                    </p>
                    <p class="mb-3 leading-relaxed">
                        These Terms and Conditions govern your access to and use of our website, booking platform, services, tours, safari packages, travel experiences, communications, and related services.
                    </p>
                    <p class="mb-3 leading-relaxed">
                        By accessing our website, making inquiries, submitting booking requests, or purchasing any tour package, you agree to be legally bound by these Terms and Conditions.
                    </p>
                    <p class="leading-relaxed">
                        If you do not agree with these Terms, you must not use our website or services.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">2. Company Information</h3>
                    <p class="mb-2"><strong>Company Name:</strong> Tanzania Daily Tours & Safaris</p>
                    <p class="mb-2"><strong>Address:</strong><br>
                        Wakala wa Vipimo Building,<br>
                        Moshi, Kilimanjaro,<br>
                        United Republic of Tanzania
                    </p>
                    <p class="mb-2"><strong>Email:</strong> <a href="mailto:info@tanzaniadailytours.com" style="color: #088529;">info@tanzaniadailytours.com</a></p>
                    <p class="mb-2"><strong>Phone/WhatsApp:</strong> <a href="tel:+255623975934" style="color: #088529;">+255 623 975 934</a></p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">3. Eligibility</h3>
                    <p class="mb-3">You must:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Be at least 18 years old;</li>
                        <li>Have legal capacity to enter into contracts;</li>
                        <li>Provide accurate and complete information;</li>
                        <li>Comply with applicable laws and regulations.</li>
                    </ul>
                    <p class="leading-relaxed">
                        Parents or guardians booking on behalf of minors assume full responsibility for those minors.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">4. Booking Agreement</h3>
                    <p class="mb-3">A booking becomes valid only when:</p>
                    <ol class="list-decimal list-inside space-y-2 mb-3">
                        <li>A booking request is submitted;</li>
                        <li>Availability is confirmed;</li>
                        <li>Required payment or deposit is received;</li>
                        <li>A booking confirmation is issued by Tanzania Daily Tours & Safaris.</li>
                    </ol>
                    <p class="leading-relaxed">
                        We reserve the right to reject any booking at our sole discretion.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">5. Pricing and Currency</h3>
                    <p class="mb-3 leading-relaxed">
                        All prices displayed on the website are subject to change without prior notice.
                    </p>
                    <p class="mb-3">Unless otherwise stated:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Prices are quoted in USD.</li>
                        <li>Additional taxes, conservation fees, or government levies may apply.</li>
                        <li>Exchange rate fluctuations do not affect confirmed bookings already paid.</li>
                    </ul>
                    <p class="leading-relaxed">
                        Quoted prices are valid only for the period stated in the quotation.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">6. Payments</h3>
                    <p class="mb-3">Accepted payment methods include:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Credit/Debit Cards</li>
                        <li>Mobile Money</li>
                        <li>Bank Transfers</li>
                        <li>Other approved payment channels</li>
                    </ul>
                    <p class="mb-3 leading-relaxed">
                        Payment transactions are processed through secure third-party providers.
                    </p>
                    <p class="mb-3 leading-relaxed">
                        We do not store full payment card information on our servers.
                    </p>
                    <p class="leading-relaxed">
                        Failure to complete payment may result in cancellation of your reservation.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">7. Deposit and Balance Payments</h3>
                    <p class="mb-3">For selected tours:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>A deposit may be required to secure a booking.</li>
                        <li>Remaining balances must be paid before the commencement of the tour.</li>
                        <li>Failure to settle balances by the specified deadline may lead to cancellation without refund of the deposit.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">8. Cancellation Policy</h3>
                    <h4 class="text-lg font-semibold mb-3" style="color: #854208;">Customer Cancellation</h4>
                    
                    <h5 class="text-base font-semibold mb-2" style="color: #854208;">More than 30 Days Before Departure</h5>
                    <p class="mb-3 leading-relaxed">100% refund minus transaction fees.</p>
                    
                    <h5 class="text-base font-semibold mb-2" style="color: #854208;">15–30 Days Before Departure</h5>
                    <p class="mb-3 leading-relaxed">50% refund of the total booking amount.</p>
                    
                    <h5 class="text-base font-semibold mb-2" style="color: #854208;">Less than 15 Days Before Departure</h5>
                    <p class="mb-3 leading-relaxed">No refund.</p>
                    
                    <h5 class="text-base font-semibold mb-2" style="color: #854208;">Special Circumstances</h5>
                    <p class="mb-3">Refunds may be considered for:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Serious illness;</li>
                        <li>Death of immediate family members;</li>
                        <li>Natural disasters;</li>
                        <li>Government travel restrictions.</li>
                    </ul>
                    <p class="leading-relaxed">Supporting documentation may be required.</p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">9. Changes to Bookings</h3>
                    <p class="mb-3">Clients may request modifications to:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Travel dates;</li>
                        <li>Participant numbers;</li>
                        <li>Accommodation options;</li>
                        <li>Pickup locations.</li>
                    </ul>
                    <p class="mb-3">Changes are subject to:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Availability;</li>
                        <li>Supplier approval;</li>
                        <li>Additional charges where applicable.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">10. Company Cancellation</h3>
                    <p class="mb-3">We reserve the right to cancel or modify tours due to:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Safety concerns;</li>
                        <li>Extreme weather;</li>
                        <li>Government directives;</li>
                        <li>Park closures;</li>
                        <li>Force majeure events;</li>
                        <li>Insufficient participant numbers.</li>
                    </ul>
                    <p class="mb-3">Where possible, clients will be offered:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Alternative dates;</li>
                        <li>Alternative tours;</li>
                        <li>Credit vouchers;</li>
                        <li>Refunds where applicable.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">11. Force Majeure</h3>
                    <p class="mb-3 leading-relaxed">
                        We shall not be liable for delays, cancellations, losses, or damages resulting from events beyond our reasonable control, including:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Natural disasters;</li>
                        <li>Floods;</li>
                        <li>Fires;</li>
                        <li>Epidemics or pandemics;</li>
                        <li>Terrorism;</li>
                        <li>Civil unrest;</li>
                        <li>Political instability;</li>
                        <li>Government actions;</li>
                        <li>Transportation disruptions.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">12. Travel Documents</h3>
                    <p class="mb-3">Clients are solely responsible for obtaining:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Passports;</li>
                        <li>Visas;</li>
                        <li>Vaccinations;</li>
                        <li>Health certificates;</li>
                        <li>Travel insurance;</li>
                        <li>Entry permits.</li>
                    </ul>
                    <p class="leading-relaxed mt-3">
                        Failure to obtain required documents shall not entitle the client to a refund.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">13. Travel Insurance</h3>
                    <p class="mb-3 leading-relaxed">
                        Comprehensive travel insurance is strongly recommended and should cover:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Medical emergencies;</li>
                        <li>Evacuation;</li>
                        <li>Trip cancellation;</li>
                        <li>Personal liability;</li>
                        <li>Loss of baggage;</li>
                        <li>Adventure activities where applicable.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">14. Health and Fitness</h3>
                    <p class="mb-3">Clients must disclose any:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Medical conditions;</li>
                        <li>Disabilities;</li>
                        <li>Dietary requirements;</li>
                        <li>Physical limitations.</li>
                    </ul>
                    <p class="leading-relaxed mt-3">
                        We reserve the right to decline participation where health conditions present safety risks.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">15. Wildlife and Adventure Activities</h3>
                    <p class="mb-3 leading-relaxed">
                        Participation in safari and adventure activities involves inherent risks including:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Wildlife encounters;</li>
                        <li>Vehicle accidents;</li>
                        <li>Hiking injuries;</li>
                        <li>Environmental hazards.</li>
                    </ul>
                    <p class="leading-relaxed mt-3">
                        By participating, clients acknowledge and voluntarily accept these risks.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">16. Limitation of Liability</h3>
                    <p class="mb-3 leading-relaxed">
                        To the maximum extent permitted by law:
                    </p>
                    <p class="mb-3">Tanzania Daily Tours & Safaris shall not be liable for:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Indirect damages;</li>
                        <li>Consequential losses;</li>
                        <li>Lost profits;</li>
                        <li>Personal belongings;</li>
                        <li>Missed flights;</li>
                        <li>Third-party service failures.</li>
                    </ul>
                    <p class="mb-3 leading-relaxed">
                        Our total liability shall not exceed the amount paid for the affected booking.
                    </p>
                    <p class="leading-relaxed">
                        Nothing in these Terms excludes liability where exclusion is prohibited by law.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">17. Third-Party Services</h3>
                    <p class="mb-3">The website may integrate with:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Payment gateways;</li>
                        <li>Google Maps;</li>
                        <li>WhatsApp;</li>
                        <li>TripAdvisor;</li>
                        <li>SafariBookings;</li>
                        <li>Social media platforms.</li>
                    </ul>
                    <p class="leading-relaxed">
                        We are not responsible for third-party websites, content, availability, or policies.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">18. User Conduct</h3>
                    <p class="mb-3">Users shall not:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Submit false information;</li>
                        <li>Upload unlawful content;</li>
                        <li>Attempt unauthorized access;</li>
                        <li>Introduce malware;</li>
                        <li>Interfere with website operations;</li>
                        <li>Violate intellectual property rights.</li>
                    </ul>
                    <p class="leading-relaxed mt-3">
                        Violations may result in suspension and legal action.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">19. Intellectual Property</h3>
                    <p class="mb-3">All content including:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Logos;</li>
                        <li>Images;</li>
                        <li>Videos;</li>
                        <li>Text;</li>
                        <li>Designs;</li>
                        <li>Source code;</li>
                        <li>Tour descriptions;</li>
                    </ul>
                    <p class="mb-3 leading-relaxed">
                        are owned by Tanzania Daily Tours & Safaris or licensed to us.
                    </p>
                    <p class="leading-relaxed">
                        No content may be copied, reproduced, distributed, or used commercially without written permission.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">20. Reviews and User Content</h3>
                    <p class="mb-3">Users may submit:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Reviews;</li>
                        <li>Testimonials;</li>
                        <li>Photographs;</li>
                        <li>Comments.</li>
                    </ul>
                    <p class="mb-3 leading-relaxed">
                        By submitting content, you grant us a worldwide, royalty-free, perpetual license to display, publish, and use such content for marketing and operational purposes.
                    </p>
                    <p class="mb-3">We reserve the right to remove content that is:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>False;</li>
                        <li>Offensive;</li>
                        <li>Defamatory;</li>
                        <li>Illegal;</li>
                        <li>Misleading.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">21. Privacy and Data Protection</h3>
                    <p class="mb-3 leading-relaxed">
                        We process personal data in accordance with:
                    </p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Tanzania Personal Data Protection Act, 2022;</li>
                        <li>GDPR (European Union);</li>
                        <li>UK GDPR;</li>
                        <li>Applicable international privacy laws.</li>
                    </ul>
                    <p class="leading-relaxed">
                        Collection and processing of personal data are governed by our Privacy Policy.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">22. Cookies</h3>
                    <p class="mb-3">Our website uses cookies for:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Essential functionality;</li>
                        <li>Analytics;</li>
                        <li>Security;</li>
                        <li>Marketing purposes.</li>
                    </ul>
                    <p class="leading-relaxed">
                        Users may manage cookie preferences through the cookie consent banner.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">23. Data Transfers</h3>
                    <p class="mb-3">Where necessary, personal data may be transferred internationally to:</p>
                    <ul class="list-disc list-inside space-y-2 mb-3">
                        <li>Cloud hosting providers;</li>
                        <li>Payment processors;</li>
                        <li>Communication providers;</li>
                        <li>Business partners.</li>
                    </ul>
                    <p class="leading-relaxed">
                        Appropriate safeguards shall be implemented for cross-border transfers.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">24. Indemnification</h3>
                    <p class="leading-relaxed">
                        You agree to indemnify and hold harmless Tanzania Daily Tours & Safaris, its directors, employees, contractors, and partners from claims, damages, liabilities, and expenses arising from:
                    </p>
                    <ul class="list-disc list-inside space-y-2 mt-3">
                        <li>Violation of these Terms;</li>
                        <li>Illegal activities;</li>
                        <li>Misrepresentation;</li>
                        <li>Negligent conduct.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">25. Governing Law</h3>
                    <p class="leading-relaxed">
                        These Terms shall be governed by the laws of:
                    </p>
                    <p class="mt-3 text-lg font-semibold" style="color: #854208;">
                        The United Republic of Tanzania
                    </p>
                    <p class="mt-2 leading-relaxed">
                        without regard to conflict-of-law principles.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">26. Dispute Resolution</h3>
                    <p class="mb-3 leading-relaxed">
                        Any dispute arising from these Terms shall be resolved through:
                    </p>
                    
                    <h4 class="text-lg font-semibold mb-2" style="color: #854208;">Step 1: Negotiation</h4>
                    <p class="mb-4 leading-relaxed">
                        Parties shall attempt amicable resolution within 30 days.
                    </p>
                    
                    <h4 class="text-lg font-semibold mb-2" style="color: #854208;">Step 2: Mediation</h4>
                    <p class="mb-4 leading-relaxed">
                        If unresolved, mediation shall be conducted in Tanzania.
                    </p>
                    
                    <h4 class="text-lg font-semibold mb-2" style="color: #854208;">Step 3: Arbitration or Courts</h4>
                    <p class="mb-3">Disputes may be referred to:</p>
                    <ul class="list-disc list-inside space-y-2">
                        <li>Arbitration under Tanzanian law; or</li>
                        <li>Courts of competent jurisdiction in Tanzania.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">27. Consumer Rights</h3>
                    <p class="leading-relaxed">
                        Nothing in these Terms limits mandatory consumer rights granted under applicable laws, including:
                    </p>
                    <ul class="list-disc list-inside space-y-2 mt-3">
                        <li>Tanzanian consumer protection laws;</li>
                        <li>EU consumer protection regulations;</li>
                        <li>Other mandatory international consumer protection laws.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">28. Changes to Terms</h3>
                    <p class="mb-3 leading-relaxed">
                        We may modify these Terms at any time.
                    </p>
                    <p class="mb-3 leading-relaxed">
                        Updated versions will be published on the website with a revised effective date.
                    </p>
                    <p class="leading-relaxed">
                        Continued use of the website after changes constitutes acceptance of the revised Terms.
                    </p>
                </div>

                <div>
                    <h3 class="text-xl font-bold mb-4" style="color: #854208;">29. Contact Information</h3>
                    <p class="mb-3 leading-relaxed">
                        For legal, booking, privacy, or compliance matters:
                    </p>
                    <p class="mb-2"><strong>Tanzania Daily Tours & Safaris</strong><br>
                        Wakala wa Vipimo Building, Moshi, Tanzania
                    </p>
                    <p class="mb-2"><strong>Email:</strong> <a href="mailto:info@tanzaniadailytours.com" style="color: #088529;">info@tanzaniadailytours.com</a></p>
                    <p class="mb-2"><strong>Phone:</strong> <a href="tel:+255623975934" style="color: #088529;">+255 623 975 934</a></p>
                </div>
            </div>
        </div>
    </section>
@endsection
