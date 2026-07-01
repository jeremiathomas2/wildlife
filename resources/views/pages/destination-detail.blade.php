@extends('layouts.app')

@section('content')
    <!-- Hero -->
    <section class="relative" style="height: 60vh; min-height: 400px;">
        <img src="{{ is_object($tour) ? ($tour->image ?? '') : ($tour['image'] ?? '') }}" alt="{{ is_object($tour) ? ($tour->name ?? '') : ($tour['name'] ?? '') }}" class="w-full h-full object-cover">
        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(17,17,17,0.7), transparent 60%);"></div>
        <div class="absolute bottom-0 left-0 right-0 z-10 max-w-7xl mx-auto px-6 pb-10">
            <a href="{{ route('destinations') }}" class="inline-flex items-center gap-1 text-sm mb-4 transition-colors hover:text-white" style="color: rgba(255,255,255,0.8);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M5 12l7-7M5 12l7 7"/>
                </svg>
                {{ $contents['destination_back_text']->value ?? 'Back to Destinations' }}
            </a>
            <span class="inline-block px-3 py-0.5 rounded-full text-xs font-semibold text-white mb-3" style="background: #ff9729;">
                {{ is_object($tour) ? ($tour->category ?? '') : ($tour['category'] ?? '') }}
            </span>
            <h1 class="font-bold" style="font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 4vw, 3.5rem); color: #ffffff; line-height: 1.15;">
                {{ is_object($tour) ? ($tour->name ?? '') : ($tour['name'] ?? '') }}
            </h1>
            <div class="flex items-center gap-4 mt-3">
                <div class="flex items-center gap-1.5 text-sm" style="color: rgba(255,255,255,0.8);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    {{ is_object($tour) ? ($tour->duration ?? '') : ($tour['duration'] ?? '') }}
                </div>
                <span class="text-sm font-bold" style="color: #ff9729;">From ${{ is_object($tour) ? ($tour->price_adult ?? $tour->price ?? 0) : ($tour['price_adult'] ?? $tour['price'] ?? 0) }}</span>
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
                            {{ $contents['destination_about_title']->value ?? 'About This Tour' }}
                        </h2>
                        <p class="text-base leading-relaxed" style="color: #111111;">
                            {{ is_object($tour) ? ($tour->desc ?? '') : ($tour['desc'] ?? '') }}
                        </p>
                    </div>

                    <!-- Related Tours -->
                    @if((is_object($relatedTours) ? $relatedTours->count() : count($relatedTours)) > 0)
                        <div class="bg-white rounded-2xl p-6 lg:p-8" style="box-shadow: 0 4px 20px rgba(0,0,0,0.06);">
                            <h2 class="font-bold text-xl mb-4" style="font-family: 'Playfair Display', serif; color: #854208;">
                                {{ $contents['destination_related_title']->value ?? 'You May Also Like' }}
                            </h2>
                            <div class="space-y-4">
                                @foreach($relatedTours as $related)
                                    <a href="{{ route('destination.detail', Str::slug( (is_object($related) ? ($related->name ?? '') : ($related['name'] ?? '')) )) }}" class="flex items-center gap-4 group">
                                        <div class="w-20 h-14 rounded-lg overflow-hidden flex-shrink-0">
                                            <img src="{{ is_object($related) ? ($related->image ?? '') : ($related['image'] ?? '') }}" alt="{{ is_object($related) ? ($related->name ?? '') : ($related['name'] ?? '') }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-sm group-hover:underline" style="color: #854208;">
                                                {{ is_object($related) ? ($related->name ?? '') : ($related['name'] ?? '') }}
                                            </h4>
                                            <p class="text-xs" style="color: #5a3e2b;">{{ is_object($related) ? ($related->duration ?? '') : ($related['duration'] ?? '') }} • From ${{ is_object($related) ? ($related->price_adult ?? $related->price ?? 0) : ($related['price_adult'] ?? $related['price'] ?? 0) }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Booking Card -->
                <div class="lg:sticky lg:top-24 self-start">
                    @if(session('success'))
                        <div class="mb-4 p-4 rounded-lg text-sm" style="background-color: rgba(8, 133, 41, 0.1); color: #088529;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl p-6 lg:p-8" style="box-shadow: 0 8px 32px rgba(0,0,0,0.08);">
                        <h3 class="font-bold text-lg mb-5" style="font-family: 'Playfair Display', serif; color: #854208;">
                            Book This Tour
                        </h3>

                        <form id="booking-form" method="POST" action="{{ route('bookings.store') }}">
                            @csrf
                            <input type="hidden" name="tour_name" value="{{ is_object($tour) ? ($tour->name ?? '') : ($tour['name'] ?? '') }}">
                            <input type="hidden" name="base_price" value="{{ is_object($tour) ? ($tour->price_adult ?? $tour->price ?? 0) : ($tour['price_adult'] ?? $tour['price'] ?? 0) }}">
                            <input type="hidden" name="price_adult" value="{{ is_object($tour) ? ($tour->price_adult ?? $tour->price ?? 0) : ($tour['price_adult'] ?? $tour['price'] ?? 0) }}">
                            <input type="hidden" name="price_child" value="{{ is_object($tour) ? ($tour->price_child ?? (($tour->price_adult ?? $tour->price ?? 0) / 2)) : ($tour['price_child'] ?? (($tour['price_adult'] ?? $tour['price'] ?? 0) / 2)) }}">

                            <div class="space-y-4 mb-6">
                                <!-- Currency Selector -->
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                        Currency
                                    </label>
                                    <select id="currency-selector" name="currency" onchange="updatePrice()" class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                        <option value="USD" data-symbol="$" data-rate="1">USD ($)</option>
                                        <option value="EUR" data-symbol="€" data-rate="0.92">EUR (€)</option>
                                        <option value="GBP" data-symbol="£" data-rate="0.79">GBP (£)</option>
                                        <option value="JPY" data-symbol="¥" data-rate="151">JPY (¥)</option>
                                        <option value="CAD" data-symbol="C$" data-rate="1.36">CAD (C$)</option>
                                        <option value="AUD" data-symbol="A$" data-rate="1.53">AUD (A$)</option>
                                        <option value="INR" data-symbol="₹" data-rate="83">INR (₹)</option>
                                        <option value="TZS" data-symbol="TSh" data-rate="2500">TZS (TSh)</option>
                                    </select>
                                </div>

                                <!-- Travel Date -->
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                        Travel Date
                                    </label>
                                    <input type="date" name="travel_date" id="travel-date" required class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                </div>

                                <!-- Adults -->
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                        Adults
                                    </label>
                                    <input type="number" name="adults" id="adults-input" min="1" value="1" onchange="updatePrice()" oninput="updatePrice()" required class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                </div>

                                <!-- Children -->
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                        Children (Optional)
                                    </label>
                                    <input type="number" name="children" id="children-input" min="0" value="0" onchange="updatePrice()" oninput="updatePrice()" class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                        Email
                                    </label>
                                    <input type="email" name="email" id="email-input" required class="w-full px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;" placeholder="your@email.com">
                                </div>

                                <!-- Phone Number -->
                                <div>
                                    <label class="block text-xs font-semibold mb-1.5" style="color: #5a3e2b;">
                                        Phone Number
                                    </label>
                                    <div class="flex gap-2 w-full overflow-hidden">
                                        <div class="flex items-center gap-2 px-3 py-2.5 rounded-lg border flex-shrink-0" style="border-color: rgba(133,66,8,0.2);">
                                            <span id="country-flag" class="text-2xl">🇹🇿</span>
                                            <select id="country-code-selector" name="country_code" onchange="updateFlag()" class="bg-transparent text-sm focus:outline-none min-w-0" style="color: #111111;">
                                                <option value="+255" data-flag="🇹🇿">TZ (+255)</option>
                                                <option value="+1" data-flag="🇺🇸">US (+1)</option>
                                                <option value="+44" data-flag="🇬🇧">UK (+44)</option>
                                                <option value="+49" data-flag="🇩🇪">DE (+49)</option>
                                                <option value="+254" data-flag="🇰🇪">KE (+254)</option>
                                                <option value="+27" data-flag="🇿🇦">ZA (+27)</option>
                                                <option value="+91" data-flag="🇮🇳">IN (+91)</option>
                                                <option value="+61" data-flag="🇦🇺">AU (+61)</option>
                                                <option value="+1" data-flag="🇨🇦">CA (+1)</option>
                                                <option value="+33" data-flag="🇫🇷">FR (+33)</option>
                                            </select>
                                        </div>
                                        <input type="tel" name="phone_number" id="phone-input" required class="flex-1 min-w-0 px-4 py-2.5 rounded-lg text-sm border focus:outline-none focus:ring-2" style="border-color: rgba(133,66,8,0.2); color: #111111;" placeholder="+255 712 345 678" oninput="detectCountryCode()">
                                    </div>
                                </div>
                            </div>

                            @php
                                $adultPrice = is_object($tour) ? ($tour->price_adult ?? $tour->price ?? 0) : ($tour['price_adult'] ?? $tour['price'] ?? 0);
                                $childPrice = is_object($tour) ? ($tour->price_child ?? ($adultPrice / 2)) : ($tour['price_child'] ?? ($adultPrice / 2));
                            @endphp
                            <div class="border-t pt-4 mb-6 space-y-2" style="border-color: rgba(133,66,8,0.1);">
                                <div class="flex justify-between text-sm">
                                    <span style="color: #5a3e2b;">Price per adult</span>
                                    <span id="price-per-person" style="color: #111111;">${{ number_format($adultPrice, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span style="color: #5a3e2b;">Price per child</span>
                                    <span id="price-per-child" style="color: #111111;">${{ number_format($childPrice, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span style="color: #5a3e2b;">Adults</span>
                                    <span id="adults-count" style="color: #111111;">1</span>
                                </div>
                                <div id="children-row" class="flex justify-between text-sm hidden">
                                    <span style="color: #5a3e2b;">Children</span>
                                    <span id="children-count" style="color: #111111;">0</span>
                                </div>
                                <div class="flex justify-between text-base font-bold pt-2 border-t" style="border-color: rgba(133,66,8,0.1);">
                                    <span style="color: #854208;">Total</span>
                                    <span id="total-price" style="color: #088529;">${{ number_format($adultPrice, 2) }}</span>
                                </div>
                                <input type="hidden" name="total_price" id="total-price-hidden" value="{{ number_format($adultPrice, 2) }}">
                            </div>

                            <button type="submit" class="w-full py-3.5 rounded-full text-sm font-semibold text-white transition-all duration-300 hover:opacity-90" style="background: #088529;">
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

@section('scripts')
    <script>
        const basePriceUSD = {{ is_object($tour) ? ($tour->price_adult ?? $tour->price ?? 0) : ($tour['price_adult'] ?? $tour['price'] ?? 0) }};
        const baseChildPriceUSD = {{ is_object($tour) ? ($tour->price_child ?? (($tour->price_adult ?? $tour->price ?? 0) / 2)) : ($tour['price_child'] ?? (($tour['price_adult'] ?? $tour['price'] ?? 0) / 2)) }};
        
        function updatePrice() {
            // Get selected currency
            const currencySelect = document.getElementById('currency-selector');
            const selectedOption = currencySelect.options[currencySelect.selectedIndex];
            const symbol = selectedOption.dataset.symbol;
            const rate = parseFloat(selectedOption.dataset.rate);
            
            // Get number of adults and children
            const adults = Math.max(1, parseInt(document.getElementById('adults-input').value) || 1);
            const children = Math.max(0, parseInt(document.getElementById('children-input').value) || 0);
            
            // Calculate prices
            const pricePerPerson = (basePriceUSD * rate);
            const pricePerChild = (baseChildPriceUSD * rate);
            const adultTotal = pricePerPerson * adults;
            const childTotal = pricePerChild * children;
            const totalPrice = (adultTotal + childTotal).toFixed(2);
            
            // Update UI
            document.getElementById('price-per-person').textContent = `${symbol}${pricePerPerson.toFixed(2)}`;
            document.getElementById('price-per-child').textContent = `${symbol}${pricePerChild.toFixed(2)}`;
            document.getElementById('adults-count').textContent = adults;
            document.getElementById('total-price').textContent = `${symbol}${totalPrice}`;
            document.getElementById('total-price-hidden').value = totalPrice;
            
            // Show/hide children row
            const childrenRow = document.getElementById('children-row');
            if (children > 0) {
                childrenRow.classList.remove('hidden');
                document.getElementById('children-count').textContent = children;
            } else {
                childrenRow.classList.add('hidden');
            }
        }

        function updateFlag() {
            const countrySelect = document.getElementById('country-code-selector');
            const selectedOption = countrySelect.options[countrySelect.selectedIndex];
            const flag = selectedOption.dataset.flag;
            document.getElementById('country-flag').textContent = flag;
        }

        function detectCountryCode() {
            const phoneInput = document.getElementById('phone-input');
            const phoneValue = phoneInput.value;
            const countrySelect = document.getElementById('country-code-selector');
            
            // Check if starts with +
            if (phoneValue.startsWith('+')) {
                // Extract the numeric part after +
                let codePart = phoneValue.substring(1);
                
                // Try to match the longest possible country code first
                // Sort options by code length descending
                const sortedOptions = Array.from(countrySelect.options).sort((a, b) => 
                    b.value.length - a.value.length);
                
                for (let option of sortedOptions) {
                    const optionCode = option.value.replace('+', '');
                    if (codePart.startsWith(optionCode)) {
                        // Match found!
                        countrySelect.value = option.value;
                        updateFlag();
                        
                        // Remove the country code from the phone input, keeping the rest
                        const remainingDigits = codePart.substring(optionCode.length);
                        phoneInput.value = remainingDigits.trim();
                        break;
                    }
                }
            }
        }
    </script>
@endsection
