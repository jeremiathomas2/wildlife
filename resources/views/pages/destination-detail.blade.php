@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <section class="relative" style="height: 60vh; min-height: 400px;">
        <img src="{{ asset($tour['image']) }}" alt="{{ $tour['name'] }}" class="w-full h-full object-cover">
        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(17,17,17,0.7), transparent 60%);"></div>
        <div class="absolute bottom-0 left-0 right-0 z-10 max-w-7xl mx-auto px-6 pb-10">
            <a href="{{ route('destinations') }}" class="inline-flex items-center gap-1 text-sm mb-4 transition-colors hover:text-white" style="color: rgba(255,255,255,0.8);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
                </svg>
                Back to Destinations
            </a>
            <span class="inline-block px-3 py-0.5 rounded-full text-xs font-semibold text-white mb-3" style="background: #ff9729;">
                {{ $tour['category'] === 'day' ? 'Day Trip' : ($tour['category'] === 'multi' ? 'Multi-Day' : ucfirst($tour['category'])) }}
            </span>
            <h1 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.5rem); color: #ffffff; line-height: 1.15;">
                {{ $tour['name'] }}
            </h1>
            <div class="flex items-center gap-4 mt-3">
                <div class="flex items-center gap-1.5 text-sm" style="color: rgba(255,255,255,0.8);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ $tour['duration'] }}
                </div>
                <span class="text-sm font-bold" style="color: #ff9729;">From ${{ $tour['price'] }}</span>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 lg:py-16" style="background: #f8f4f0;">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-10">
                <!-- Main Content -->
                <div>
                    <div class="bg-white rounded-2xl p-6 lg:p-8 mb-8" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                        <h2 class="font-bold text-xl mb-4" style="font-family: 'Playfair Display', serif; color: #854208;">
                            About This Tour
                        </h2>
                        <p class="text-base leading-relaxed" style="color: #111111;">
                            {{ $tour['longDescription'] ?? $tour['description'] }}
                        </p>
                    </div>

                    @if(!empty($tour['includes']))
                        <div class="bg-white rounded-2xl p-6 lg:p-8 mb-8" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                            <h2 class="font-bold text-xl mb-4" style="font-family: 'Playfair Display', serif; color: #854208;">
                                What's Included
                            </h2>
                            <ul class="space-y-3">
                                @foreach($tour['includes'] as $item)
                                    <li class="flex items-start gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #088529;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M9 11l3 3L22 4"/>
                                            <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>
                                        </svg>
                                        <span class="text-sm" style="color: #111111;">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Related Tours -->
                    @if(!empty($relatedTours))
                        <div class="bg-white rounded-2xl p-6 lg:p-8" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                            <h2 class="font-bold text-xl mb-4" style="font-family: 'Playfair Display', serif; color: #854208;">
                                You May Also Like
                            </h2>
                            <div class="space-y-4">
                                @foreach($relatedTours as $related)
                                    <a href="{{ route('destination.detail', $related['slug']) }}" class="flex items-center gap-4 group">
                                        <div class="w-20 h-14 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ asset($related['image']) }}" alt="{{ $related['name'] }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm group-hover:underline" style="color: #854208;">
                                                {{ $related['name'] }}
                                            </h4>
                                            <p class="text-xs" style="color: #5a3e2b;">{{ $related['duration'] }} • From ${{ $related['price'] }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Booking Card -->
                <div class="lg:sticky lg:top-24 self-start">
                    <div class="bg-white rounded-2xl p-6 lg:p-8" style="box-shadow: 0 8px 32px rgba(0,0,0,0.08);">
                        <h3 class="font-bold text-lg mb-5" style="font-family: 'Playfair Display', serif; color: #854208;">
                            Book This Tour
                        </h3>

                        <div class="space-y-4 mb-6">
                            <div>
                                <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                    Travel Date
                                </label>
                                <input type="date" class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                    Number of Travelers
                                </label>
                                <select class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                    <option>1 Person</option>
                                    <option>2 People</option>
                                    <option>3 People</option>
                                    <option>4 People</option>
                                    <option>5+ People</option>
                                </select>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6 space-y-2" style="border-color: rgba(133,66,8,0.1);">
                            <div class="flex justify-between text-sm">
                                <span style="color: #5a3e2b;">Price per person</span>
                                <span style="color: #111111;">${{ $tour['price'] }}</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold">
                                <span style="color: #854208;">Total</span>
                                <span style="color: #088529;">${{ $tour['price'] }}</span>
                            </div>
                        </div>

                        <button onclick="alert('Booking feature coming soon! Please contact us via WhatsApp or email to book this tour.')" class="w-full py-3.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90" style="background: #088529;">
                            Book Now
                        </button>

                        <p class="text-center mt-3">
                            <a href="{{ route('contact') }}" class="text-xs font-semibold transition-colors hover:underline" style="color: #ff9729;">
                                Or contact us
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
