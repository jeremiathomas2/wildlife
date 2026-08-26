@props([
    'contents',
])

<!-- CTA Section -->
<section class="py-20 lg:py-28" style="background: #088529;">
    <div class="max-w-[700px] mx-auto px-6 text-center">
        <h2
            class="font-bold mb-5"
            style="
                font-family: 'Raleway', sans-serif;
                font-size: clamp(2rem, 5vw, 3.5rem);
                color: #ffffff;
                line-height: 1.15;
            "
        >
            {{ $contents['cta_title']->value ?? 'Ready for Your African Adventure?' }}
        </h2>
        <p
            class="text-lg mb-10"
            style="color: rgba(255,255,255,0.9);"
        >
            {{ $contents['cta_description']->value ?? 'Let our experts craft the perfect safari itinerary for you. From day trips to multi-week expeditions, we make your dream trip a reality.' }}
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a
                href="{{ route('destinations') }}"
                class="inline-flex items-center px-10 py-4 rounded-full text-base font-semibold transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                style="background: #ffffff; color: #088529;"
            >
                Book Now
            </a>
            <a
                href="{{ route('contact') }}"
                class="inline-flex items-center px-10 py-4 rounded-full text-base font-semibold text-white transition-all duration-300 hover:bg-white hover:bg-opacity-10"
                style="border: 1px solid rgba(255,255,255,0.6);"
            >
                Contact Us
            </a>
        </div>
    </div>
</section>
