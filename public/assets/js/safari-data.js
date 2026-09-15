/* =====================================================================
   Tanzania Daily Tours & Safari — Site Data
   ---------------------------------------------------------------------
   Static constants only. Tours / gallery / reviews are injected by the
   Blade partial (resources/views/partials/safari-data.blade.php) which
   builds them from the content map + DB, and the API is overridden to
   absolute URLs so the site works on every Laravel route.
   ===================================================================== */
(function (global) {
  'use strict';

  /* ---------- Cloudinary helper ---------- */
  var CLD = 'https://res.cloudinary.com/aenplcpl/image/upload/';
  var cld = function (file, w) {
    return CLD + 'f_auto,q_auto,w_' + (w || 700) + '/' + file;
  };

  /* ---------- Asset map (the project's own images) ---------- */
  var F = {
    heroSerengeti: 'v1782890323/safari-serengeti_agwjrp.jpg',
    heroNgorongoro: 'v1782890323/safari-ngorongoro_j04gqg.jpg',
    heroKilimanjaro: 'v1782890322/safari-kilimanjaro_rnqbaj.jpg',
    zanzibarBeach: 'v1782890319/tour-zanzibar_y2syxk.jpg',
    tourMateruni: 'v1782890319/tour-materuni_fnsdea.jpg',
    tourChemka: 'v1782890325/tour-chemka_tdh78w.jpg',
    tourMarangu: 'v1782890321/tour-marangu_bprorr.jpg',
    tourKiliDay: 'v1782890324/tour-kili-day_brcn7n.jpg',
    tourArusha: 'v1782890323/tour-arusha_bzqksh.jpg',
    tourServal: 'v1782890318/tour-serval_sxetg3.jpg',
    tourMaasai: 'v1782890319/tour-maasai_owadcl.jpg',
    safariSerengeti: 'v1782890323/safari-serengeti_agwjrp.jpg',
    safariNgorongoro: 'v1782890323/safari-ngorongoro_j04gqg.jpg',
    safariKilimanjaro: 'v1782890322/safari-kilimanjaro_rnqbaj.jpg',
    safariMikumi: 'v1782890326/safari-mikumi_suogue.jpg',
    galleryWildlife1: 'v1782890321/gallery-wildlife-1_tzfe6e.jpg',
    galleryWildlife2: 'v1782890322/gallery-wildlife-2_fnrchg.jpg',
    galleryLandscape1: 'v1782890318/gallery-landscape-1_dxdd6x.jpg',
    galleryLandscape2: 'v1782890321/gallery-landscape-2_cmzfxg.jpg',
    galleryPeople1: 'v1782890321/gallery-people-1_q8uyjd.jpg',
    galleryCulture1: 'v1782890319/gallery-culture-1_xmbakz.jpg',
    aboutHero: 'v1782890320/about-hero_dbeshf.jpg',
    logoBrown: 'v1782890324/safari-logo-brown_d1vgxe.png',
    logoWhite: 'v1782890324/safari-logo-white_bexcal.png',
    tripadvisor: 'v1784610546/PngItem_1715860_wbqbw4.png',
    sustainable: 'v1787751810/Sustainable-Association-4_klxpxg.webp'
  };

  /* ---------- Site constants ---------- */
  var SITE = {
    name: 'Tanzania Daily Tours & Safari',
    tagline: 'TOURS & SAFARI',
    phone: '+255 623 975 934',
    phoneHref: 'tel:+255623975934',
    whatsapp: '255623975934',
    email: 'info.tanzaniadailytours@gmail.com',
    location: 'Moshi • Arusha • Tanzania',
    ga: 'G-JS83PTXEYM',
    tawk: 'https://embed.tawk.to/6a452b6d59a11c1d46cc69ff/1jsf339th',
    socials: {
      instagram: 'https://www.instagram.com/tanzania_dailytours_and_safari/',
      facebook: 'https://www.facebook.com/tanzaniadailytoursandsafari',
      twitter: 'https://twitter.com/tanzaniadailytours',
      tripadvisor: 'https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html'
    },
    logos: { brown: cld(F.logoBrown, 240), white: cld(F.logoWhite, 240) },
    tripadvisorIcon: cld(F.tripadvisor, 100),
    sustainability: cld(F.sustainable, 640)
  };

  /* ---------- Hero slides ---------- */
  var HERO = [
    { img: cld(F.heroSerengeti, 1920), srcset: cld(F.heroSerengeti, 960) + ' 960w,' + cld(F.heroSerengeti, 1920) + ' 1920w', alt: 'Lion in the Serengeti plains', title: 'DISCOVER<br><em>TANZANIA.</em>', sub: 'SAFARIS. ADVENTURES. MEMORIES THAT LAST.', copy: 'Experience Tanzania through unforgettable wildlife safaris, cultural adventures, mountain journeys and coastal escapes.', priority: true },
    { img: cld(F.heroNgorongoro, 1920), srcset: cld(F.heroNgorongoro, 960) + ' 960w,' + cld(F.heroNgorongoro, 1920) + ' 1920w', alt: 'Great Migration wildebeest crossing the savanna', title: 'WITNESS<br><em>THE WILD.</em>', sub: 'THE GREAT MIGRATION', copy: 'Follow the thunder of a million hooves across the Serengeti — the greatest wildlife spectacle on Earth.', priority: false },
    { img: cld(F.heroKilimanjaro, 1920), srcset: cld(F.heroKilimanjaro, 960) + ' 960w,' + cld(F.heroKilimanjaro, 1920) + ' 1920w', alt: 'Mount Kilimanjaro snow cap', title: 'CLIMB<br><em>HIGHER.</em>', sub: 'MOUNT KILIMANJARO', copy: 'Stand on the roof of Africa. From day hikes to full summit expeditions, we guide you every step.', priority: false },
    { img: cld(F.zanzibarBeach, 1920), srcset: cld(F.zanzibarBeach, 960) + ' 960w,' + cld(F.zanzibarBeach, 1920) + ' 1920w', alt: 'Zanzibar turquoise beach', title: 'ESCAPE TO<br><em>ZANZIBAR.</em>', sub: 'BEACH & CULTURE', copy: 'Unwind on powder-white sands, explore Stone Town and sail into the sunset on a traditional dhow.', priority: false }
  ];

  /* ---------- Tour categories (used by nav + filters + finder) ---------- */
  var CATEGORIES = {
    'day-trip': 'Day Trips',
    safari: 'Safaris',
    kilimanjaro: 'Kilimanjaro',
    cultural: 'Cultural',
    beach: 'Beach',
    custom: 'Custom'
  };

  /* ---------- Root-relative API defaults (overridden to absolute URLs by the Blade partial) ---------- */
  var API = {
    bookings: 'bookings',
    contact: 'contact',
    currencyRates: 'api/currency-rates'
  };

  /* ---------- Fallback currency table (used if the live endpoint is unreachable) ---------- */
  var FALLBACK_CURRENCIES = {
    USD: { rate: 1, symbol: '$' },
    EUR: { rate: 0.92, symbol: '€' },
    GBP: { rate: 0.79, symbol: '£' },
    JPY: { rate: 149, symbol: '¥' },
    CAD: { rate: 1.36, symbol: 'C$' },
    AUD: { rate: 1.51, symbol: 'A$' },
    INR: { rate: 83.4, symbol: '₹' },
    TZS: { rate: 2600, symbol: 'TSh' },
    KES: { rate: 129, symbol: 'KSh' },
    UGX: { rate: 3750, symbol: 'USh' },
    ZAR: { rate: 18.1, symbol: 'R' }
  };

  /* ---------- Country list (ISO-3166 alpha-2 for the booking payload) ---------- */
  var COUNTRIES = [
    ['TZ', 'Tanzania'], ['KE', 'Kenya'], ['UG', 'Uganda'], ['RW', 'Rwanda'], ['ZA', 'South Africa'],
    ['US', 'United States'], ['CA', 'Canada'], ['MX', 'Mexico'], ['BR', 'Brazil'], ['AR', 'Argentina'],
    ['GB', 'United Kingdom'], ['IE', 'Ireland'], ['FR', 'France'], ['DE', 'Germany'], ['IT', 'Italy'],
    ['ES', 'Spain'], ['PT', 'Portugal'], ['NL', 'Netherlands'], ['BE', 'Belgium'], ['CH', 'Switzerland'],
    ['AT', 'Austria'], ['SE', 'Sweden'], ['NO', 'Norway'], ['DK', 'Denmark'], ['FI', 'Finland'],
    ['PL', 'Poland'], ['CZ', 'Czechia'], ['RO', 'Romania'], ['GR', 'Greece'], ['TR', 'Turkey'],
    ['RU', 'Russia'], ['UA', 'Ukraine'], ['IN', 'India'], ['CN', 'China'], ['JP', 'Japan'],
    ['KR', 'South Korea'], ['SG', 'Singapore'], ['MY', 'Malaysia'], ['TH', 'Thailand'], ['ID', 'Indonesia'],
    ['PH', 'Philippines'], ['VN', 'Vietnam'], ['AU', 'Australia'], ['NZ', 'New Zealand'],
    ['SA', 'Saudi Arabia'], ['AE', 'United Arab Emirates'], ['QA', 'Qatar'], ['IL', 'Israel'],
    ['EG', 'Egypt'], ['NG', 'Nigeria'], ['GH', 'Ghana'], ['ET', 'Ethiopia'], ['MG', 'Madagascar']
  ];

  global.TDTS = {
    SITE: SITE, HERO: HERO, CATEGORIES: CATEGORIES, API: API,
    FALLBACK_CURRENCIES: FALLBACK_CURRENCIES, COUNTRIES: COUNTRIES, cld: cld, F: F
  };
})(window);