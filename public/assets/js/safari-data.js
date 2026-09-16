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
    sustainable: 'v1787751810/Sustainable-Association-4_klxpxg.webp',

    /* --- New image set (July-Aug 2026 uploads) --- */
    pxLion: 'v1789558387/pexels-490714164-28157156_1_xu9yuo.jpg',
    pxKamoga: 'v1789558418/pexels-eric-kamoga-151630609-26689575_vyp9pf.jpg',
    pxClark: 'v1789558346/pexels-chris-clark-1933184-16044994_lkmtsh.jpg',
    pxKeegan: 'v1789558326/pexels-keeganjchecks-16444265_tvunlh.jpg',
    pxJairo: 'v1789558228/pexels-jairos-adventure-1635095-10222036_ufuz7a.jpg',
    pxStudio: 'v1789558403/pexels-dxstudiostz-33124583_wibuuw.jpg',
    pxParretti: 'v1787055392/pexels-riccardo-parretti-145996493-10628684_xeuppy.jpg',
    clipC1: 'v1789559212/SaveClip.App_582089931_17913772683235135_8342819568250607807_n_xhqmtd.jpg',
    clipC2: 'v1789559219/SaveClip.App_746320329_17946365025235135_3629009153550153873_n_aafabl.jpg',
    clipC3: 'v1789559205/SaveClip.App_763262775_17949852486235135_8124152108709330_n_drwnbm.jpg',
    clipC4: 'v1789559199/SaveClip.App_746399769_17946365079235135_2778199037654924006_n_-_Copy_nkty7s.jpg',
    clipC5: 'v1789559138/SaveClip.App_776040548_18613566205036855_1836122284037167702_n_-_Copy_zyqv3g.jpg',
    clipC6: 'v1789559044/SaveClip.App_774669288_18342486628271974_6558634318113552653_n_-_Copy_nwqsie.jpg',
    clipC7: 'v1789558912/SaveClip.App_774744584_18342486745271974_9049627129812224249_n_-_Copy_zocqcs.jpg',
    shotA: 'v1789559166/Screenshot_2026-08-24_051341_-_Copy_rbe3nd.png',
    shotB: 'v1786603293/Screenshot_2026-08-12_091147_mcjlmq.png',
    shotC: 'v1784634085/Screenshot_2026-07-21_044043_r6yjy0.png',
    shotD: 'v1783761750/Screenshot_2026-07-11_021808_zrxpza.png',
    shotE: 'v1783691928/Screenshot_2026-07-10_065323-Picsart-AiImageEnhancer_nexqyd.png',
    shotF: 'v1783690457/Screenshot_2026-07-10_063014_hyg7dk.png',
    shotG: 'v1783595575/Screenshot_2026-07-09_041227_q4sxlf.png',
    shotH: 'v1783506719/Screenshot_2026-07-08_033102_qp2cgp.png',
    shotI: 'v1783504230/Screenshot_2026-07-08_025001_ajgpp8.png',
    shotJ: 'v1783502373/Screenshot_2026-07-08_021806_tjlzsx.png',
    shotK: 'v1783503876/Screenshot_2026-07-08_024309_efeyyp.png',
    clipBeach: 'v1789558176/SaveClip.App_626263843_18095439202943497_8363208709431488138_n_pnxz7l.jpg',
    pxNing: 'v1789558530/pexels-alex-ning-523843601-33650622_p5eowd.jpg'
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
    { img: cld(F.zanzibarBeach, 1920), srcset: cld(F.zanzibarBeach, 960) + ' 960w,' + cld(F.zanzibarBeach, 1920) + ' 1920w', alt: 'Zanzibar turquoise beach', title: 'ESCAPE TO<br><em>ZANZIBAR.</em>', sub: 'BEACH & CULTURE', copy: 'Unwind on powder-white sands, explore Stone Town and sail into the sunset on a traditional dhow.', priority: false },
    { img: cld(F.pxLion, 1920), srcset: cld(F.pxLion, 960) + ' 960w,' + cld(F.pxLion, 1920) + ' 1920w', alt: 'Lion resting in golden grassland', title: 'MEET<br><em>THE ROYALS.</em>', sub: 'SAVANNA KINGS', copy: 'Come face to face with Tanzania\u2019s big cats \u2014 lions, leopards and cheetahs \u2014 on guided game drives with local experts.', priority: false },
    { img: cld(F.pxKamoga, 1920), srcset: cld(F.pxKamoga, 960) + ' 960w,' + cld(F.pxKamoga, 1920) + ' 1920w', alt: 'Wildebeest herd crossing the Serengeti plains', title: 'FOLLOW<br><em>THE HERDS.</em>', sub: 'THE GREAT MIGRATION', copy: 'Chase the rhythm of a million hooves across the plains \u2014 the greatest wildlife spectacle on Earth.', priority: false },
    { img: cld(F.pxClark, 1920), srcset: cld(F.pxClark, 960) + ' 960w,' + cld(F.pxClark, 1920) + ' 1920w', alt: 'Golden sunrise over the African savanna', title: 'SAFARI<br><em>AT SUNRISE.</em>', sub: 'GOLDEN GAME DRIVES', copy: 'Leave before dawn and watch the savanna come alive \u2014 golden light, rising dust and wildlife on the move.', priority: false },
    { img: cld(F.pxKeegan, 1920), srcset: cld(F.pxKeegan, 960) + ' 960w,' + cld(F.pxKeegan, 1920) + ' 1920w', alt: 'Elephant family in Tanzania wildlife country', title: 'ROAM WITH<br><em>THE GIANTS.</em>', sub: 'ELEPHANT COUNTRY', copy: 'Walk the ancient paths of elephant herds in Tarangire and beyond \u2014 magnificent, gentle, unforgettable.', priority: false }
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