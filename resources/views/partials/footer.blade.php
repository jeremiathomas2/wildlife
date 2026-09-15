<!-- FOOTER -->
@php
    $brand = \App\Support\SafariContent::site();
    $logo = (isset($contents) && !empty($contents['logo_white']->value ?? null)) ? $contents['logo_white']->value : $brand['logos']['white'];
    $brandTag = trim((string)($brand['tagline'] ?? ''));
    if ($brandTag !== '' && stripos($brand['name'], $brandTag) !== false) {
        $brandTop = trim(str_ireplace($brandTag, '', $brand['name']));
        $brandBottom = $brandTag;
    } else {
        $brandTop = $brand['name'];
        $brandBottom = $brandTag;
    }
@endphp
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <a href="{{ route('home') }}" class="logo logo-wrap" aria-label="Tanzania Daily Tours & Safari home">
          <img class="logo-img" src="{{ $logo }}" alt="Tanzania Daily Tours & Safari" width="48" height="46" loading="lazy" />
          <span class="logo-text">
            <span class="logo-top">{{ $brandTop }}</span>
            <span class="logo-bottom">{{ $brandBottom }}</span>
          </span>
        </a>
        <p>Day trips, multi-day wildlife safaris, Kilimanjaro hikes, cultural tours and Zanzibar escapes — crafted by local experts in Tanzania.</p>
        <div class="footer-social">
          <a href="https://www.instagram.com/tanzania_dailytours_and_safari/" target="_blank" rel="noopener" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://www.facebook.com/tanzaniadailytoursandsafari" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="https://twitter.com/tanzaniadailytours" target="_blank" rel="noopener" aria-label="Twitter / X"><i class="fab fa-x-twitter"></i></a>
          <a href="https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html" target="_blank" rel="noopener" aria-label="TripAdvisor"><i class="fab fa-tripadvisor"></i></a>
        </div>
      </div>
      <div>
        <h5>Quick Links</h5>
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('destinations') }}">Destinations</a></li>
          <li><a href="{{ route('about') }}">About</a></li>
          <li><a href="{{ route('reviews') }}">Reviews</a></li>
          <li><a href="{{ route('gallery') }}">Gallery</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
        </ul>
      </div>
      <div>
        <h5>Popular Tours</h5>
        <ul>
          <li><a href="{{ route('destination.detail', 'materuni-waterfall-coffee-tour') }}">Materuni Waterfall</a></li>
          <li><a href="{{ route('destination.detail', 'chemka-hot-springs') }}">Chemka Hot Springs</a></li>
          <li><a href="{{ route('destination.detail', 'kilimanjaro-day-hike') }}">Kilimanjaro Day Hike</a></li>
          <li><a href="{{ route('destination.detail', '3-day-tarangire-ngorongoro-safari') }}">Tarangire & Ngorongoro</a></li>
          <li><a href="{{ route('destination.detail', 'serengeti-safari') }}">Serengeti Safari</a></li>
          <li><a href="{{ route('destination.detail', 'zanzibar-escape') }}">Zanzibar Escape</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h5>Contact</h5>
        <p><i class="fas fa-phone-alt"></i> <a href="tel:+255623975934">+255 623 975 934</a></p>
        <p><i class="fas fa-envelope"></i> <a href="mailto:info.tanzaniadailytours@gmail.com">info.tanzaniadailytours@gmail.com</a></p>
        <p><i class="fas fa-map-marker-alt"></i> Wakala wa Vipimo • Moshi • Kilimanjaro • Tanzania</p>
        <div class="footer-news">
          <label for="footerEmail" class="sr-only">Email for newsletter</label>
          <input type="email" id="footerEmail" placeholder="Your email" />
          <button type="button" id="footerSubscribe">JOIN</button>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© <span id="footerYear">2026</span> Tanzania Daily Tours & Safari. All rights reserved.</span>
      <div class="legal">
        <a href="{{ route('terms') }}">Terms</a>
        <a href="{{ route('privacy') }}">Privacy</a>
        <a href="#" data-cookie="manage">Cookies</a>
        <a href="{{ route('terms') }}#cancellation">Cancellation</a>
      </div>
    </div>
  </div>
</footer>