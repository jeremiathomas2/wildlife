/* =====================================================================
   Tanzania Daily Tours & Safari — Behavior
   Vanilla JS. Data lives in safari-data.js (window.TDTS).
   ===================================================================== */
(function () {
  'use strict';

  var D = window.TDTS || {};
  var SITE = D.SITE, HERO = D.HERO, TOURS = D.TOURS, GALLERY = D.GALLERY;
  var REVIEWS = D.REVIEWS, COUNTRIES = D.COUNTRIES, API = D.API;
  var FALLBACK_CURRENCIES = D.FALLBACK_CURRENCIES;

  /* ============================== HELPERS ============================== */
  var $ = function (s, c) { return (c || document).querySelector(s); };
  var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
  var esc = function (s) {
    return String(s == null ? '' : s)
      .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
  };
  var fmtNum = function (n) { return Math.round(n * 100) / 100; };
  var nfmt = function (n) {
    n = fmtNum(n);
    return n.toLocaleString('en-US', { maximumFractionDigits: 2 });
  };
  var store = {
    get: function (k, d) { try { var v = localStorage.getItem(k); return v === null ? d : JSON.parse(v); } catch (e) { return d; } },
    set: function (k, v) { try { localStorage.setItem(k, JSON.stringify(v)); } catch (e) { /* noop */ } },
    del: function (k) { try { localStorage.removeItem(k); } catch (e) { /* noop */ } }
  };

  /* ============================== TOASTS ============================== */
  function toast(title, msg, icon) {
    var wrap = $('#toastWrap'); if (!wrap) return;
    var el = document.createElement('div');
    el.className = 'toast';
    el.setAttribute('role', 'status');
    el.innerHTML = '<i class="fas fa-' + (icon || 'check-circle') + '"></i><div><strong>' + esc(title) + '</strong><p>' + esc(msg) + '</p></div>';
    wrap.appendChild(el);
    setTimeout(function () {
      el.style.transition = 'all .4s'; el.style.opacity = '0';
      el.style.transform = 'translateX(120%)';
      setTimeout(function () { el.remove(); }, 400);
    }, 4600);
  }

  /* ============================== CURRENCY ============================== */
  var rates = FALLBACK_CURRENCIES;
  var state = {
    currency: (function () { try { return localStorage.getItem('tdts_currency') || 'USD'; } catch (e) { return 'USD'; } })(),
    filter: 'all',
    sort: 'popular',
    searchOpen: false
  };
  var CURRENCY_ORDER = Object.keys(FALLBACK_CURRENCIES);

  function fmtPrice(usd) {
    var c = rates[state.currency] || rates.USD;
    var val = (usd || 0) * c.rate;
    var sym = c.symbol || '$';
    if (state.currency === 'JPY' || state.currency === 'INR') {
      return sym + nfmt(val);
    }
    if (['TZS', 'KES', 'UGX', 'IDR', 'VND'].indexOf(state.currency) !== -1) {
      return sym + Math.round(val).toLocaleString('en-US');
    }
    return sym + nfmt(val);
  }
  function applyRates() {
    var s = $('#curSel'), c = rates[state.currency];
    if (s) s.value = state.currency;
    renderTours();
    refreshEstimator();
  }
  function loadRates() {
    fetch(API.currencyRates, { headers: { Accept: 'application/json' } })
      .then(function (r) { if (!r.ok) throw new Error('rates'); return r.json(); })
      .then(function (data) {
        if (data && typeof data === 'object') {
          Object.keys(FALLBACK_CURRENCIES).forEach(function (k) {
            if (data[k] && typeof data[k].rate === 'number') {
              rates[k] = { rate: data[k].rate, symbol: (FALLBACK_CURRENCIES[k] || {}).symbol || data[k].symbol || '$' };
            }
          });
        }
        applyRates();
      })
      .catch(function () { applyRates(); });
  }

  /* ============================== MODALS ============================== */
  var lastFocus = null;
  var openStack = [];
  function openModal(id) {
    var m = $('#' + id); if (!m || m.classList.contains('open')) return;
    lastFocus = document.activeElement;
    m.classList.add('open');
    document.body.style.overflow = 'hidden';
    openStack.push(id);
    var f = m.querySelector('[autofocus], input:not([type=hidden]), select, textarea, button, a[href]');
    if (f) setTimeout(function () { f.focus(); }, 60);
  }
  function closeModal(id) {
    var m = $('#' + id); if (!m) return;
    m.classList.remove('open');
    var i = openStack.indexOf(id); if (i !== -1) openStack.splice(i, 1);
    if (openStack.length === 0) document.body.style.overflow = '';
    if (lastFocus) { try { lastFocus.focus(); } catch (e) { /* noop */ } lastFocus = null; }
  }
  function closeTopModal() {
    if (openStack.length) closeModal(openStack[openStack.length - 1]);
  }
  function trapFocus(e, root) {
    if (e.key !== 'Tab' || !root || !root.classList.contains('open')) return;
    var focusables = $$('a[href], button:not([disabled]), input, select, textarea, [tabindex]:not([tabindex="-1"])', root)
      .filter(function (el) { return el.offsetParent !== null || el === document.activeElement; });
    if (!focusables.length) return;
    var first = focusables[0], lastEl = focusables[focusables.length - 1];
    if (e.shiftKey && document.activeElement === first) { e.preventDefault(); lastEl.focus(); }
    else if (!e.shiftKey && document.activeElement === lastEl) { e.preventDefault(); first.focus(); }
  }
  document.addEventListener('keydown', function (e) {
    var active = openStack.length ? $('#' + openStack[openStack.length - 1]) : null;
    trapFocus(e, active);
    if (e.key === 'Escape') {
      if (state.searchOpen) { closeSearch(); return; }
      if ($('#lightbox').classList.contains('open')) { closeLB(); return; }
      closeTopModal();
      var mnav = $('#mobileNav');
      if (mnav.classList.contains('open')) { toggleMobile(null); }
    }
    if ($('#lightbox').classList.contains('open')) {
      if (e.key === 'ArrowRight') lbNext();
      if (e.key === 'ArrowLeft') lbPrev();
    } else if (state.searchOpen && e.key === 'ArrowDown') {
      e.preventDefault();
      var results = $$('.search-result');
      var idx = results.indexOf(document.activeElement);
      (results[idx + 1] || results[0]).focus();
    } else if (state.searchOpen && e.key === 'ArrowUp') {
      e.preventDefault();
      var results2 = $$('.search-result');
      var idx2 = results2.indexOf(document.activeElement);
      (results2[idx2 - 1] || results2[results2.length - 1]).focus();
    }
  });

  /* ============================== NAVIGATION ============================== */
  var mainNav = $('#mainNav'), topBar = $('.top-bar');
  var progressBar = $('#progressBar');
  function onScroll() {
    var y = window.scrollY;
    mainNav.classList.toggle('sticky', y > 180);
    if (topBar) topBar.style.display = y > 180 ? 'none' : '';
    $('#toTop').classList.toggle('show', y > 600);
    var doc = document.documentElement;
    var h = doc.scrollHeight - doc.clientHeight;
    if (progressBar) progressBar.style.width = (h > 0 ? (y / h) * 100 : 0) + '%';
    var ids = ['tours', 'destinations', 'about', 'reviews', 'gallery', 'guide'];
    var current = '';
    ids.forEach(function (id) {
      var sec = document.getElementById(id);
      if (sec && sec.getBoundingClientRect().top < 140) current = id;
    });
    $$('.nav-links > li > a[data-spy]').forEach(function (a) {
      a.classList.toggle('active', a.getAttribute('data-spy') === current);
    });
    animateCounters();
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();

  function toggleMobile(force) {
    var mnav = $('#mobileNav'), btn = $('#menuBtn');
    var open = typeof force === 'boolean' ? force : !mnav.classList.contains('open');
    mnav.classList.toggle('open', open);
    btn.classList.toggle('open', open);
    btn.setAttribute('aria-expanded', String(open));
    document.body.style.overflow = open ? 'hidden' : '';
    if (open && btn) btn.focus();
  }
  function bindMobileNav() {
    var btn = $('#menuBtn');
    if (btn) btn.addEventListener('click', function () { toggleMobile(); });
    var cl = $('#mobileClose');
    if (cl) cl.addEventListener('click', function () { toggleMobile(false); });
    $$('#mobileNav a, #mobileNav button:not(.mobile-close)').forEach(function (el) {
      el.addEventListener('click', function () { toggleMobile(false); });
    });
  }

  /* ============================== HERO ============================== */
  function renderHero() {
    var wrap = $('#heroSlides'); if (!wrap) return;
    wrap.innerHTML = HERO.map(function (h, i) {
      return '<div class="hero-slide' + (i === 0 ? ' active' : '') + '" data-slide="' + i + '">' +
        '<img src="' + h.img + '" alt="' + esc(h.alt) + '"' + (h.priority ? ' fetchpriority="high"' : ' loading="lazy"') + ' />' +
        '<div class="hero-overlay"></div><div class="hero-fade"></div></div>';
    }).join('');
  }
  var heroSlides, heroDots, heroTimer, heroIdx = 0;
  function goHero(i) {
    heroSlides.forEach(function (s) { s.classList.remove('active'); });
    heroDots.forEach(function (d) { d.classList.remove('active'); d.setAttribute('aria-selected', 'false'); });
    heroSlides[i].classList.add('active');
    heroDots[i].classList.add('active');
    heroDots[i].setAttribute('aria-selected', 'true');
    $('#heroTitle').innerHTML = HERO[i].title;
    $('#heroSub').textContent = HERO[i].sub;
    $('#heroCopy').textContent = HERO[i].copy;
    $('#heroCurrent').textContent = String(i + 1).padStart(2, '0');
    heroIdx = i;
  }
  function heroNext() { goHero((heroIdx + 1) % heroSlides.length); }
  function heroPrev() { goHero((heroIdx - 1 + heroSlides.length) % heroSlides.length); }
  function stopHero() { if (heroTimer) { clearInterval(heroTimer); heroTimer = null; } }
  function startHero() {
    stopHero();
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      heroTimer = setInterval(heroNext, 10000);
    }
  }
  function initHero() {
    renderHero();
    heroSlides = $$('.hero-slide');
    heroDots = $$('.hero-dots button');
    if (!heroSlides.length) return;
    heroDots.forEach(function (d) {
      d.addEventListener('click', function () { goHero(parseInt(d.dataset.go, 10)); startHero(); });
    });
    var hp = $('#heroPrev'), hn = $('#heroNext');
    if (hp) hp.addEventListener('click', function () { heroPrev(); startHero(); });
    if (hn) hn.addEventListener('click', function () { heroNext(); startHero(); });
    var heroEl = $('#hero');
    if (heroEl) {
      heroEl.addEventListener('mouseenter', stopHero);
      heroEl.addEventListener('mouseleave', startHero);
      heroEl.addEventListener('touchstart', stopHero, { passive: true });
    }
    startHero();
  }

  /* ============================== RENDER TOURS ============================== */
  function tourHref(t) {
    var base = (SITE.base || '').replace(/\/+$/, '');
    if (t.category === 'custom' || t.id === 'custom-safari') return base + '/contact';
    return base + '/destinations/' + encodeURIComponent(t.slug || t.id);
  }
  function renderTours() {
    var grid = $('#toursGrid'); if (!grid) return;
    var limit = grid.getAttribute('data-limit');
    var list = TOURS.slice();
    var filter = state.filter;
    if (filter !== 'all') list = list.filter(function (t) {
      if (filter === 'safari') return t.category === 'safari';
      return t.category === filter;
    });
    if (limit) list = list.slice(0, parseInt(limit, 10) || 6);
    var sort = state.sort;
    if (sort === 'price-asc') list.sort(function (a, b) { return a.price - b.price; });
    else if (sort === 'price-desc') list.sort(function (a, b) { return b.price - a.price; });
    else if (sort === 'duration') list.sort(function (a, b) { return a.durationDays - b.durationDays; });
    else list.sort(function (a, b) { return b.popularity - a.popularity; });

    if (!list.length) {
      grid.innerHTML = '<div class="tour-empty">No tours match this filter yet — try another category.</div>';
      return;
    }
    grid.innerHTML = list.map(function (t) {
      var href = tourHref(t);
      return '<article class="tour-card reveal" data-tour-id="' + esc(t.id) + '">' +
        '<a class="tour-card-link" href="' + esc(href) + '" aria-label="View details for ' + esc(t.title) + '"></a>' +
        '<div class="tour-card-img">' +
        '<img src="' + esc(t.image) + '" alt="' + esc(t.title) + '" loading="lazy" width="640" height="427" />' +
        '<span class="tour-badge">' + esc((t.category || '').replace(/-/g, ' ').toUpperCase()) + '</span>' +
        '<div class="tour-price"><small>From</small>' + (t.price > 0 ? fmtPrice(t.price) : 'On Request') + '</div>' +
        '</div><div class="tour-body">' +
        '<div class="tour-meta">' +
        '<span><i class="fas fa-map-marker-alt"></i>' + esc(t.location.split('\u2022')[0].trim()) + '</span>' +
        '<span><i class="fas fa-clock"></i>' + esc(t.duration) + '</span></div>' +
        '<h3>' + esc(t.title) + '</h3>' +
        '<p>' + esc(t.overview.substring(0, 110)) + '...</p>' +
        '<div class="tour-foot">' +
        '<a class="tour-link" href="' + esc(href) + '">VIEW DETAILS <i class="fas fa-arrow-right"></i></a>' +
        '<span class="tour-rating">\u2605 ' + esc(t.rating) + '</span></div>' +
        '</div></article>';
    }).join('');
    observeReveals();
  }

  $$('.filter-tabs button').forEach(function (b) {
    b.addEventListener('click', function () {
      $$('.filter-tabs button').forEach(function (x) { x.classList.remove('active'); });
      b.classList.add('active');
      state.filter = b.dataset.filter || 'all';
      renderTours();
    });
  });
  var sortSel = $('#sortSel');
  if (sortSel) sortSel.addEventListener('change', function (e) { state.sort = e.target.value; renderTours(); });

  function setFilter(filter) {
    state.filter = filter;
    $$('.filter-tabs button').forEach(function (x) { x.classList.toggle('active', x.dataset.filter === filter); });
    renderTours();
  }

  /* ============================== PAGE NAVIGATION ============================== */
  document.addEventListener('click', function (e) {
    var q = e.target.closest('.faq-q');
    if (q) {
      var item = q.parentElement;
      item.classList.toggle('open');
      q.setAttribute('aria-expanded', item.classList.contains('open') ? 'true' : 'false');
      return;
    }
    var openBtn = e.target.closest('[data-tour-open]');
    if (openBtn) {
      e.preventDefault();
      var t = TOURS.find(function (x) { return String(x.id) === String(openBtn.dataset.tourOpen); });
      if (t) window.location.href = tourHref(t);
      return;
    }
    var tourLink = e.target.closest('[data-tour]');
    if (tourLink) {
      e.preventDefault();
      var t2 = TOURS.find(function (x) { return String(x.slug) === tourLink.dataset.tour || String(x.id) === tourLink.dataset.tour; });
      if (t2) window.location.href = tourHref(t2);
      return;
    }
    var card = e.target.closest('.tour-card');
    if (card && !e.target.closest('a')) {
      e.preventDefault();
      var cardLink = card.querySelector('.tour-card-link');
      if (cardLink) window.location.href = cardLink.href;
      return;
    }
    var catCard = e.target.closest('[data-filter]');
    if (catCard && !e.target.closest('.filter-tabs')) {
      e.preventDefault();
      var f = catCard.dataset.filter || 'all';
      setFilter(f);
      var homeTours = document.getElementById('tours');
      if (homeTours) homeTours.scrollIntoView({ behavior: 'smooth', block: 'start' });
      return;
    }
  });

  /* ============================== BOOKING ============================== */
  function parseCount(v) { var n = parseInt(v, 10); return isNaN(n) ? 1 : n; }
  function selectedTour() {
    var v = $('#bTour').value;
    return TOURS.find(function (t) { return t.id === v; });
  }
  function refreshEstimator() {
    var box = $('#priceSummary'); if (!box) return;
    var t = selectedTour();
    if (!t || t.price <= 0) { box.classList.remove('show'); return; }
    var adults = parseCount($('#bAdults').value);
    var children = parseCount($('#bChildren').value);
    var adultFee = t.price;
    var childFee = Math.round(t.price / 2);
    var c = rates[state.currency] || rates.USD;
    var depositPct = (typeof D.DEPOSIT_PERCENT === 'number' && D.DEPOSIT_PERCENT > 0) ? D.DEPOSIT_PERCENT : 20;
    box.classList.add('show');
    box.innerHTML =
      '<h4>Estimated Price</h4>' +
      '<div class="ps-row"><span>' + esc(t.title) + '</span><span>' + fmtPrice(adultFee) + ' / adult</span></div>' +
      '<div class="ps-row"><span>' + adults + ' adult' + (adults > 1 ? 's' : '') + '</span><span>' + fmtPrice(adultFee * adults) + '</span></div>' +
      '<div class="ps-row"><span>' + children + ' child' + (children === 1 ? '' : 'ren') + ' (50%)</span><span>' + fmtPrice(childFee * children) + '</span></div>' +
      '<div class="ps-row total"><span>Estimated total</span><b>' + fmtPrice((adultFee * adults) + (childFee * children)) + ' ' + esc(state.currency) + '</b></div>' +
      '<p class="ps-note">A ' + depositPct + '% deposit secures this booking paid online. Final amount confirmed on quote. Converted via live rates (1 USD = ' + nfmt(c.rate) + ' ' + esc(state.currency) + ').</p>';
  }

  function openBooking(tourId) {
    var sel = $('#bTour');
    sel.innerHTML = '<option value="">Select a tour</option>' + TOURS.map(function (t) {
      return '<option value="' + esc(t.id) + '"' + (t.id === tourId ? ' selected' : '') + '>' + esc(t.title) + '</option>';
    }).join('');
    if (tourId) refreshEstimator();
    clearBookingStatus();
    openModal('bookingModal');
  }

  $$('[data-booking="true"]').forEach(function (b) {
    b.addEventListener('click', function (e) { e.preventDefault(); openBooking(); });
  });
  if ($('#bookingClose')) $('#bookingClose').addEventListener('click', function () { closeModal('bookingModal'); });
  if ($('#bookingCancel')) $('#bookingCancel').addEventListener('click', function () { closeModal('bookingModal'); });
  var bookingModal = $('#bookingModal');
  if (bookingModal) bookingModal.addEventListener('click', function (e) { if (e.target.id === 'bookingModal') closeModal('bookingModal'); });
  ['#bTour', '#bAdults', '#bChildren'].forEach(function (s) {
    var el = $(s); if (el) el.addEventListener('change', refreshEstimator);
  });

  function postJSON(url, payload) {
    return fetch(url, {
      method: 'POST',
      redirect: 'manual',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      body: JSON.stringify(payload)
    });
  }
  function isSuccess(res) {
    if (!res) return false;
    if (res.type === 'opaqueredirect') return true;
    return res.ok;
  }

  function enqueue(payload, kind) {
    var q = store.get('tdts_pending', []);
    q.push({ kind: kind, payload: payload, at: Date.now() });
    store.set('tdts_pending', q);
  }
  function flushQueue() {
    var q = store.get('tdts_pending', []);
    if (!q.length) return;
    q.forEach(function (item) {
      var url = item.kind === 'booking' ? API.bookings : API.contact;
      postJSON(url, item.payload).then(function (res) {
        if (isSuccess(res)) { /* delivered */ }
      });
    });
    store.del('tdts_pending');
  }

  function fallbackManual(kind, payload) {
    enqueue(payload, kind);
    var lines = [
      'Name: ' + (payload.name || ''),
      'Email: ' + (payload.email || ''),
      'Tour: ' + (payload.tour_name || payload.interest || ''),
      'Date: ' + (payload.travel_date || ''),
      'Adults: ' + (payload.adults || ''),
      'Children: ' + (payload.children || 0),
      'Message: ' + (payload.message || payload.pickup || '')
    ];
    var wa = 'https://wa.me/' + SITE.whatsapp + '?text=' + encodeURIComponent(lines.join('\n'));
    var mail = 'mailto:' + SITE.email + '?subject=' + encodeURIComponent('Inquiry — ' + (payload.tour_name || payload.interest || 'Tanzania')) + '&body=' + encodeURIComponent(lines.join('\n'));
    toast('OFFLINE — SAVED', 'We\'ll submit this automatically when you\'re back online. You can also send it directly now.', 'cloud');
    setTimeout(function () {
      window.open(wa, '_blank', 'noopener');
    }, index && 600);
    toast('SEND VIA EMAIL', 'Prefer email? We\'ve opened a draft for you.', 'envelope');
    window.open(mail, '_blank', 'noopener');
  }
  var index = 0;

  function setBookingStatus(res) {
    var box = $('#bStatus');
    if (res) { box.className = 'form-status ok'; box.textContent = res; }
    else { box.className = ''; box.textContent = ''; }
  }
  function clearBookingStatus() { setBookingStatus(''); }

  function submitBooking(e) {
    if (e) e.preventDefault();
    var ok = true;
    var nameEl = $('#bName'), emailEl = $('#bEmail'), phoneEl = $('#bPhone');
    $('#eName').classList.remove('show');
    $('#eEmail').classList.remove('show');
    $('#ePhone').classList.remove('show');
    if (!nameEl.value.trim()) { $('#eName').classList.add('show'); ok = false; }
    if (!emailEl.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) { $('#eEmail').classList.add('show'); ok = false; }
    if (!phoneEl.value.trim()) { $('#ePhone').classList.add('show'); ok = false; }
    var t = selectedTour();
    if (!t) { toast('SELECT A TOUR', 'Please choose the tour you\'d like to book.', 'exclamation-circle'); ok = false; }
    if (!ok) return;

    var payload = {
      name: nameEl.value.trim(),
      email: emailEl.value.trim(),
      tour_name: t.title,
      travel_date: $('#bDate').value || new Date().toISOString().slice(0, 10),
      adults: parseCount($('#bAdults').value),
      children: parseCount($('#bChildren').value),
      currency: state.currency,
      country_code: $('#bCountry').value || 'TZ',
      phone_number: phoneEl.value.trim()
    };

    var btn = e ? e.target.querySelector('button[type=submit]') : $('.form-actions button[type=submit]');
    if (btn) { btn.disabled = true; }

    var finish = function (msg, reset) {
      setBookingStatus(msg);
      closeModal('bookingModal');
      toast(msg.split('.')[0].toUpperCase() + ' ✓', msg, 'check-circle');
      if (btn) btn.disabled = false;
      if (reset) $('#bookingForm').reset();
    };

    if (t.db && t.db.id) {
      payload.destination_id = t.db.id;
      postJSON(API.bookings, payload).then(function (res) {
        if (isSuccess(res)) {
          finish('Thank you! Your booking request has been received — our team will reply within 24 hours to confirm and arrange payment.', true);
        } else {
          setBookingStatus('Could not submit right now. Please try again or contact us on WhatsApp.');
          if (btn) btn.disabled = false;
        }
      }).catch(function () {
        if (btn) btn.disabled = false;
        enqueue(payload, 'booking');
        var text = encodeURIComponent('Hi! I\'d like to book the ' + t.title + ' for ' + payload.adults + ' adult(s), ' + payload.children + ' child(ren) on ' + payload.travel_date + '. ' + payload.name);
        window.open('https://wa.me/' + SITE.whatsapp + '?text=' + text, '_blank', 'noopener');
        toast('REQUEST SAVED OFFLINE', 'You\'re offline — we\'ve saved your request and prepared a WhatsApp message for you.', 'cloud');
        $('#bookingForm').reset();
        closeModal('bookingModal');
      });
    } else {
      // Custom safari → stored as an admin Message
      var msgPayload = {
        name: payload.name,
        email: payload.email,
        interest: 'Custom Safari Request',
        message: 'Tour: ' + t.title + '. Date: ' + payload.travel_date + '. Adults: ' + payload.adults + ', Children: ' + payload.children + '. Phone: ' + payload.phone_number + '. Country: ' + payload.country_code + '.'
      };
      postJSON(API.contact, msgPayload).then(function (res) {
        if (isSuccess(res)) {
          finish('Thank you! Our safari experts will design your custom itinerary and reply shortly.', true);
        } else {
          setBookingStatus('Could not submit right now. Please try again or contact us on WhatsApp.');
          if (btn) btn.disabled = false;
        }
      }).catch(function () {
        if (btn) btn.disabled = false;
        enqueue(msgPayload, 'contact');
        var text = encodeURIComponent('Hi! I\'d like a custom safari: ' + t.title + ' (' + payload.name + ', ' + payload.travel_date + ')');
        window.open('https://wa.me/' + SITE.whatsapp + '?text=' + text, '_blank', 'noopener');
        toast('REQUEST SAVED OFFLINE', 'You\'re offline — your custom request is saved and a WhatsApp message is ready for you.', 'cloud');
        $('#bookingForm').reset();
        closeModal('bookingModal');
      });
    }
  }
  var bookingForm = $('#bookingForm');
  if (bookingForm) bookingForm.addEventListener('submit', submitBooking);

  /* ============================== CUSTOM SAFARI ============================== */
  $$('[data-custom="true"]').forEach(function (b) {
    b.addEventListener('click', function () { openModal('customModal'); });
  });
  if ($('#customClose')) $('#customClose').addEventListener('click', function () { closeModal('customModal'); });
  if ($('#customCancel')) $('#customCancel').addEventListener('click', function () { closeModal('customModal'); });
  var customModal = $('#customModal');
  if (customModal) customModal.addEventListener('click', function (e) { if (e.target.id === 'customModal') closeModal('customModal'); });

  var customForm = $('#customForm');
  if (customForm) customForm.addEventListener('submit', function (e) {
    e.preventDefault();
    var ok = true;
    var nameEl = $('#cName'), emailEl = $('#cEmail');
    $('#eCName').classList.remove('show');
    $('#eCEmail').classList.remove('show');
    if (!nameEl.value.trim()) { $('#eCName').classList.add('show'); ok = false; }
    if (!emailEl.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) { $('#eCEmail').classList.add('show'); ok = false; }
    if (!ok) return;

    var details = [
      'Destinations: ' + $('#cDest').value,
      'Travel dates: ' + $('#cDates').value,
      'Travelers: ' + $('#cTravelers').value,
      'Budget: ' + $('#cBudget').value,
      'Style: ' + $('#cStyle').value,
      'Accommodation: ' + $('#cAcc').value,
      'Preferred activities: ' + $('#cActs').value,
      'Special requests: ' + $('#cNotes').value
    ].filter(function (s) { return /:\s*\S/.test(s); }).join('\n');

    var payload = {
      name: nameEl.value.trim(),
      email: emailEl.value.trim(),
      interest: 'Custom Safari Request',
      message: details
    };
    var btn = customForm.querySelector('button[type=submit]');
    if (btn) btn.disabled = true;
    postJSON(API.contact, payload).then(function (res) {
      if (btn) btn.disabled = false;
      if (isSuccess(res)) {
        closeModal('customModal');
        toast('CUSTOM REQUEST SENT', 'Thank you. Our safari experts will design a custom itinerary and reply shortly.');
        customForm.reset();
      } else {
        toast('PLEASE TRY AGAIN', 'We couldn\'t submit the form. Please check your details or contact us directly.', 'exclamation-circle');
      }
    }).catch(function () {
      if (btn) btn.disabled = false;
      enqueue(payload, 'contact');
      var text = encodeURIComponent('Hi! I\'d like a custom itinerary.\n\n' + details);
      window.open('https://wa.me/' + SITE.whatsapp + '?text=' + text, '_blank', 'noopener');
      toast('REQUEST SAVED OFFLINE', 'You\'re offline — your request was saved and a WhatsApp message is ready for you.', 'cloud');
      closeModal('customModal');
      customForm.reset();
    });
  });

  /* ============================== NEWSLETTER ============================== */
  function subscribe(emailEl, titleOk, msgOk) {
    var val = (emailEl.value || '').trim();
    if (!val || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) { toast('CHECK EMAIL', 'Please enter a valid email address.', 'exclamation-circle'); return; }
    var payload = { name: 'Newsletter Subscriber', email: val, interest: 'Newsletter Subscription', message: 'Newsletter signup: ' + val };
    postJSON(API.contact, payload).then(function (res) {
      if (isSuccess(res)) { toast(titleOk, msgOk); emailEl.value = ''; }
      else toast('PLEASE TRY AGAIN', 'We couldn\'t subscribe this email right now.', 'exclamation-circle');
    }).catch(function () {
      window.open('mailto:' + SITE.email + '?subject=' + encodeURIComponent('Newsletter signup') + '&body=' + encodeURIComponent('Please add ' + val + ' to the Tanzania Daily Tours & Safari newsletter.'), '_blank');
      toast('SUBSCRIBE VIA EMAIL', 'You\'re offline — we\'ve opened an email draft to subscribe you.');
    });
  }
  var nf = $('#newsletterForm');
  if (nf) nf.addEventListener('submit', function (e) {
    e.preventDefault();
    subscribe($('#nlEmail'), 'SUBSCRIBED', 'Welcome! You\'ll receive Tanzania travel stories in your inbox.');
  });
  var fs = $('#footerSubscribe');
  if (fs) fs.addEventListener('click', function () {
    subscribe($('#footerEmail'), 'SUBSCRIBED', 'Thank you for joining our newsletter.');
  });

  /* ============================== TOUR FINDER ============================== */
  var finderBtn = $('#finderBtn');
  if (finderBtn) finderBtn.addEventListener('click', function () {
    var dest = $('#fDest').value, type = $('#fType').value, dur = $('#fDur').value;
    toast('SEARCHING', 'Finding ' + type.toLowerCase() + ' experiences in ' + dest + '...', 'compass');
    setTimeout(function () {
      var grid = $('#tours');
      if (grid) grid.scrollIntoView({ behavior: 'smooth' });
      var targetFilter = 'all';
      if (type.indexOf('Safari') !== -1) targetFilter = 'safari';
      else if (type.indexOf('Day Trip') !== -1) targetFilter = 'day-trip';
      else if (type.indexOf('Cultural') !== -1) targetFilter = 'cultural';
      else if (type.indexOf('Kilimanjaro') !== -1) targetFilter = 'kilimanjaro';
      else if (type.indexOf('Beach') !== -1) targetFilter = 'beach';
      setFilter(targetFilter);
      toast('RESULTS READY', dur + ' — browse the recommended tours below.', 'search');
    }, 350);
  });

  /* ============================== GALLERY + LIGHTBOX ============================== */
  var galGrid = $('#galGrid');
  function renderGallery(filter) {
    if (!galGrid) return;
    filter = filter || 'all';
    var list = filter === 'all' ? GALLERY : GALLERY.filter(function (g) { return g.cat === filter; });
    galGrid.innerHTML = list.map(function (g, i) {
      return '<div class="gal-item" data-lb="' + i + '" data-src="' + esc(g.src) + '" data-caption="' + esc(g.alt) + '" role="button" tabindex="0" aria-label="Open image: ' + esc(g.alt) + '">' +
        '<img src="' + esc(g.src) + '" alt="' + esc(g.alt) + '" loading="lazy" />' +
        '<div class="gal-overlay"><i class="fas fa-search-plus"></i></div></div>';
    }).join('');
    observeReveals();
  }
  renderGallery();
  $$('.gal-filters button').forEach(function (b) {
    b.addEventListener('click', function () {
      $$('.gal-filters button').forEach(function (x) { x.classList.remove('active'); });
      b.classList.add('active');
      renderGallery(b.dataset.gal);
    });
  });

  var lbItems = [], lbIdx = 0;
  function lbRender() {
    var img = $('#lbImg');
    img.src = lbItems[lbIdx].src;
    img.alt = lbItems[lbIdx].caption;
    $('#lbCounter').textContent = (lbIdx + 1) + ' / ' + lbItems.length;
    $('#lbCaption').textContent = lbItems[lbIdx].caption;
    var strip = $('#lbStrip');
    if (strip) {
      strip.innerHTML = lbItems.map(function (g, i) {
        return '<img src="' + esc(g.src) + '" alt="' + esc(g.caption) + '" class="' + (i === lbIdx ? 'active' : '') + '" data-lbs="' + i + '" />';
      }).join('');
    }
  }
  function openLB(items, i) {
    lbItems = items.map(function (g) { return typeof g === 'string' ? { src: g, caption: '' } : g; });
    lbIdx = i;
    lbRender();
    $('#lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeLB() {
    $('#lightbox').classList.remove('open');
    document.body.style.overflow = openStack.length ? 'hidden' : '';
  }
  function lbNext() { lbIdx = (lbIdx + 1) % lbItems.length; lbRender(); }
  function lbPrev() { lbIdx = (lbIdx - 1 + lbItems.length) % lbItems.length; lbRender(); }

  document.addEventListener('click', function (e) {
    var item = e.target.closest('.gal-item');
    if (item) {
      var items = Array.from(document.querySelectorAll('.gal-item')).map(function (x) {
        return { src: x.dataset.src, caption: x.dataset.caption || '' };
      });
      openLB(items, parseInt(item.dataset.lb, 10));
      return;
    }
    var thumb = e.target.closest('#lbStrip img');
    if (thumb) { lbIdx = parseInt(thumb.dataset.lbs, 10); lbRender(); }
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && e.target.classList && e.target.classList.contains('gal-item')) {
      openLB(Array.from(document.querySelectorAll('.gal-item')).map(function (x) {
        return { src: x.dataset.src, caption: x.dataset.caption || '' };
      }), parseInt(e.target.dataset.lb, 10));
    }
  });
  if ($('#lbClose')) $('#lbClose').addEventListener('click', closeLB);
  if ($('#lbNext')) $('#lbNext').addEventListener('click', lbNext);
  if ($('#lbPrev')) $('#lbPrev').addEventListener('click', lbPrev);
  var lbox = $('#lightbox');
  if (lbox) lbox.addEventListener('click', function (e) { if (e.target.id === 'lightbox') closeLB(); });

  /* ============================== REVIEWS ============================== */
  var revIdx = 0, revTimer, touchX = null;
  function renderReviews() {
    var wrap = $('#reviewsSlider'); if (!wrap) return;
    var note = $('#reviewsNote');
    if (note) note.textContent = 'Trusted by travelers — verified reviews are managed from the admin panel.';
    wrap.innerHTML = REVIEWS.map(function (r, i) {
      return '<div class="review-card' + (i === 0 ? ' active' : '') + '" data-rev="' + i + '">' +
        '<div class="review-quote">"</div>' +
        '<div class="review-stars">' + '\u2605'.repeat(r.stars) + '</div>' +
        '<blockquote>' + esc(r.quote) + '</blockquote>' +
        '<div class="review-author">' + esc(r.author) + '<span class="review-meta">' + esc(r.meta) + '</span></div></div>';
    }).join('');
    var dWrap = $('#revDots'); if (dWrap) {
      dWrap.innerHTML = REVIEWS.map(function (_, i) {
        return '<button class="' + (i === 0 ? 'active' : '') + '" data-revdot="' + i + '" aria-label="Show review ' + (i + 1) + '"></button>';
      }).join('');
      $$('#revDots button').forEach(function (d) {
        d.addEventListener('click', function () { goRev(parseInt(d.dataset.revdot, 10)); startRev(); });
      });
    }
  }
  function cardCount() { return $$('.review-card').length; }
  function goRev(i) {
    var cards = $$('.review-card');
    if (!cards.length) return;
    i = (i + cards.length) % cards.length;
    cards.forEach(function (c) { c.classList.remove('active'); });
    cards[i].classList.add('active');
    $$('#revDots button').forEach(function (d, x) { d.classList.toggle('active', x === i); });
    revIdx = i;
  }
  function startRev() {
    stopRev();
    if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && cardCount() > 1) {
      revTimer = setInterval(function () { goRev(revIdx + 1); }, 6000);
    }
  }
  function stopRev() { if (revTimer) { clearInterval(revTimer); revTimer = null; } }
  function initReviews() {
    renderReviews();
    var n = $('#revNext'); if (n) n.addEventListener('click', function () { goRev(revIdx + 1); startRev(); });
    var p = $('#revPrev'); if (p) p.addEventListener('click', function () { goRev(revIdx - 1); startRev(); });
    var slider = $('#reviewsSlider');
    if (slider) {
      slider.addEventListener('mouseenter', stopRev);
      slider.addEventListener('mouseleave', startRev);
      slider.addEventListener('touchstart', function (e) { touchX = e.touches[0].clientX; stopRev(); }, { passive: true });
      slider.addEventListener('touchend', function (e) {
        if (touchX === null) return;
        var dx = e.changedTouches[0].clientX - touchX;
        if (Math.abs(dx) > 40) { dx < 0 ? goRev(revIdx + 1) : goRev(revIdx - 1); }
        touchX = null; startRev();
      }, { passive: true });
    }
    startRev();
  }

  /* ============================== COOKIES ============================== */
  function consent() {
    var c = store.get('tdts_consent', null);
    if (c) return c;
    var map = {
      accept: { essential: true, analytics: true, marketing: true },
      accepted: { essential: true, analytics: true, marketing: true },
      reject: { essential: true, analytics: false, marketing: false },
      declined: { essential: true, analytics: false, marketing: false }
    };
    var legacy = null;
    try { legacy = localStorage.getItem('tdts_cookie_choice'); } catch (e) { /* noop */ }
    if (legacy === null) { try { legacy = localStorage.getItem('cookieConsent'); } catch (e) { /* noop */ } }
    if (legacy && map[legacy]) {
      saveConsent(map[legacy]);
      return map[legacy];
    }
    return null;
  }
  function saveConsent(c) {
    store.set('tdts_consent', c);
    try { localStorage.removeItem('tdts_cookie_choice'); } catch (e) { /* noop */ }
    try { localStorage.removeItem('cookieConsent'); } catch (e) { /* noop */ }
  }
  function loadGA() {
    if (document.getElementById('ga-script')) return;
    var s = document.createElement('script');
    s.id = 'ga-script';
    s.async = true;
    s.src = 'https://www.googletagmanager.com/gtag/js?id=' + SITE.ga;
    document.head.appendChild(s);
    window.dataLayer = window.dataLayer || [];
    function gtag() { window.dataLayer.push(arguments); }
    window.gtag = gtag;
    gtag('js', new Date());
    gtag('config', SITE.ga, { anonymize_ip: true });
  }
  function loadTawk() {
    if (document.getElementById('tawk-script') || window.Tawk_API) return;
    var s = document.createElement('script');
    s.id = 'tawk-script';
    s.async = true;
    s.src = SITE.tawk;
    document.head.appendChild(s);
  }
  function syncConsent() {
    var c = consent();
    if (!c) return;
    if (c.analytics) loadGA();
    if (c.marketing) loadTawk();
    $$('#cookieModal [data-pref]').forEach(function (el) {
      var pref = el.dataset.pref;
      var inp = el.querySelector('input[type=checkbox]');
      if (inp && pref !== 'essential') inp.checked = !!c[pref];
    });
  }
  function openBanner() {
    if (consent()) return;
    setTimeout(function () {
      var b = $('#cookieBanner'); if (b) b.classList.add('show');
    }, 1500);
  }
  function initCookies() {
    var banner = $('#cookieBanner');
    $$('[data-cookie]').forEach(function (b) {
      b.addEventListener('click', function () {
        var choice = b.dataset.cookie;
        if (choice === 'accept') saveConsent({ essential: true, analytics: true, marketing: true });
        else if (choice === 'reject') saveConsent({ essential: true, analytics: false, marketing: false });
        else { openModal('cookieModal'); return; }
        if (banner) banner.classList.remove('show');
        syncConsent();
        toast(choice === 'accept' ? 'COOKIES ACCEPTED' : 'PREFERENCES SAVED',
          choice === 'accept' ? 'Thank you. Enhanced experience enabled.' : 'We\'ll only use essential cookies.', 'cookie-bite');
      });
    });
    if ($('#prefSave')) $('#prefSave').addEventListener('click', function () {
      var c = { essential: true, analytics: false, marketing: false };
      $$('#cookieModal [data-pref] input[type=checkbox]').forEach(function (el) {
        var pref = el.closest('[data-pref]').dataset.pref;
        c[pref] = el.checked;
      });
      saveConsent(c);
      if (banner) banner.classList.remove('show');
      closeModal('cookieModal');
      syncConsent();
      toast('PREFERENCES SAVED', 'Your cookie preferences have been updated.', 'cookie-bite');
    });
    if ($('#prefAll')) $('#prefAll').addEventListener('click', function () {
      saveConsent({ essential: true, analytics: true, marketing: true });
      if (banner) banner.classList.remove('show');
      closeModal('cookieModal');
      syncConsent();
      toast('COOKIES ACCEPTED', 'Thank you. All cookies enabled.', 'cookie-bite');
    });
    var cookieModalEl = $('#cookieModal');
    if (cookieModalEl) cookieModalEl.addEventListener('click', function (e) { if (e.target.id === 'cookieModal') closeModal('cookieModal'); });
    openBanner();
    syncConsent();
  }

  /* ============================== SEARCH ============================== */
  function openSearch() {
    state.searchOpen = true;
    $('#searchOverlay').classList.add('open');
    document.body.style.overflow = 'hidden';
    setTimeout(function () { $('#searchInput').focus(); }, 60);
    renderSearch('');
  }
  function closeSearch() {
    state.searchOpen = false;
    $('#searchOverlay').classList.remove('open');
    document.body.style.overflow = openStack.length ? 'hidden' : '';
  }
  function renderSearch(q) {
    q = (q || '').trim().toLowerCase();
    var box = $('#searchResults');
    var list = TOURS.filter(function (t) {
      if (!q) return true;
      return (t.title + ' ' + t.location + ' ' + t.category + ' ' + t.duration).toLowerCase().indexOf(q) !== -1;
    });
    box.innerHTML = list.length
      ? list.map(function (t) {
        return '<a class="search-result" href="' + esc(tourHref(t)) + '">' +
          '<img src="' + esc(t.image) + '" alt="' + esc(t.title) + '" />' +
          '<div><div class="s-title">' + esc(t.title) + '</div>' +
          '<div class="s-meta">' + esc(t.duration) + ' \u2022 ' + esc(t.location) + '</div></div>' +
          '<div class="s-price">' + (t.price > 0 ? fmtPrice(t.price) : 'On Request') + '</div></a>';
      }).join('')
      : '<div class="search-empty">No tours match "' + esc(q) + '". Try \u2018safari\u2019, \u2018Kilimanjaro\u2019 or \u2018Zanzibar\u2019.</div>';
  }
  function initSearch() {
    var btn = $('#searchBtn'), mbtn = $('#mobileSearch');
    if (btn) btn.addEventListener('click', openSearch);
    if (mbtn) mbtn.addEventListener('click', openSearch);
    if ($('#searchClose')) $('#searchClose').addEventListener('click', closeSearch);
    var so = $('#searchOverlay');
    if (so) so.addEventListener('click', function (e) { if (e.target.id === 'searchOverlay') closeSearch(); });
    if ($('#searchInput')) $('#searchInput').addEventListener('input', function (e) { renderSearch(e.target.value); });
    document.addEventListener('keydown', function (e) {
      if ((e.ctrlKey || e.metaKey) && (e.key === 'k' || e.key === 'K')) {
        e.preventDefault();
        $('#searchOverlay').classList.contains('open') ? closeSearch() : openSearch();
      }
    });
  }

  /* ============================== REVEAL ============================== */
  var io;
  function observeReveals() {
    var els = $$('.reveal:not(.in), .reveal-left:not(.in), .reveal-right:not(.in), .reveal-scale:not(.in)');
    if (!els.length) return;
    if (!io) {
      io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
          if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    }
    els.forEach(function (el) { io.observe(el); });
  }

  /* ============================== COUNTERS ============================== */
  function animateCounters() {
    $$('.stat-num').forEach(function (el) {
      if (el.dataset.done) return;
      var rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 60) {
        el.dataset.done = '1';
        var target = parseInt(el.dataset.count, 10);
        var suffix = el.dataset.suffix || '';
        var dur = 1600;
        var start = performance.now();
        function step(now) {
          var p = Math.min((now - start) / dur, 1);
          var eased = 1 - Math.pow(1 - p, 3);
          var val = Math.floor(eased * target);
          el.textContent = (target >= 1000 ? val.toLocaleString() : val) + suffix;
          if (p < 1) requestAnimationFrame(step);
          else el.textContent = (target >= 1000 ? target.toLocaleString() : target) + suffix;
        }
        requestAnimationFrame(step);
      }
    });
  }

  /* ============================== MISCELLANEOUS ============================== */
  function initMisc() {
    var toTop = $('#toTop');
    if (toTop) toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

    document.querySelectorAll('a[href^="#"]').forEach(function (a) {
      a.addEventListener('click', function (e) {
        var href = a.getAttribute('href');
        if (href && href !== '#' && href.length > 1) {
          var t = document.querySelector(href);
          if (t) {
            e.preventDefault();
            var y = t.getBoundingClientRect().top + window.scrollY - 80;
            window.scrollTo({ top: y, behavior: 'smooth' });
          }
        }
      });
    });

    // Currency select
    var cur = $('#curSel');
    if (cur) {
      cur.innerHTML = CURRENCY_ORDER.map(function (c) {
        return '<option value="' + c + '">' + c + '</option>';
      }).join('');
      cur.addEventListener('change', function (e) {
        state.currency = e.target.value;
        try { localStorage.setItem('tdts_currency', e.target.value); } catch (err) { /* noop */ }
        applyRates();
        toast('CURRENCY', 'Prices now shown in ' + e.target.value + '.', 'coins');
      });
    }

    // Countries in booking form
    var country = $('#bCountry');
    if (country) {
      country.innerHTML = COUNTRIES.map(function (c) {
        return '<option value="' + c[0] + '"' + (c[0] === 'TZ' ? ' selected' : '') + '>' + esc(c[1]) + '</option>';
      }).join('');
    }
    var bDate = $('#bDate');
    if (bDate) bDate.min = new Date().toISOString().slice(0, 10);

    // Preloader
    var pre = $('#preloader');
    var preSeen = (function () { try { return localStorage.getItem('tdts_pre_seen'); } catch (e) { return null; } })();
    if (pre) {
      if (preSeen || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        pre.style.display = 'none';
      } else {
        try { localStorage.setItem('tdts_pre_seen', '1'); } catch (e) { /* noop */ }
        setTimeout(function () { pre.classList.add('done'); }, 800);
        setTimeout(function () { if (pre) pre.style.display = 'none'; }, 1500);
      }
    }

    // Footer year + rating schema update handled separately
    var yr = $('#footerYear'); if (yr) yr.textContent = new Date().getFullYear();
  }

  /* ============================== INIT ============================== */
  function init() {
    bindMobileNav();
    initHero();
    initReviews();
    initSearch();
    initCookies();
    initMisc();
    flushQueue();
    renderTours();
    observeReveals();
    setTimeout(animateCounters, 400);
    loadRates();
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Expose a small API for page-level integrations (e.g. ?cat= filters on /destinations)
  window.__tdtsExt = { setFilter: setFilter, openBooking: openBooking };
})();