@extends('layouts.app')

@php
    $T = $tourData;
    $TTitle = $T['title'] ?? 'Tanzania Safari';
    $TDesc = \Illuminate\Support\Str::limit(strip_tags($T['overview'] ?? ''), 150);
    $TImage = $T['image'] ?? 'https://res.cloudinary.com/aenplcpl/image/upload/f_auto,q_auto,w_1920/v1782890323/safari-serengeti_agwjrp.jpg';
    $TCat = ucwords(str_replace('-', ' ', $T['category'] ?? 'tour'));
    $adultPrice = (float) ($T['price'] ?? 0);
    $childPrice = (float) (($T['db']['child'] ?? 0) ?: ($adultPrice / 2));
    $hasBooking = (bool) ($tour ?? null);
@endphp

@section('title', $TTitle)
@section('meta_title', $TTitle)
@section('meta_description', $TDesc)
@section('meta_keywords', $TTitle . ', Tanzania tour, Tanzania safari, ' . $TCat)
@section('meta_image', $TImage)

@section('structured_data')
@php
    $reviewAggregate = count($T['reviews'] ?? []) > 0 ? [
        '@type' => 'aggregateRating',
        'ratingValue' => (string) ($T['rating'] ?? '5'),
        'reviewCount' => (string) count($T['reviews'] ?? []),
    ] : null;
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'TouristTrip',
        'name' => $TTitle,
        'description' => \Illuminate\Support\Str::limit(strip_tags($T['overview'] ?? ''), 200),
        'touristType' => 'Wildlife enthusiast',
        'duration' => $T['duration'] ?? '',
        'image' => $TImage,
        'provider' => [
            '@type' => 'TravelAgency',
            'name' => 'Tanzania Daily Tours & Safari',
            'url' => 'https://www.tanzaniadailytoursandsafari.com',
        ],
    ];
    if ($adultPrice > 0) {
        $structuredData['offers'] = [
            '@type' => 'Offer',
            'price' => (string) $adultPrice,
            'priceCurrency' => 'USD',
            'availability' => 'https://schema.org/InStock',
        ];
    }
    if ($reviewAggregate) {
        $structuredData['aggregateRating'] = $reviewAggregate;
    }
@endphp
<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

<!-- PAGE HERO -->
<section class="page-hero">
  <img class="hero-bg" src="{{ $TImage }}" alt="{{ $TTitle }}" />
  <div class="container">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span>/</span>
      <a href="{{ route('destinations') }}">Destinations</a>
      <span>/</span>
      <span>{{ $TTitle }}</span>
    </nav>
    <span class="eyebrow eyebrow-light">{{ $TCat }}</span>
    <h1>{{ $TTitle }}</h1>
    <p class="hero-copy">
      <i class="fas fa-map-marker-alt"></i> {{ $T['location'] ?? '' }}
      &nbsp;•&nbsp; <i class="fas fa-clock"></i> {{ $T['duration'] ?? '' }}
      @if($adultPrice > 0)
        &nbsp;•&nbsp; <i class="fas fa-tag"></i> From <span data-price-currency>USD</span> {{ number_format($adultPrice, 2) }} per person
      @else
        &nbsp;•&nbsp; <i class="fas fa-tag"></i> Price on request
      @endif
    </p>
  </div>
</section>

<!-- CONTENT -->
<section class="page-section" style="background:#f8f4f0;">
  <div class="container">
    <div class="page-detail-grid">
      <!-- Main Content -->
      <div class="main-col">

        <div class="detail-card">
          <h2><span class="mm">01</span>{{ $contents['destination_about_title']->value ?? 'About This Tour' }}</h2>
          <div class="overview-grid">
            <div class="tour-desc">
              {!! $T['overview'] ?? '' !!}
              <p>Every detail is handled by our local team — from pickup and guiding to meals, park fees and accommodation. This is a complete travel product, not just a short description.</p>
            </div>
            @if(count($T['quickFacts'] ?? []))
            <div class="quick-facts">
              <h4>Quick Facts</h4>
              @foreach($T['quickFacts'] as $k => $v)
                <div class="qf-item"><div class="qf-label">{{ $k }}</div><div class="qf-value">{{ $v }}</div></div>
              @endforeach
            </div>
            @endif
          </div>

          @if(count($T['highlights'] ?? []))
            <h2 style="margin-top:36px"><span class="mm">02</span> Highlights</h2>
            <div class="highlights-grid">
              @foreach($T['highlights'] as $h)
                <div class="hl-item"><i class="fas {{ $h['icon'] }}"></i><span>{{ $h['text'] }}</span></div>
              @endforeach
            </div>
          @endif
        </div>

        @if(count($T['itinerary'] ?? []))
        <div class="detail-card">
          <h2><span class="mm">03</span> Detailed Itinerary</h2>
          <p style="color:var(--muted);margin-bottom:24px;">A moment-by-moment breakdown of your journey.</p>
          <div class="itinerary">
            @foreach($T['itinerary'] as $d)
              <div class="itin-item">
                <div class="itin-head">
                  <span class="itin-label">{{ $d['label'] }}</span>
                  <span class="itin-title">{{ $d['title'] }}</span>
                </div>
                <p class="itin-desc">{{ $d['desc'] }}</p>
                <div class="itin-details">
                  @if(!empty($d['activities']) && $d['activities'] !== '—')
                    <span><i class="fas fa-binoculars"></i>{{ $d['activities'] }}</span>
                  @endif
                  @if(!empty($d['meals']) && $d['meals'] !== '—')
                    <span><i class="fas fa-utensils"></i>{{ $d['meals'] }}</span>
                  @endif
                  @if(!empty($d['accommodation']) && $d['accommodation'] !== '—')
                    <span><i class="fas fa-bed"></i>{{ $d['accommodation'] }}</span>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @endif

        @if(count($T['included'] ?? []) || count($T['excluded'] ?? []))
        <div class="detail-card">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            @if(count($T['included'] ?? []))
            <div class="inc-panel">
              <h4>Included in Your Tour</h4>
              <ul>
                @foreach($T['included'] as $i)
                  <li><i class="fas fa-check"></i>{{ $i }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            @if(count($T['excluded'] ?? []))
            <div class="exc-panel">
              <h4>Excluded from Your Tour</h4>
              <ul>
                @foreach($T['excluded'] as $i)
                  <li><i class="fas fa-times"></i>{{ $i }}</li>
                @endforeach
              </ul>
            </div>
            @endif
          </div>
        </div>
        @endif

        @if(count($T['faqs'] ?? []))
        <div class="detail-card">
          <h2><span class="mm">04</span> Frequently Asked Questions</h2>
          <div class="faq-list">
            @foreach($T['faqs'] as $i => $f)
              <div class="faq-item">
                <div class="faq-q"><span class="faq-qmark" aria-hidden="true">Q</span><span>{{ $f['q'] }}</span></div>
                <div class="faq-a"><span class="faq-amark" aria-hidden="true">A</span><p>{{ $f['a'] }}</p></div>
              </div>
            @endforeach
          </div>
        </div>
        @endif

        @if(count($T['gallery'] ?? []))
        <div class="detail-card">
          <h2><span class="mm">05</span> Gallery</h2>
          <div class="tour-gallery">
            @foreach($T['gallery'] as $i => $src)
              <div class="gal-item" data-lb="{{ $i }}" data-src="{{ $src }}" data-caption="{{ $TTitle }} — photo {{ $i + 1 }}" role="button" tabindex="0" aria-label="Open image: {{ $TTitle }} photo {{ $i + 1 }}">
                <img src="{{ $src }}" alt="{{ $TTitle }} gallery {{ $i + 1 }}" loading="lazy" />
                <div class="gal-overlay"><i class="fas fa-search-plus"></i></div>
              </div>
            @endforeach
          </div>
        </div>
        @endif

        @if(count($T['reviews'] ?? []))
        <div class="detail-card">
          <h2><span class="mm">06</span> Traveler Reviews</h2>
          @foreach($T['reviews'] as $r)
            <div style="background:var(--light);padding:24px;border-left:4px solid var(--accent);border-radius:4px;margin-bottom:14px">
              <div style="color:var(--accent);letter-spacing:4px;margin-bottom:10px">★★★★★</div>
              <p style="font-style:italic;color:var(--muted);line-height:1.7;margin-bottom:12px">"{{ $r['text'] }}"</p>
              <div style="font-size:.75rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--primary)">{{ $r['author'] }}
                <span style="color:var(--muted);font-weight:500"> • {{ $r['country'] }}</span>
              </div>
            </div>
          @endforeach
        </div>
        @endif

        <!-- Related Tours -->
        @if(count($relatedTours))
        <div class="detail-card">
          <h2><span class="mm">07</span>{{ $contents['destination_related_title']->value ?? 'You May Also Like' }}</h2>
          <div class="related-list">
            @foreach($relatedTours as $related)
              <a href="{{ route('destination.detail', $related['slug']) }}" class="related-row">
                <img src="{{ $related['image'] }}" alt="{{ $related['title'] }}" loading="lazy" />
                <div>
                  <h4>{{ $related['title'] }}</h4>
                  <p>{{ $related['duration'] }} • {{ $related['price'] > 0 ? 'From $' . number_format($related['price'], 2) : 'Price on request' }}</p>
                </div>
              </a>
            @endforeach
          </div>
        </div>
        @endif
      </div>

      <!-- Sidebar - Booking Card -->
      <aside class="book-sidebar">
        @if(session('success'))
          <div class="alert-box">{{ session('success') }}</div>
        @endif

        @if($hasBooking)
        <h3>Book This Tour</h3>
        <form id="booking-form" method="POST" action="{{ route('bookings.store') }}">
          @csrf
          <input type="hidden" name="destination_id" value="{{ $tour->id }}">
          <input type="hidden" name="tour_name" value="{{ $TTitle }}">
          <input type="hidden" name="phone_number" id="phone-number-hidden">

          <div class="form-group-sm">
            <label class="field-sm" for="name-input">Full Name</label>
            <input type="text" name="name" id="name-input" required class="form-control" placeholder="John Doe">
          </div>

          <div class="form-group-sm">
            <label class="field-sm" for="currency-selector">Currency</label>
            <select id="currency-selector" name="currency" onchange="updatePrice()" class="form-control">
              @foreach(\App\Helpers\CurrencyHelper::$exchangeRates as $code => $rate)
                <option value="{{ $code }}" data-symbol="{{ \App\Helpers\CurrencyHelper::$currencySymbols[$code] }}" data-rate="{{ $rate }}" {{ $code === 'USD' ? 'selected' : '' }}>{{ $code }} ({{ \App\Helpers\CurrencyHelper::$currencySymbols[$code] }})</option>
              @endforeach
            </select>
          </div>

          <div class="form-group-sm">
            <label class="field-sm" for="travel-date">Travel Date</label>
            <input type="date" name="travel_date" id="travel-date" required class="form-control" min="{{ date('Y-m-d') }}">
          </div>

          <div class="form-group-sm">
            <label class="field-sm" for="adults-input">Adults</label>
            <input type="number" name="adults" id="adults-input" min="1" value="1" onchange="updatePrice()" oninput="updatePrice()" required class="form-control">
          </div>

          <div class="form-group-sm">
            <label class="field-sm" for="children-input">Children (Optional)</label>
            <input type="number" name="children" id="children-input" min="0" value="0" onchange="updatePrice()" oninput="updatePrice()" class="form-control">
          </div>

          <div class="form-group-sm">
            <label class="field-sm" for="email-input">Email</label>
            <input type="email" name="email" id="email-input" required class="form-control" placeholder="your@email.com">
          </div>

          <div class="form-group-sm">
            <label class="field-sm" for="phone-local-input">Phone Number *</label>
            <div class="phone-row">
              <div class="phone-cc">
                <span id="country-flag" class="text-2xl">🇹🇿</span>
                <select id="country-code-selector" name="country_code" onchange="updateFlagAndPhonePrefix()">
                  @foreach(\App\Helpers\CountryHelper::getCountries() as $country)
                    <option value="{{ $country['code'] }}" data-flag="{{ $country['flag'] }}" {{ $country['code'] === '+255' ? 'selected' : '' }}>{{ $country['name'] }} ({{ $country['code'] }})</option>
                  @endforeach
                </select>
              </div>
              <input type="tel" name="phone_local" id="phone-local-input" required class="form-control" placeholder="712 345 678" pattern="[0-9\s\-\(\)]+" oninput="detectCountryCode(); updateFullPhoneDisplay()">
            </div>
            <div class="mt-1 text-xs" style="color:#6b5643;font-size:.75rem;margin-top:6px;">
              Full number: <span id="full-phone-display" style="font-weight:700;color:#91400f;">+255 </span>
            </div>
          </div>

          <div class="price-break"><span>Price per adult</span><span id="price-per-person">${{ number_format($adultPrice, 2) }}</span></div>
          <div class="price-break"><span>Price per child</span><span id="price-per-child">${{ number_format($childPrice, 2) }}</span></div>
          <div class="price-break"><span>Adults</span><span id="adults-count">1</span></div>
          <div id="children-row" class="price-break" style="display:none;"><span>Children</span><span id="children-count">0</span></div>
          <div class="price-total"><span>Total</span><span id="total-price">${{ number_format($adultPrice, 2) }}</span></div>

          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:20px;">Book Now — Secure Your Spot</button>

          <ul class="trust-list">
            <li><i class="fas fa-check-circle"></i> Instant confirmation</li>
            <li><i class="fas fa-shield-halved"></i> Free cancellation up to 24 hours</li>
            <li><i class="fas fa-star"></i> 4.8/5 customer rating</li>
          </ul>

          @php
            $paymentsEnabled = \App\Services\PaymentSettings::isEnabled();
            $depositPct = $paymentsEnabled ? \App\Services\PaymentSettings::depositPercentage() : 0;
            $checkoutCurrency = in_array($tour->currency ?? '', ['TZS','KES','UGX','RWF','BIF','USD','EUR','GBP','ZAR','NGN','GHS','CAD','AUD'])
                ? ($tour->currency ?? 'USD') : (\App\Services\PaymentSettings::currency() ?: 'USD');
          @endphp
          @if($paymentsEnabled)
            <div class="pay-box" id="online-payment-box">
              <div class="pay-title"><i class="fas fa-credit-card"></i> Secure online payment</div>
              <p>After booking you'll be redirected to a secure PesaPal checkout.
                @if($depositPct > 0 && $depositPct < 100)
                  A deposit of <strong>{{ $depositPct }}%</strong> is due now <span id="deposit-amount" style="color:#91400f;"></span>; the balance is arranged before travel.
                @endif
              </p>
            </div>
            <div class="warn-box" id="unsupported-currency-box">
              <div class="pay-title" style="color:#b25e00;"><i class="fas fa-triangle-exclamation"></i> Online checkout in a different currency</div>
              <p>Online checkout isn't available in <strong id="unsupported-currency-name"></strong>. You'll be charged in <strong>{{ $checkoutCurrency }}</strong> at today's rate, paid by card, bank transfer or mobile money.</p>
            </div>
          @endif

          <div class="need-help">
            <a href="{{ route('contact') }}"><i class="fas fa-comments"></i> Need help? Contact us</a>
          </div>
        </form>
        @else
        <h3>Enquire About This Tour</h3>
        <p class="enquire-note">This experience is arranged on request. Send us your details and we'll reply within 24 hours with a personalised itinerary and quote.</p>
        <form method="POST" action="{{ route('contact.submit') }}" novalidate>
          @csrf
          <input type="hidden" name="interest" value="{{ $TTitle }}">
          <div class="form-group-sm">
            <label class="field-sm" for="enq-name">Full Name</label>
            <input type="text" id="enq-name" name="name" required class="form-control" placeholder="John Doe">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="enq-email">Email</label>
            <input type="email" id="enq-email" name="email" required class="form-control" placeholder="your@email.com">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="enq-phone">Phone / WhatsApp</label>
            <input type="tel" id="enq-phone" name="phone" class="form-control" placeholder="+255 712 345 678">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="enq-date">Travel Date</label>
            <input type="date" id="enq-date" name="travel_date" class="form-control" min="{{ date('Y-m-d') }}">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="enq-adults">Adults</label>
            <input type="number" id="enq-adults" name="adults" min="1" value="1" class="form-control">
          </div>
          <div class="form-group-sm">
            <label class="field-sm" for="enq-children">Children</label>
            <input type="number" id="enq-children" name="children" min="0" value="0" class="form-control">
          </div>
          <input type="hidden" name="message" id="enq-message">
          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:20px;">Request Itinerary & Quote</button>
          <ul class="trust-list">
            <li><i class="fas fa-check-circle"></i> Reply within 24 hours</li>
            <li><i class="fas fa-user-tie"></i> Personal safari consultant</li>
            <li><i class="fas fa-star"></i> 4.8/5 customer rating</li>
          </ul>
        </form>
        @endif
      </aside>
    </div>
  </div>
</section>
@endsection

@section('scripts')
    @if($hasBooking)
    <script>
        const basePriceUSD = {{ $adultPrice }};
        const baseChildPriceUSD = {{ $childPrice }};
        const pesapalCurrencies = @json(\App\Services\PesaPalService::SUPPORTED_CURRENCIES);
        const checkoutCurrency = @json($checkoutCurrency);
        const depositPercent = @json($depositPct);

        function updatePrice() {
            const currencySelect = document.getElementById('currency-selector');
            const selectedOption = currencySelect.options[currencySelect.selectedIndex];
            const currencyCode = currencySelect.value;
            const symbol = selectedOption.dataset.symbol;
            const rate = parseFloat(selectedOption.dataset.rate) || 1;

            const adults = Math.max(1, parseInt(document.getElementById('adults-input').value) || 1);
            const children = Math.max(0, parseInt(document.getElementById('children-input').value) || 0);

            const pricePerPerson = (parseFloat(basePriceUSD) * rate);
            const pricePerChild = (parseFloat(baseChildPriceUSD) * rate);
            const adultTotal = pricePerPerson * adults;
            const childTotal = pricePerChild * children;
            const totalPrice = (adultTotal + childTotal).toFixed(2);

            document.getElementById('price-per-person').textContent = `${symbol}${pricePerPerson.toFixed(2)}`;
            document.getElementById('price-per-child').textContent = `${symbol}${pricePerChild.toFixed(2)}`;
            document.getElementById('adults-count').textContent = adults;
            document.getElementById('total-price').textContent = `${symbol}${totalPrice}`;

            const childrenRow = document.getElementById('children-row');
            if (children > 0) {
                childrenRow.style.display = 'flex';
                document.getElementById('children-count').textContent = children;
            } else {
                childrenRow.style.display = 'none';
            }

            const priceCur = document.querySelector('[data-price-currency]');
            if (priceCur) priceCur.textContent = currencyCode;

            const paymentBox = document.getElementById('online-payment-box');
            const unsupportedBox = document.getElementById('unsupported-currency-box');
            if (!paymentBox || !unsupportedBox) return;

            const supported = pesapalCurrencies.includes(currencyCode);
            paymentBox.style.display = supported ? '' : 'none';
            unsupportedBox.style.display = supported ? 'none' : '';

            if (!supported) {
                document.getElementById('unsupported-currency-name').textContent = `${currencyCode} (${symbol})`;
                return;
            }

            const depositEl = document.getElementById('deposit-amount');
            if (depositEl && depositPercent > 0 && depositPercent < 100) {
                depositEl.textContent = `=${symbol}${(parseFloat(totalPrice) * depositPercent / 100).toFixed(2)}`;
            }
        }

        function updateFlagAndPhonePrefix() {
            const countrySelect = document.getElementById('country-code-selector');
            const flag = countrySelect.options[countrySelect.selectedIndex].dataset.flag;
            document.getElementById('country-flag').textContent = flag;
            updateFullPhoneDisplay();
        }

        function updateFullPhoneDisplay() {
            const countryCode = document.getElementById('country-code-selector').value;
            const phoneLocal = document.getElementById('phone-local-input').value.trim();
            document.getElementById('full-phone-display').textContent = countryCode + ' ' + phoneLocal;
        }

        function detectCountryCode() {
            const phoneLocalInput = document.getElementById('phone-local-input');
            const phoneLocalValue = phoneLocalInput.value;
            const countrySelect = document.getElementById('country-code-selector');

            if (phoneLocalValue.startsWith('+')) {
                let codePart = phoneLocalValue.substring(1);
                const sortedOptions = Array.from(countrySelect.options).sort((a, b) => b.value.length - a.value.length);
                for (let option of sortedOptions) {
                    const optionCode = option.value.replace('+', '');
                    if (codePart.startsWith(optionCode)) {
                        countrySelect.value = option.value;
                        updateFlagAndPhonePrefix();
                        phoneLocalInput.value = codePart.substring(optionCode.length).trim();
                        break;
                    }
                }
            }
            updateFullPhoneDisplay();
        }

        document.addEventListener('DOMContentLoaded', function() {
            try {
                const saved = localStorage.getItem('tdts_currency');
                if (saved) {
                    const sel = document.getElementById('currency-selector');
                    if (sel.querySelector('option[value="' + saved + '"]')) sel.value = saved;
                }
            } catch (e) { /* noop */ }
            updatePrice();
            document.getElementById('booking-form').addEventListener('submit', function(e) {
                const countryCode = document.getElementById('country-code-selector').value;
                const phoneLocal = document.getElementById('phone-local-input').value.trim();
                document.getElementById('phone-number-hidden').value = countryCode + phoneLocal;
            });
        });
    </script>
    @else
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.book-sidebar form');
            if (!form) return;
            form.addEventListener('submit', function() {
                const date = document.getElementById('enq-date').value;
                const adults = document.getElementById('enq-adults').value;
                const children = document.getElementById('enq-children').value;
                const phone = document.getElementById('enq-phone').value.trim();
                const title = (form.querySelector('input[name="interest"]').value || '').trim();
                document.getElementById('enq-message').value =
                    'Booking request for ' + title + '.' +
                    (date ? ' Travel date: ' + date + '.' : '') +
                    ' Adults: ' + adults + ', Children: ' + children + '.' +
                    (phone ? ' Phone: ' + phone + '.' : '');
            });
        });
    </script>
    @endif
@endsection