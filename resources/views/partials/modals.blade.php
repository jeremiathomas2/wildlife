<!-- BOOKING MODAL -->
<div class="modal-overlay" id="bookingModal" role="dialog" aria-modal="true" aria-labelledby="bookingTitle">
  <div class="modal-content form-modal">
    <button class="modal-close" id="bookingClose" aria-label="Close booking form">&times;</button>
    <div class="form-modal-head">
      <h3 id="bookingTitle">BOOK YOUR TANZANIA JOURNEY</h3>
      <p>Tell us about your trip and our team will reply within 24 hours.</p>
    </div>
    <form class="form-body" id="bookingForm" novalidate>
      <div class="form-group">
        <label for="bName">Full Name *</label>
        <input type="text" id="bName" required autocomplete="name" />
        <div class="err" id="eName">Please enter your full name.</div>
      </div>
      <div class="form-group">
        <label for="bEmail">Email *</label>
        <input type="email" id="bEmail" required autocomplete="email" />
        <div class="err" id="eEmail">Please enter a valid email address.</div>
      </div>
      <div class="form-group">
        <label for="bPhone">Phone / WhatsApp *</label>
        <input type="tel" id="bPhone" required autocomplete="tel" />
        <div class="err" id="ePhone">Please enter a phone number where we can reach you.</div>
      </div>
      <div class="form-group">
        <label for="bCountry">Country</label>
        <select id="bCountry"></select>
      </div>
      <div class="form-group full">
        <label for="bTour">Selected Tour *</label>
        <select id="bTour"><option value="">Select a tour</option></select>
      </div>
      <div class="form-group">
        <label for="bDate">Travel Date</label>
        <input type="date" id="bDate" />
      </div>
      <div class="form-group">
        <label for="bAdults">Adults</label>
        <select id="bAdults"><option>1</option><option selected>2</option><option>3</option><option>4+</option></select>
      </div>
      <div class="form-group">
        <label for="bChildren">Children</label>
        <select id="bChildren"><option selected>0</option><option>1</option><option>2</option><option>3+</option></select>
      </div>
      <div class="price-summary" id="priceSummary"></div>
      <div class="form-status" id="bStatus" role="status" aria-live="polite"></div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">SEND BOOKING REQUEST</button>
        <button type="button" class="btn btn-outline-dark" id="bookingCancel">CANCEL</button>
      </div>
    </form>
  </div>
</div>

<!-- CUSTOM SAFARI MODAL -->
<div class="modal-overlay" id="customModal" role="dialog" aria-modal="true" aria-labelledby="customTitle">
  <div class="modal-content form-modal">
    <button class="modal-close" id="customClose" aria-label="Close custom safari form">&times;</button>
    <div class="form-modal-head">
      <h3 id="customTitle">BUILD MY SAFARI</h3>
      <p>Tell us your dream and we'll craft a custom Tanzania itinerary for you.</p>
    </div>
    <form class="form-body" id="customForm" novalidate>
      <div class="form-group full">
        <label for="cDest">Destination(s)</label>
        <input type="text" id="cDest" placeholder="e.g. Serengeti, Ngorongoro, Zanzibar" />
      </div>
      <div class="form-group">
        <label for="cDates">Travel Dates</label>
        <input type="text" id="cDates" placeholder="e.g. July 2026" />
      </div>
      <div class="form-group">
        <label for="cTravelers">Number of Travelers</label>
        <input type="text" id="cTravelers" placeholder="e.g. 2 adults, 1 child" />
      </div>
      <div class="form-group">
        <label for="cBudget">Budget Range</label>
        <select id="cBudget">
          <option>Under $1,000 pp</option>
          <option>$1,000 – $2,500 pp</option>
          <option>$2,500 – $5,000 pp</option>
          <option>$5,000+ pp</option>
        </select>
      </div>
      <div class="form-group">
        <label for="cStyle">Safari Style</label>
        <select id="cStyle">
          <option>Budget</option>
          <option>Mid-Range</option>
          <option>Luxury</option>
          <option>Private</option>
          <option>Family</option>
          <option>Honeymoon</option>
        </select>
      </div>
      <div class="form-group">
        <label for="cAcc">Accommodation</label>
        <select id="cAcc">
          <option>Camping</option>
          <option>Tented Camps</option>
          <option>Lodges</option>
          <option>Luxury Lodges</option>
        </select>
      </div>
      <div class="form-group">
        <label for="cName">Full Name *</label>
        <input type="text" id="cName" required autocomplete="name" />
        <div class="err" id="eCName">Please enter your name.</div>
      </div>
      <div class="form-group">
        <label for="cEmail">Email *</label>
        <input type="email" id="cEmail" required autocomplete="email" />
        <div class="err" id="eCEmail">Please enter a valid email.</div>
      </div>
      <div class="form-group full">
        <label for="cActs">Preferred Activities</label>
        <input type="text" id="cActs" placeholder="e.g. Game drives, balloon safari, cultural visits" />
      </div>
      <div class="form-group full">
        <label for="cNotes">Special Requests</label>
        <textarea id="cNotes" rows="3"></textarea>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">REQUEST CUSTOM ITINERARY</button>
        <button type="button" class="btn btn-outline-dark" id="customCancel">CANCEL</button>
      </div>
    </form>
  </div>
</div>

<!-- COOKIE PREFERENCES MODAL -->
<div class="modal-overlay" id="cookieModal" role="dialog" aria-modal="true" aria-labelledby="cookieModalTitle">
  <div class="modal-content form-modal">
    <div class="form-modal-head">
      <h3 id="cookieModalTitle">COOKIE PREFERENCES</h3>
      <p>Choose which cookies we may use. Essential cookies are always on.</p>
    </div>
    <div class="form-body">
      <div class="pref-group" data-pref="essential">
        <div>
          <h4>Essential cookies</h4>
          <p>Required for the site to function. Always active.</p>
        </div>
        <label class="pref-toggle"><input type="checkbox" checked disabled /><span class="track"></span></label>
      </div>
      <div class="pref-group" data-pref="analytics">
        <div>
          <h4>Analytics</h4>
          <p>Anonymous usage stats help us improve the experience.</p>
        </div>
        <label class="pref-toggle"><input type="checkbox" /><span class="track"></span></label>
      </div>
      <div class="pref-group" data-pref="marketing">
        <div>
          <h4>Marketing & chat</h4>
          <p>Live chat support and marketing tools to help you plan.</p>
        </div>
        <label class="pref-toggle"><input type="checkbox" /><span class="track"></span></label>
      </div>
      <div class="pref-actions" style="grid-column:1/-1">
        <button class="btn btn-primary btn-sm pref-save" id="prefSave">SAVE PREFERENCES</button>
        <button class="btn btn-secondary btn-sm pref-all" id="prefAll">ACCEPT ALL</button>
      </div>
    </div>
  </div>
</div>

<!-- SEARCH OVERLAY -->
<div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="Search tours">
  <button class="search-close" id="searchClose" aria-label="Close search">&times;</button>
  <div class="search-panel">
    <label for="searchInput" class="sr-only">Search tours and destinations</label>
    <input type="search" id="searchInput" placeholder="Search tours, destinations, activities…" autocomplete="off" />
    <div class="search-hint">POPULAR: Safari • Kilimanjaro • Zanzibar • Day Trips</div>
    <div class="search-results" id="searchResults"></div>
  </div>
</div>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" role="dialog" aria-modal="true" aria-label="Image lightbox">
  <button class="lb-close" id="lbClose" aria-label="Close lightbox">&times;</button>
  <button class="lb-prev" id="lbPrev" aria-label="Previous image"><i class="fas fa-chevron-left"></i></button>
  <img id="lbImg" src="" alt="" />
  <div class="lb-counter" id="lbCounter"></div>
  <div class="lb-caption" id="lbCaption"></div>
  <div class="lb-strip" id="lbStrip"></div>
  <button class="lb-next" id="lbNext" aria-label="Next image"><i class="fas fa-chevron-right"></i></button>
</div>

<!-- TOAST -->
<div class="toast-wrap" id="toastWrap" aria-live="polite"></div>

<!-- WHATSAPP -->
<a href="https://wa.me/255623975934" class="wa-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<!-- MOBILE ACTION BAR -->
<div class="mobile-bar" aria-label="Quick actions">
  <button id="mobileSearch" class="mba-search" aria-label="Search tours"><i class="fas fa-search"></i>Search</button>
  <a href="tel:+255623975934" aria-label="Call us"><i class="fas fa-phone-alt"></i>Call</a>
  <a href="https://wa.me/255623975934" target="_blank" rel="noopener" aria-label="Chat on WhatsApp"><i class="fab fa-whatsapp"></i>WhatsApp</a>
  <button class="mba-cta" data-booking="true"><i class="fas fa-plane"></i>Book</button>
</div>

<!-- BACK TO TOP -->
<button class="to-top" id="toTop" aria-label="Back to top"><i class="fas fa-chevron-up"></i></button>