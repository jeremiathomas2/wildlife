<?php

namespace App\Support;

use Illuminate\Support\Collection;

/**
 * Static site data + rich tour content for the Tanzania Daily Tours & Safari front-end.
 *
 * DB (destinations) wins for admin-editable fields: name, slug, duration, prices, image, status.
 * Rich content (overview, itinerary, FAQs, highlights, …) lives here and is merged per tour.
 */
class SafariContent
{
    /** Cloudinary base URL for this project. */
    public const CLD = 'https://res.cloudinary.com/aenplcpl/image/upload/';

    /** Asset map — the project's own image public-ids on Cloudinary. */
    public const F = [
        'heroSerengeti' => 'v1782890323/safari-serengeti_agwjrp.jpg',
        'heroNgorongoro' => 'v1782890323/safari-ngorongoro_j04gqg.jpg',
        'heroKilimanjaro' => 'v1782890322/safari-kilimanjaro_rnqbaj.jpg',
        'zanzibarBeach' => 'v1782890319/tour-zanzibar_y2syxk.jpg',
        'tourMateruni' => 'v1782890319/tour-materuni_fnsdea.jpg',
        'tourChemka' => 'v1782890325/tour-chemka_tdh78w.jpg',
        'tourMarangu' => 'v1782890321/tour-marangu_bprorr.jpg',
        'tourKiliDay' => 'v1782890324/tour-kili-day_brcn7n.jpg',
        'tourArusha' => 'v1782890323/tour-arusha_bzqksh.jpg',
        'tourServal' => 'v1782890318/tour-serval_sxetg3.jpg',
        'tourMaasai' => 'v1782890319/tour-maasai_owadcl.jpg',
        'safariSerengeti' => 'v1782890323/safari-serengeti_agwjrp.jpg',
        'safariNgorongoro' => 'v1782890323/safari-ngorongoro_j04gqg.jpg',
        'safariKilimanjaro' => 'v1782890322/safari-kilimanjaro_rnqbaj.jpg',
        'safariMikumi' => 'v1782890326/safari-mikumi_suogue.jpg',
        'galleryWildlife1' => 'v1782890321/gallery-wildlife-1_tzfe6e.jpg',
        'galleryWildlife2' => 'v1782890322/gallery-wildlife-2_fnrchg.jpg',
        'galleryLandscape1' => 'v1782890318/gallery-landscape-1_dxdd6x.jpg',
        'galleryLandscape2' => 'v1782890321/gallery-landscape-2_cmzfxg.jpg',
        'galleryPeople1' => 'v1782890321/gallery-people-1_q8uyjd.jpg',
        'galleryCulture1' => 'v1782890319/gallery-culture-1_xmbakz.jpg',
        'aboutHero' => 'v1782890320/about-hero_dbeshf.jpg',
        'logoBrown' => 'v1782890324/safari-logo-brown_d1vgxe.png',
        'logoWhite' => 'v1782890324/safari-logo-white_bexcal.png',
        'tripadvisor' => 'v1784610546/PngItem_1715860_wbqbw4.png',
        'sustainable' => 'v1787751810/Sustainable-Association-4_klxpxg.webp',

        // === New image set (July–August 2026 uploads) ===
        'pxLion' => 'v1789558387/pexels-490714164-28157156_1_xu9yuo.jpg',
        'pxKamoga' => 'v1789558418/pexels-eric-kamoga-151630609-26689575_vyp9pf.jpg',
        'pxClark' => 'v1789558346/pexels-chris-clark-1933184-16044994_lkmtsh.jpg',
        'pxKeegan' => 'v1789558326/pexels-keeganjchecks-16444265_tvunlh.jpg',
        'pxJairo' => 'v1789558228/pexels-jairos-adventure-1635095-10222036_ufuz7a.jpg',
        'pxStudio' => 'v1789558403/pexels-dxstudiostz-33124583_wibuuw.jpg',
        'pxParretti' => 'v1787055392/pexels-riccardo-parretti-145996493-10628684_xeuppy.jpg',
        'clipC1' => 'v1789559212/SaveClip.App_582089931_17913772683235135_8342819568250607807_n_xhqmtd.jpg',
        'clipC2' => 'v1789559219/SaveClip.App_746320329_17946365025235135_3629009153550153873_n_aafabl.jpg',
        'clipC3' => 'v1789559205/SaveClip.App_763262775_17949852486235135_8124152108709330_n_drwnbm.jpg',
        'clipC4' => 'v1789559199/SaveClip.App_746399769_17946365079235135_2778199037654924006_n_-_Copy_nkty7s.jpg',
        'clipC5' => 'v1789559138/SaveClip.App_776040548_18613566205036855_1836122284037167702_n_-_Copy_zyqv3g.jpg',
        'clipC6' => 'v1789559044/SaveClip.App_774669288_18342486628271974_6558634318113552653_n_-_Copy_nwqsie.jpg',
        'clipC7' => 'v1789558912/SaveClip.App_774744584_18342486745271974_9049627129812224249_n_-_Copy_zocqcs.jpg',
        'shotA' => 'v1789559166/Screenshot_2026-08-24_051341_-_Copy_rbe3nd.png',
        'shotB' => 'v1786603293/Screenshot_2026-08-12_091147_mcjlmq.png',
        'shotC' => 'v1784634085/Screenshot_2026-07-21_044043_r6yjy0.png',
        'shotD' => 'v1783761750/Screenshot_2026-07-11_021808_zrxpza.png',
        'shotE' => 'v1783691928/Screenshot_2026-07-10_065323-Picsart-AiImageEnhancer_nexqyd.png',
        'shotF' => 'v1783690457/Screenshot_2026-07-10_063014_hyg7dk.png',
        'shotG' => 'v1783595575/Screenshot_2026-07-09_041227_q4sxlf.png',
        'shotH' => 'v1783506719/Screenshot_2026-07-08_033102_qp2cgp.png',
        'shotI' => 'v1783504230/Screenshot_2026-07-08_025001_ajgpp8.png',
        'shotJ' => 'v1783502373/Screenshot_2026-07-08_021806_tjlzsx.png',
        'shotK' => 'v1783503876/Screenshot_2026-07-08_024309_efeyyp.png',
        'clipBeach' => 'v1789558176/SaveClip.App_626263843_18095439202943497_8363208709431488138_n_pnxz7l.jpg',
        'pxNing' => 'v1789558530/pexels-alex-ning-523843601-33650622_p5eowd.jpg',

        // === Zanzibar "From Savannah to Sea" section ===
        'zanzibarMain' => 'v1789558355/SaveClip.App_640867807_18104518957865922_2429330572681918097_n_mtjaak.webp',

        // === Category card images (home page "Explore by Category") ===
        'catMultiDay' => 'v1789559180/Gemini_Generated_Image_hbrnzhbrnzhbrnzh_-_Copy_bn4cye.jpg',
        'catDayTrip' => 'v1789559228/SaveClip.App_601363653_18062421518635481_5375321045818800004_n_dnomdz.webp',
        'catCultural' => 'v1788265627/pexels-zebari-visuals-1510344-37475924_zx5q1k.jpg',
        'catCustom' => 'v1789558981/SaveClip.App_774514153_18342486811271974_71060506532385406_n_-_Copy_lsj6lg.jpg',
    ];

    /** Build a Cloudinary URL with f_auto/q_auto at a given width. */
    public static function cld(string $file, int $width = 700): string
    {
        return self::CLD.'f_auto,q_auto,w_'.$width.'/'.$file;
    }

    /** Site-wide constants recorded in window.TDTS.SITE. */
    public static function site(): array
    {
        return [
            'name' => 'Tanzania Daily Tours & Safari',
            'tagline' => 'TOURS & SAFARI',
            'phone' => '+255 623 975 934',
            'phoneHref' => 'tel:+255623975934',
            'whatsapp' => '255623975934',
            'email' => 'info.tanzaniadailytours@gmail.com',
            'location' => 'Moshi • Arusha • Tanzania',
            'ga' => 'G-JS83PTXEYM',
            'tawk' => 'https://embed.tawk.to/6a452b6d59a11c1d46cc69ff/1jsf339th',
            'socials' => [
                'instagram' => 'https://www.instagram.com/tanzania_dailytours_and_safari/',
                'facebook' => 'https://www.facebook.com/tanzaniadailytoursandsafari',
                'twitter' => 'https://twitter.com/tanzaniadailytours',
                'tripadvisor' => 'https://www.tripadvisor.com/Attraction_Review-g317084-d34526433-Reviews-Tanzania_Daily_Tours_and_Safari-Moshi_Kilimanjaro_Region.html',
            ],
            'logos' => [
                'brown' => self::cld(self::F['logoBrown'], 240),
                'white' => self::cld(self::F['logoWhite'], 240),
            ],
            'tripadvisorIcon' => self::cld(self::F['tripadvisor'], 100),
            'sustainability' => self::cld(self::F['sustainable'], 640),
        ];
    }

    /** Hero slides for the home hero slider. */
    public static function hero(): array
    {
        $slides = [
            ['f' => self::F['heroSerengeti'], 'alt' => 'Lion in the Serengeti plains', 'title' => 'DISCOVER<br><em>TANZANIA.</em>', 'sub' => 'SAFARIS. ADVENTURES. MEMORIES THAT LAST.', 'copy' => 'Experience Tanzania through unforgettable wildlife safaris, cultural adventures, mountain journeys and coastal escapes.', 'priority' => true],
            ['f' => self::F['heroNgorongoro'], 'alt' => 'Great Migration wildebeest crossing the savanna', 'title' => 'WITNESS<br><em>THE WILD.</em>', 'sub' => 'THE GREAT MIGRATION', 'copy' => 'Follow the thunder of a million hooves across the Serengeti — the greatest wildlife spectacle on Earth.', 'priority' => false],
            ['f' => self::F['heroKilimanjaro'], 'alt' => 'Mount Kilimanjaro snow cap', 'title' => 'CLIMB<br><em>HIGHER.</em>', 'sub' => 'MOUNT KILIMANJARO', 'copy' => 'Stand on the roof of Africa. From day hikes to full summit expeditions, we guide you every step.', 'priority' => false],
            ['f' => self::F['zanzibarBeach'], 'alt' => 'Zanzibar turquoise beach', 'title' => 'ESCAPE TO<br><em>ZANZIBAR.</em>', 'sub' => 'BEACH & CULTURE', 'copy' => 'Unwind on powder-white sands, explore Stone Town and sail into the sunset on a traditional dhow.', 'priority' => false],
            ['f' => self::F['pxLion'], 'alt' => 'Lion resting in golden grassland', 'title' => 'MEET<br><em>THE ROYALS.</em>', 'sub' => 'SAVANNA KINGS', 'copy' => 'Come face to face with Tanzania\'s big cats — lions, leopards and cheetahs — on guided game drives with local experts.', 'priority' => false],
            ['f' => self::F['pxKamoga'], 'alt' => 'Wildebeest herd crossing the Serengeti plains', 'title' => 'FOLLOW<br><em>THE HERDS.</em>', 'sub' => 'THE GREAT MIGRATION', 'copy' => 'Chase the rhythm of a million hooves across the plains — the greatest wildlife spectacle on Earth.', 'priority' => false],
            ['f' => self::F['pxClark'], 'alt' => 'Golden sunrise over the African savanna', 'title' => 'SAFARI<br><em>AT SUNRISE.</em>', 'sub' => 'GOLDEN GAME DRIVES', 'copy' => 'Leave before dawn and watch the savanna come alive — golden light, rising dust and wildlife on the move.', 'priority' => false],
            ['f' => self::F['pxKeegan'], 'alt' => 'Elephant family in Tanzania wildlife country', 'title' => 'ROAM WITH<br><em>THE GIANTS.</em>', 'sub' => 'ELEPHANT COUNTRY', 'copy' => 'Walk the ancient paths of elephant herds in Tarangire and beyond — magnificent, gentle, unforgettable.', 'priority' => false],
        ];

        return array_map(function ($s) {
            return [
                'img' => self::cld($s['f'], 1920),
                'srcset' => self::cld($s['f'], 960).' 960w,'.self::cld($s['f'], 1920).' 1920w',
                'alt' => $s['alt'],
                'title' => $s['title'],
                'sub' => $s['sub'],
                'copy' => $s['copy'],
                'priority' => $s['priority'],
            ];
        }, $slides);
    }

    /** Tour category keys → labels (nav + filters + finder). */
    public static function categories(): array
    {
        return [
            'day-trip' => 'Day Trips',
            'safari' => 'Safaris',
            'kilimanjaro' => 'Kilimanjaro',
            'cultural' => 'Cultural',
            'beach' => 'Beach',
            'custom' => 'Custom',
        ];
    }

    /**
     * Landing-page config for the /tours/{slug} category pages.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function tourCategories(): array
    {
        return [
            'day-trips' => [
                'category' => 'day-trip',
                'title' => 'Day Trips',
                'eyebrow' => 'SHORT & SWEET',
                'description' => 'Round-trip adventures from Moshi & Arusha — waterfalls, hot springs, villages and more, all in a single unforgettable day.',
                'hero' => self::cld(self::F['tourMateruni'], 1920),
                'meta_title' => 'Day Trips from Moshi & Arusha - Tanzania Daily Tours & Safari',
                'meta_description' => 'Explore Tanzania day trips: Materuni waterfall, Chemka hot springs, Kilimanjaro foothills and more. Round-trip adventures from Moshi and Arusha.',
            ],
            'multi-day-safaris' => [
                'category' => 'safari',
                'title' => 'Multi-Day Safaris',
                'eyebrow' => 'EXTENDED ADVENTURES',
                'description' => 'Immersive multi-day wildlife safaris through the northern circuit — Serengeti, Ngorongoro, Tarangire and beyond.',
                'hero' => self::cld(self::F['safariSerengeti'], 1920),
                'meta_title' => 'Multi-Day Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Multi-day Tanzania safari packages: Serengeti Great Migration, Ngorongoro crater and Tarangire. Private and small-group safaris.',
            ],
            'cultural-tours' => [
                'category' => 'cultural',
                'title' => 'Cultural Tours',
                'eyebrow' => 'PEOPLE & PLACES',
                'description' => 'Meet Tanzania\'s communities — Chagga villages, coffee traditions and authentic local experiences you won\'t find on a bus route.',
                'hero' => self::cld(self::F['galleryCulture1'], 1920),
                'meta_title' => 'Cultural Tours in Tanzania - Tanzania Daily Tours & Safari',
                'meta_description' => 'Authentic cultural tours in Tanzania: Chagga coffee villages near Kilimanjaro and real local experiences with Tanzania Daily Tours.',
            ],
            'kilimanjaro-trips' => [
                'category' => 'kilimanjaro',
                'title' => 'Kilimanjaro Trips',
                'eyebrow' => 'THE ROOF OF AFRICA',
                'description' => 'From a single-day hike on the lower slopes to full summit treks on Machame — stand on the rooftop of Africa.',
                'hero' => self::cld(self::F['safariKilimanjaro'], 1920),
                'meta_title' => 'Kilimanjaro Hikes & Treks - Tanzania Daily Tours & Safari',
                'meta_description' => 'Mount Kilimanjaro day hikes and Machame route treks with expert guides. Climb the roof of Africa with Tanzania Daily Tours.',
            ],
            'beach-experiences' => [
                'category' => 'beach',
                'title' => 'Beach Experiences',
                'eyebrow' => 'SAND & SEASIDE',
                'description' => 'Zanzibar escapes — white sand, Stone Town culture and sunset dhow cruises to round off your safari.',
                'hero' => self::cld(self::F['zanzibarBeach'], 1920),
                'meta_title' => 'Zanzibar Beach Escapes - Tanzania Daily Tours & Safari',
                'meta_description' => 'Zanzibar beach escapes: turquoise waters, Stone Town, spice tours and dhows. Combine with a Tanzania safari.',
            ],
            'custom-safaris' => [
                'category' => 'custom',
                'title' => 'Custom Safaris',
                'eyebrow' => 'DESIGN YOUR OWN',
                'description' => 'Tell us your dates, budget and travel style — we\'ll craft a private Tanzania itinerary made just for you.',
                'hero' => self::cld(self::F['safariMikumi'], 1920),
                'meta_title' => 'Custom Tanzania Safaris - Tanzania Daily Tours & Safari',
                'meta_description' => 'Build your dream Tanzania safari. Private itineraries tailored to your dates, budget and interests.',
            ],
        ];
    }

    /**
     * Landing-page config for the /safaris/{slug} safari-style pages.
     *
     * @return array<string, array<string, mixed>>
     */
    public static function safariStyles(): array
    {
        return [
            'budget' => [
                'title' => 'Budget Safaris',
                'eyebrow' => 'AFFORDABLE WILD',
                'description' => 'Value-packed safaris that never compromise on great game viewing — campsites, group departures and smart seasons.',
                'hero' => self::cld(self::F['safariMikumi'], 1920),
                'meta_title' => 'Budget Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Affordable budget safari packages in Tanzania without sacrificing wildlife. Great game viewing on a sensible budget.',
            ],
            'mid-range' => [
                'title' => 'Mid-Range Safaris',
                'eyebrow' => 'THE BEST BALANCE',
                'description' => 'The sweet spot between comfort and value — tented camps and lodges with full board and private 4x4 guiding.',
                'hero' => self::cld(self::F['safariSerengeti'], 1920),
                'meta_title' => 'Mid-Range Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Mid-range Tanzania safaris with comfortable lodges and tented camps, full board and expert private guiding.',
            ],
            'luxury' => [
                'title' => 'Luxury Safaris',
                'eyebrow' => 'ELEVATED STANDARDS',
                'description' => 'Signature lodges, private guides and effortless logistics — safari experiences crafted around you.',
                'hero' => self::cld(self::F['safariNgorongoro'], 1920),
                'meta_title' => 'Luxury Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Luxury Tanzania safaris at signature lodges and camps with private guides and bespoke experiences.',
            ],
            'private' => [
                'title' => 'Private Safaris',
                'eyebrow' => 'YOUR VEHICLE, YOUR PACE',
                'description' => 'Exclusive-use 4x4s and dedicated guides — the entire park, migration and crater all on your schedule.',
                'hero' => self::cld(self::F['safariSerengeti'], 1920),
                'meta_title' => 'Private Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Private Tanzania safaris with exclusive-use vehicles and dedicated guides, tailored to your pace and interests.',
            ],
            'family' => [
                'title' => 'Family Safaris',
                'eyebrow' => 'MEMORIES FOR ALL AGES',
                'description' => 'Kid-friendly lodges, flexible pacing and guides who know how to keep everyone amazed — safari for the whole family.',
                'hero' => self::cld(self::F['safariMikumi'], 1920),
                'meta_title' => 'Family Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Family safari packages in Tanzania with kid-friendly lodges, flexible itineraries and expert guides.',
            ],
            'honeymoon' => [
                'title' => 'Honeymoon Safaris',
                'eyebrow' => 'ROMANCE UNDER THE STARS',
                'description' => 'Safari and beach in one seamless journey — private camps, sundowners and a Zanzibar finale for two.',
                'hero' => self::cld(self::F['zanzibarBeach'], 1920),
                'meta_title' => 'Honeymoon Safari Packages - Tanzania Daily Tours & Safari',
                'meta_description' => 'Honeymoon safaris in Tanzania — private lodges, romantic sundowners and a Zanzibar beach finale for two.',
            ],
        ];
    }

    /**
     * "Explore Tanzania" region menu → destination detail slug.
     *
     * @return array<string, string>
     */
    public static function menuRegions(): array
    {
        return [
            'Serengeti' => 'serengeti-safari',
            'Ngorongoro' => 'ngorongoro-crater',
            'Tarangire' => '3-day-tarangire-ngorongoro-safari',
            'Kilimanjaro' => 'kilimanjaro-day-hike',
            'Zanzibar' => 'zanzibar-escape',
        ];
    }

    /** Fallback currency table used if the live endpoint is unreachable. */
    public static function fallbackCurrencies(): array
    {
        return [
            'USD' => ['rate' => 1, 'symbol' => '$'],
            'EUR' => ['rate' => 0.92, 'symbol' => '€'],
            'GBP' => ['rate' => 0.79, 'symbol' => '£'],
            'JPY' => ['rate' => 149, 'symbol' => '¥'],
            'CAD' => ['rate' => 1.36, 'symbol' => 'C$'],
            'AUD' => ['rate' => 1.51, 'symbol' => 'A$'],
            'INR' => ['rate' => 83.4, 'symbol' => '₹'],
            'TZS' => ['rate' => 2600, 'symbol' => 'TSh'],
            'KES' => ['rate' => 129, 'symbol' => 'KSh'],
            'UGX' => ['rate' => 3750, 'symbol' => 'USh'],
            'ZAR' => ['rate' => 18.1, 'symbol' => 'R'],
        ];
    }

    /** ISO-3166 alpha-2 country list for the booking payload. */
    public static function countries(): array
    {
        return [
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
            ['EG', 'Egypt'], ['NG', 'Nigeria'], ['GH', 'Ghana'], ['ET', 'Ethiopia'], ['MG', 'Madagascar'],
        ];
    }

    /**
     * Rich tour content keyed by tour slug. DB overrides are applied in buildTours().
     *
     * @return array<string, array<string, mixed>>
     */
    public static function contentTours(): array
    {
        return [
            'materuni-waterfall-coffee-tour' => [
                'id' => 'materuni-waterfall',
                'category' => 'day-trip',
                'location' => 'Materuni Village, Moshi',
                'durationDays' => 1,
                'price' => 85,
                'rating' => '4.9',
                'popularity' => 100,
                'db' => ['id' => 1, 'adult' => 80, 'child' => 40],
                'overview' => 'A full-day cultural and nature experience in Materuni, the last village before Mount Kilimanjaro. Hike through lush farmland to a hidden 80-metre waterfall, learn about the Chagga people, roast and taste fresh coffee, and enjoy a traditional home-cooked lunch.',
                'quickFacts' => ['Duration' => '1 Day (approx. 8 hours)', 'Location' => 'Materuni Village, Moshi', 'Activity Level' => 'Moderate — short hike', 'Group Type' => 'Private or small group', 'Best Time' => 'Year-round (mornings)', 'Start Point' => 'Moshi or Arusha hotel'],
                'highlights' => [['icon' => 'fa-water', 'text' => 'Materuni Waterfall'], ['icon' => 'fa-mug-hot', 'text' => 'Coffee Experience'], ['icon' => 'fa-users', 'text' => 'Chagga Culture'], ['icon' => 'fa-utensils', 'text' => 'Local Lunch'], ['icon' => 'fa-camera', 'text' => 'Photo Spots'], ['icon' => 'fa-leaf', 'text' => 'Nature Walk']],
                'itinerary' => [
                    ['label' => '09:00 AM', 'title' => 'Pickup from Moshi / Arusha', 'desc' => 'Meet your guide and drive to Materuni Village at the foot of Kilimanjaro.', 'activities' => 'Scenic drive, briefing', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '10:15 AM', 'title' => 'Arrive & Cultural Introduction', 'desc' => 'Introduction to the Chagga community and village life.', 'activities' => 'Cultural briefing', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '10:45 AM', 'title' => 'Hike to Materuni Waterfall', 'desc' => 'A guided hike through farmland and rainforest to the 80m waterfall.', 'activities' => 'Hiking, swimming', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '12:30 PM', 'title' => 'Traditional Lunch', 'desc' => 'Enjoy a home-cooked lunch prepared by local families.', 'activities' => 'Lunch', 'meals' => 'Lunch', 'accommodation' => '—'],
                    ['label' => '01:30 PM', 'title' => 'Coffee Tour & Tasting', 'desc' => 'Learn how Chagga coffee is grown, roasted and prepared — from bean to cup.', 'activities' => 'Coffee tour, tasting', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '03:30 PM', 'title' => 'Return Transfer', 'desc' => 'Drive back to your hotel in Moshi or Arusha.', 'activities' => 'Transfer', 'meals' => '—', 'accommodation' => '—'],
                ],
                'included' => ['Hotel pickup and drop-off (Moshi/Arusha)', 'Professional English-speaking guide', 'Materuni waterfall entry fee', 'Traditional Chagga lunch', 'Coffee tour and tasting', 'Drinking water', 'All government taxes'],
                'excluded' => ['Tips for guide', 'Alcoholic beverages', 'Personal expenses', 'Travel insurance', 'Souvenirs from village stalls'],
                'faqs' => [
                    ['q' => 'Is the hike difficult?', 'a' => 'The hike is moderate — about 45 minutes each way through farmland and forest. Most fitness levels can complete it.'],
                    ['q' => 'Can children join?', 'a' => 'Yes, children are welcome. We recommend ages 6 and above for comfort on the hike.'],
                    ['q' => 'Is swimming possible?', 'a' => 'The waterfall pool is shallow and cold. Swimming is possible but not guaranteed depending on water levels.'],
                    ['q' => 'Is coffee included?', 'a' => 'Yes, the coffee tour and tasting is included in the price.'],
                    ['q' => 'Where does pickup happen?', 'a' => 'We pick up from any hotel in Moshi or Arusha. Pickup from other locations can be arranged for a small supplement.'],
                ],
                'gallery' => ['tourMateruni', 'tourMarangu', 'galleryLandscape1'],
                'reviews' => [
                    ['author' => 'Sarah M.', 'country' => 'UK', 'text' => 'An incredible day. The waterfall was stunning and the coffee experience was authentic.'],
                    ['author' => 'Tom B.', 'country' => 'Canada', 'text' => 'Our guide was fantastic. Great value for money.'],
                ],
            ],

            'chemka-hot-springs-day-trip' => [
                'id' => 'chemka-hot-springs',
                'category' => 'day-trip',
                'location' => 'Kikuletwa, near Moshi',
                'durationDays' => 1,
                'price' => 70,
                'rating' => '4.8',
                'popularity' => 95,
                'db' => ['id' => 2, 'adult' => 90, 'child' => 45],
                'overview' => 'Escape to the crystal-clear turquoise waters of Chemka (Kikuletwa) Hot Springs — a natural oasis surrounded by fig trees in the dry Tanzanian landscape. Swim, relax and enjoy a local lunch.',
                'quickFacts' => ['Duration' => '1 Day (approx. 7 hours)', 'Location' => 'Kikuletwa, near Moshi', 'Activity Level' => 'Easy', 'Group Type' => 'Private or small group', 'Best Time' => 'Year-round', 'Start Point' => 'Moshi or Arusha hotel'],
                'highlights' => [['icon' => 'fa-water', 'text' => 'Natural Hot Springs'], ['icon' => 'fa-swimmer', 'text' => 'Swimming'], ['icon' => 'fa-tree', 'text' => 'Fig Tree Oasis'], ['icon' => 'fa-utensils', 'text' => 'Local Lunch'], ['icon' => 'fa-camera', 'text' => 'Photo Spots'], ['icon' => 'fa-sun', 'text' => 'Relaxation']],
                'itinerary' => [
                    ['label' => '09:00 AM', 'title' => 'Pickup', 'desc' => 'Hotel pickup in Moshi or Arusha.', 'activities' => 'Transfer', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '10:15 AM', 'title' => 'Arrive at Chemka', 'desc' => 'Settle in beside the warm springs and swim in the clear water.', 'activities' => 'Swimming, relaxing', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '12:30 PM', 'title' => 'Local Lunch', 'desc' => 'Enjoy a freshly prepared local lunch on-site.', 'activities' => 'Lunch', 'meals' => 'Lunch', 'accommodation' => '—'],
                    ['label' => '01:30 PM', 'title' => 'Free Time & Swimming', 'desc' => 'Continue swimming, relaxing or exploring the springs.', 'activities' => 'Swimming', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '03:30 PM', 'title' => 'Return Transfer', 'desc' => 'Drive back to your hotel.', 'activities' => 'Transfer', 'meals' => '—', 'accommodation' => '—'],
                ],
                'included' => ['Hotel pickup and drop-off', 'Professional guide', 'Chemka entry fee', 'Local lunch', 'Drinking water', 'All government taxes'],
                'excluded' => ['Tips', 'Alcoholic beverages', 'Personal expenses', 'Travel insurance', 'Towels and swimwear'],
                'faqs' => [
                    ['q' => 'Is swimming safe?', 'a' => 'Yes. The springs are shallow and calm, suitable for all swimming abilities. Life jackets available on request.'],
                    ['q' => 'What should I bring?', 'a' => 'Swimwear, towel, sunscreen, flip-flops, a change of clothes and a camera.'],
                    ['q' => 'Are towels provided?', 'a' => 'No. Please bring your own towel and swimwear.'],
                    ['q' => 'Can children participate?', 'a' => 'Yes. Chemka is a great family day trip. Children should be supervised near the water.'],
                    ['q' => 'Is lunch included?', 'a' => 'Yes, a local lunch is included in the price.'],
                ],
                'gallery' => ['tourChemka', 'tourMateruni', 'galleryLandscape1'],
                'reviews' => [
                    ['author' => 'Elena R.', 'country' => 'Italy', 'text' => 'Beautiful spot. The water was warm and clear. Great way to spend a day.'],
                    ['author' => 'Mark T.', 'country' => 'Germany', 'text' => 'Relaxing day. Lunch was simple but tasty.'],
                ],
            ],

            'marangu-cultural-tour' => [
                'id' => 'marangu-cultural',
                'category' => 'cultural',
                'location' => 'Marangu, Kilimanjaro Region',
                'durationDays' => 1,
                'price' => 75,
                'rating' => '4.8',
                'popularity' => 80,
                'db' => ['id' => 3, 'adult' => 70, 'child' => 35],
                'overview' => 'A full-day cultural immersion in Marangu, home of the Chagga people. Visit a waterfall, explore ancient Chagga caves, tour a coffee farm, visit the Chagga museum and enjoy a traditional lunch.',
                'quickFacts' => ['Duration' => '1 Day (approx. 7 hours)', 'Location' => 'Marangu, Kilimanjaro', 'Activity Level' => 'Easy to moderate', 'Group Type' => 'Private or small group', 'Best Time' => 'Year-round', 'Start Point' => 'Moshi or Arusha hotel'],
                'highlights' => [['icon' => 'fa-water', 'text' => 'Waterfall Visit'], ['icon' => 'fa-mountain', 'text' => 'Chagga Caves'], ['icon' => 'fa-mug-hot', 'text' => 'Coffee Experience'], ['icon' => 'fa-landmark', 'text' => 'Chagga Museum'], ['icon' => 'fa-users', 'text' => 'Cultural Experience'], ['icon' => 'fa-utensils', 'text' => 'Local Lunch']],
                'itinerary' => [
                    ['label' => '09:00 AM', 'title' => 'Pickup', 'desc' => 'Hotel pickup and drive to Marangu.', 'activities' => 'Transfer', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '10:00 AM', 'title' => 'Waterfall & Chagga Caves', 'desc' => 'Visit a scenic waterfall and explore the historic Chagga caves.', 'activities' => 'Hiking, cave tour', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '12:30 PM', 'title' => 'Traditional Lunch', 'desc' => 'Home-cooked Chagga lunch.', 'activities' => 'Lunch', 'meals' => 'Lunch', 'accommodation' => '—'],
                    ['label' => '01:30 PM', 'title' => 'Coffee Tour & Museum', 'desc' => 'Coffee experience and visit to the Chagga museum.', 'activities' => 'Coffee tour, museum', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '03:30 PM', 'title' => 'Return Transfer', 'desc' => 'Drive back to your hotel.', 'activities' => 'Transfer', 'meals' => '—', 'accommodation' => '—'],
                ],
                'included' => ['Hotel pickup and drop-off', 'Professional guide', 'All entry fees (waterfall, caves, museum)', 'Traditional lunch', 'Coffee experience', 'Drinking water', 'Government taxes'],
                'excluded' => ['Tips', 'Drinks', 'Personal expenses', 'Travel insurance', 'Souvenirs'],
                'faqs' => [
                    ['q' => 'What is the Chagga cave?', 'a' => 'The Chagga caves are historic underground hiding places used by the Chagga people during tribal wars. Your guide will explain their history.'],
                    ['q' => 'Is the tour suitable for children?', 'a' => 'Yes, though some walking is involved. We recommend ages 5 and above.'],
                    ['q' => 'Is the coffee tour included?', 'a' => 'Yes, the coffee experience is included.'],
                    ['q' => 'How long is the walking?', 'a' => 'About 1–2 hours of gentle walking throughout the day.'],
                    ['q' => 'Is lunch included?', 'a' => 'Yes, a traditional Chagga lunch is included.'],
                ],
                'gallery' => ['tourMarangu', 'tourMateruni', 'safariKilimanjaro'],
                'reviews' => [['author' => 'Nina K.', 'country' => 'Netherlands', 'text' => 'Learned so much about Chagga culture. The caves were fascinating.']],
            ],

            'kilimanjaro-day-hike-marangu' => [
                'id' => 'kilimanjaro-day-hike',
                'category' => 'kilimanjaro',
                'location' => 'Marangu Gate, Kilimanjaro',
                'durationDays' => 1,
                'price' => 180,
                'rating' => '4.9',
                'popularity' => 90,
                'db' => ['id' => 4, 'adult' => 250, 'child' => 125],
                'overview' => 'A one-day taste of Kilimanjaro. Enter the Marangu Gate, hike through the rainforest to Mandara Hut (2,720m), optionally climb to Maundi Crater, then descend and return to your hotel — all with park rescue coverage.',
                'quickFacts' => ['Duration' => '1 Day (approx. 8–10 hours)', 'Location' => 'Marangu Route, Kilimanjaro', 'Activity Level' => 'Moderate', 'Group Type' => 'Private', 'Best Time' => 'Year-round', 'Start Point' => 'Moshi or Arusha hotel'],
                'highlights' => [['icon' => 'fa-mountain', 'text' => 'Marangu Gate'], ['icon' => 'fa-tree', 'text' => 'Rainforest Hike'], ['icon' => 'fa-flag', 'text' => 'Mandara Hut (2,720m)'], ['icon' => 'fa-mountain-sun', 'text' => 'Maundi Crater'], ['icon' => 'fa-hiking', 'text' => 'Guided Trek'], ['icon' => 'fa-camera', 'text' => 'Scenic Views']],
                'itinerary' => [
                    ['label' => '07:00 AM', 'title' => 'Pickup & Drive to Marangu Gate', 'desc' => 'Hotel pickup, drive to Kilimanjaro National Park Marangu Gate for registration.', 'activities' => 'Transfer, registration', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '08:30 AM', 'title' => 'Begin Rainforest Hike', 'desc' => 'Hike through lush rainforest, home to colobus and blue monkeys.', 'activities' => 'Hiking', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '11:30 AM', 'title' => 'Arrive Mandara Hut', 'desc' => 'Reach Mandara Hut (2,720m). Rest and enjoy packed lunch.', 'activities' => 'Lunch, rest', 'meals' => 'Lunch', 'accommodation' => '—'],
                    ['label' => '12:30 PM', 'title' => 'Optional Maundi Crater', 'desc' => 'Optional 30-minute climb to Maundi Crater for views into Kenya and Tanzania.', 'activities' => 'Optional hike', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '01:30 PM', 'title' => 'Descend', 'desc' => 'Descend through the rainforest back to Marangu Gate.', 'activities' => 'Hiking', 'meals' => '—', 'accommodation' => '—'],
                    ['label' => '04:00 PM', 'title' => 'Return Transfer', 'desc' => 'Drive back to your hotel in Moshi or Arusha.', 'activities' => 'Transfer', 'meals' => '—', 'accommodation' => '—'],
                ],
                'included' => ['Hotel pickup and drop-off', 'Professional mountain guide', 'Kilimanjaro National Park entry fee', 'Park rescue coverage', 'Packed lunch', 'Drinking water', 'Government taxes'],
                'excluded' => ['Tips for guide and porters', 'Hiking gear (boots, poles, rain jacket)', 'Personal expenses', 'Travel insurance', 'Drinks'],
                'faqs' => [
                    ['q' => 'How high is Mandara Hut?', 'a' => 'Mandara Hut sits at 2,720 metres (8,923 ft) above sea level.'],
                    ['q' => 'Do I need hiking experience?', 'a' => 'No formal experience needed, but a reasonable level of fitness is recommended for the 3–4 hour ascent.'],
                    ['q' => 'What equipment is required?', 'a' => 'Sturdy hiking boots, rain jacket, warm layer, sun hat, sunscreen and a small daypack.'],
                    ['q' => 'What happens if weather changes?', 'a' => 'Our guides monitor conditions closely. In extreme weather the route may be shortened or adjusted for safety.'],
                    ['q' => 'Is park rescue coverage included?', 'a' => 'Yes, Kilimanjaro National Park rescue coverage is included in the park fee.'],
                ],
                'gallery' => ['safariKilimanjaro', 'tourKiliDay', 'tourMarangu'],
                'reviews' => [['author' => 'David K.', 'country' => 'USA', 'text' => 'Perfect introduction to Kilimanjaro. Well-paced and our guide was excellent.']],
            ],

            '3-day-tarangire-ngorongoro-safari' => [
                'id' => 'tarangire-ngorongoro-3day',
                'category' => 'safari',
                'location' => 'Tarangire • Ngorongoro • Lake Manyara',
                'durationDays' => 3,
                'price' => 650,
                'rating' => '4.9',
                'popularity' => 98,
                'db' => null,
                'overview' => 'A classic northern circuit safari covering Tarangire National Park, the Ngorongoro Crater and a Lake Manyara viewpoint with optional Mto wa Mbu cultural visit. Departs from Moshi or Arusha.',
                'quickFacts' => ['Duration' => '3 Days / 2 Nights', 'Location' => 'Tarangire • Ngorongoro • Lake Manyara', 'Activity Level' => 'Easy', 'Group Type' => 'Private 4x4', 'Best Time' => 'June–October, Jan–Feb', 'Start Point' => 'Moshi or Arusha'],
                'highlights' => [['icon' => 'fa-elephant', 'text' => 'Tarangire Elephants'], ['icon' => 'fa-mountain', 'text' => 'Ngorongoro Crater'], ['icon' => 'fa-binoculars', 'text' => 'Big Five'], ['icon' => 'fa-users', 'text' => 'Mto wa Mbu Culture'], ['icon' => 'fa-camera', 'text' => 'Scenic Viewpoints'], ['icon' => 'fa-truck-monster', 'text' => 'Private 4x4']],
                'itinerary' => [
                    ['label' => 'DAY 01', 'title' => 'Moshi / Arusha → Tarangire National Park', 'desc' => 'Morning pickup and drive to Tarangire, famous for its elephant herds and baobabs. Full afternoon game drive. Dinner and overnight at your lodge/camp.', 'activities' => 'Game drive', 'meals' => 'Lunch, Dinner', 'accommodation' => 'Lodge or Tented Camp'],
                    ['label' => 'DAY 02', 'title' => 'Ngorongoro Crater', 'desc' => 'Early descent into the Ngorongoro Crater for a full day of wildlife viewing — lions, elephants, rhino and more. Picnic lunch on the crater floor. Overnight near Karatu or the crater rim.', 'activities' => 'Crater tour, game drive', 'meals' => 'Breakfast, Lunch, Dinner', 'accommodation' => 'Lodge or Tented Camp'],
                    ['label' => 'DAY 03', 'title' => 'Lake Manyara Viewpoint / Mto wa Mbu → Moshi / Arusha', 'desc' => 'Morning visit to a Lake Manyara viewpoint and optional Mto wa Mbu cultural walk. Return to Moshi or Arusha by evening.', 'activities' => 'Viewpoint, cultural walk', 'meals' => 'Breakfast, Lunch', 'accommodation' => '—'],
                ],
                'included' => ['Private 4x4 safari vehicle with pop-up roof', 'Professional English-speaking guide', 'All park entry fees', 'Ngorongoro Crater service fee', '2 nights accommodation (lodge or tented camp)', 'Meals as per itinerary', 'Drinking water in vehicle', 'Government taxes'],
                'excluded' => ['International flights', 'Visa fees', 'Travel insurance', 'Tips for guide and cook', 'Alcoholic beverages', 'Personal expenses', 'Optional activities (balloon safari, etc.)'],
                'faqs' => [
                    ['q' => 'Can the safari start in Moshi?', 'a' => 'Yes, we offer pickup from both Moshi and Arusha at no extra cost.'],
                    ['q' => 'Can accommodation be upgraded?', 'a' => 'Yes, we can upgrade to luxury lodges on request. Please contact us for pricing.'],
                    ['q' => 'Is the safari private?', 'a' => 'Yes, this is a private safari — only your group in the vehicle.'],
                    ['q' => 'Are park fees included?', 'a' => 'Yes, all park fees and the Ngorongoro Crater service fee are included.'],
                    ['q' => 'Can the itinerary be customized?', 'a' => 'Yes. We can extend to the Serengeti, add days or adjust the route to suit your interests.'],
                    ['q' => 'What animals can we expect to see?', 'a' => 'Tarangire: elephants, giraffes, zebras, lions. Ngorongoro: lions, elephants, rhino, hippos, flamingos. Wildlife sightings are never guaranteed, but the northern circuit offers excellent odds.'],
                ],
                'gallery' => ['safariNgorongoro', 'safariSerengeti', 'galleryWildlife2'],
                'reviews' => [
                    ['author' => 'Mark & Julia T.', 'country' => 'Germany', 'text' => 'Superbly organised. The crater was a highlight of our entire trip.'],
                    ['author' => 'Priya S.', 'country' => 'India', 'text' => 'Our guide was amazing — so knowledgeable. Highly recommend this safari.'],
                ],
            ],

            'serengeti-ngorongoro-safari' => [
                'id' => 'serengeti-safari',
                'category' => 'safari',
                'location' => 'Serengeti • Ngorongoro',
                'durationDays' => 5,
                'price' => 1250,
                'rating' => '5.0',
                'popularity' => 96,
                'db' => ['id' => 5, 'adult' => 800, 'child' => 400],
                'overview' => 'The ultimate northern circuit safari. Tarangire, the Serengeti plains and the Ngorongoro Crater — five days of extraordinary wildlife viewing with a private guide and 4x4 vehicle.',
                'quickFacts' => ['Duration' => '5 Days / 4 Nights', 'Location' => 'Serengeti • Ngorongoro • Tarangire', 'Activity Level' => 'Easy', 'Group Type' => 'Private 4x4', 'Best Time' => 'June–October', 'Start Point' => 'Moshi or Arusha'],
                'highlights' => [['icon' => 'fa-lion', 'text' => 'Big Cats'], ['icon' => 'fa-paw', 'text' => 'Great Migration'], ['icon' => 'fa-mountain', 'text' => 'Ngorongoro Crater'], ['icon' => 'fa-elephant', 'text' => 'Tarangire'], ['icon' => 'fa-camera', 'text' => 'Photography'], ['icon' => 'fa-sun', 'text' => 'Sundowners']],
                'itinerary' => [
                    ['label' => 'DAY 01', 'title' => 'Moshi / Arusha → Tarangire', 'desc' => 'Pickup and drive to Tarangire National Park for an afternoon game drive.', 'activities' => 'Game drive', 'meals' => 'Lunch, Dinner', 'accommodation' => 'Lodge/Tented Camp'],
                    ['label' => 'DAY 02', 'title' => 'Tarangire → Serengeti', 'desc' => 'Drive to the Serengeti via Naabi Hill, with game viewing en route.', 'activities' => 'Game drive', 'meals' => 'Breakfast, Lunch, Dinner', 'accommodation' => 'Serengeti Lodge/Camp'],
                    ['label' => 'DAY 03', 'title' => 'Full Day Serengeti', 'desc' => 'Full day exploring the Serengeti plains — big cats, herds and endless horizons.', 'activities' => 'Game drive', 'meals' => 'Breakfast, Lunch, Dinner', 'accommodation' => 'Serengeti Lodge/Camp'],
                    ['label' => 'DAY 04', 'title' => 'Serengeti → Ngorongoro', 'desc' => 'Morning game drive, then transfer to the Ngorongoro highlands.', 'activities' => 'Game drive, transfer', 'meals' => 'Breakfast, Lunch, Dinner', 'accommodation' => 'Ngorongoro Lodge/Camp'],
                    ['label' => 'DAY 05', 'title' => 'Ngorongoro Crater → Moshi / Arusha', 'desc' => 'Descend into the crater for a full morning of wildlife viewing before returning.', 'activities' => 'Crater tour', 'meals' => 'Breakfast, Lunch', 'accommodation' => '—'],
                ],
                'included' => ['Private 4x4 safari vehicle', 'Professional guide', 'All park entry fees', 'Ngorongoro Crater service fee', '4 nights accommodation', 'Meals as per itinerary', 'Drinking water', 'Government taxes'],
                'excluded' => ['International flights', 'Visa fees', 'Travel insurance', 'Tips', 'Alcoholic beverages', 'Personal expenses', 'Optional balloon safari'],
                'faqs' => [
                    ['q' => 'Is this safari private?', 'a' => 'Yes, fully private for your group.'],
                    ['q' => 'Can I add Zanzibar?', 'a' => 'Yes — we can add a Zanzibar beach extension after the safari.'],
                    ['q' => 'Are park fees included?', 'a' => 'Yes, all park fees and crater service fees are included.'],
                    ['q' => 'What is the best time for the migration?', 'a' => 'The Great Migration is typically in the Serengeti from June to October, and calving season is January to February.'],
                    ['q' => 'Can children join?', 'a' => 'Yes, we welcome families. Please contact us for age-appropriate recommendations.'],
                    ['q' => 'Can the itinerary be customized?', 'a' => 'Absolutely — this is a starting point. Tell us your interests and we\'ll tailor it.'],
                ],
                'gallery' => ['safariSerengeti', 'safariNgorongoro', 'galleryWildlife2'],
                'reviews' => [['author' => 'Amelia R.', 'country' => 'UK', 'text' => 'Truly unforgettable. Every detail was handled beautifully.']],
            ],

            'ngorongoro-crater-safari' => [
                'id' => 'ngorongoro-safari',
                'category' => 'safari',
                'location' => 'Ngorongoro Crater',
                'durationDays' => 2,
                'price' => 420,
                'rating' => '4.9',
                'popularity' => 88,
                'db' => ['id' => 6, 'adult' => 600, 'child' => 300],
                'overview' => 'A focused two-day safari to the Ngorongoro Crater — a UNESCO World Heritage Site and one of the best places in Africa to see the Big Five in a single morning.',
                'quickFacts' => ['Duration' => '2 Days / 1 Night', 'Location' => 'Ngorongoro Crater', 'Activity Level' => 'Easy', 'Group Type' => 'Private 4x4', 'Best Time' => 'Year-round', 'Start Point' => 'Moshi or Arusha'],
                'highlights' => [['icon' => 'fa-mountain', 'text' => 'Crater Floor'], ['icon' => 'fa-rhino', 'text' => 'Black Rhino'], ['icon' => 'fa-lion', 'text' => 'Lions'], ['icon' => 'fa-binoculars', 'text' => 'Big Five'], ['icon' => 'fa-camera', 'text' => 'Photography'], ['icon' => 'fa-users', 'text' => 'Maasai Culture']],
                'itinerary' => [
                    ['label' => 'DAY 01', 'title' => 'Moshi / Arusha → Ngorongoro Highlands', 'desc' => 'Drive to the Ngorongoro highlands with a stop at a Maasai village en route.', 'activities' => 'Transfer, cultural visit', 'meals' => 'Lunch, Dinner', 'accommodation' => 'Lodge/Camp on the rim or Karatu'],
                    ['label' => 'DAY 02', 'title' => 'Ngorongoro Crater → Moshi / Arusha', 'desc' => 'Early descent into the crater for a full morning of game viewing, then return.', 'activities' => 'Crater tour', 'meals' => 'Breakfast, Lunch', 'accommodation' => '—'],
                ],
                'included' => ['Private 4x4 safari vehicle', 'Professional guide', 'Ngorongoro Crater entry fee', 'Crater service fee', '1 night accommodation', 'Meals as per itinerary', 'Drinking water', 'Government taxes'],
                'excluded' => ['International flights', 'Visa', 'Insurance', 'Tips', 'Drinks', 'Personal expenses'],
                'faqs' => [
                    ['q' => 'How deep is the crater?', 'a' => 'The Ngorongoro Crater is about 610 metres deep and 260 km² in area.'],
                    ['q' => 'Will I see the Big Five?', 'a' => 'The crater is one of the best places in Africa for the Big Five, though wildlife sightings are never guaranteed.'],
                    ['q' => 'Is it cold on the rim?', 'a' => 'Yes, the crater rim can be cold at night. Bring warm layers.'],
                    ['q' => 'Can I combine with Tarangire?', 'a' => 'Yes — we recommend combining with Tarangire or Lake Manyara.'],
                    ['q' => 'Is it suitable for children?', 'a' => 'Yes, families are welcome.'],
                ],
                'gallery' => ['safariNgorongoro', 'safariSerengeti', 'galleryWildlife1'],
                'reviews' => [['author' => 'Rob H.', 'country' => 'Australia', 'text' => 'The crater is magical. We saw four of the Big Five in one morning.']],
            ],

            'zanzibar-escape' => [
                'id' => 'zanzibar-escape',
                'category' => 'beach',
                'location' => 'Zanzibar',
                'durationDays' => 4,
                'price' => 520,
                'rating' => '4.9',
                'popularity' => 85,
                'db' => null,
                'overview' => 'A relaxed Zanzibar escape — historic Stone Town, spice farms, a sunset dhow cruise and plenty of beach time on the Indian Ocean.',
                'quickFacts' => ['Duration' => '4 Days / 3 Nights', 'Location' => 'Zanzibar', 'Activity Level' => 'Easy', 'Group Type' => 'Private', 'Best Time' => 'June–October', 'Start Point' => 'Zanzibar Airport'],
                'highlights' => [['icon' => 'fa-umbrella-beach', 'text' => 'Beaches'], ['icon' => 'fa-landmark', 'text' => 'Stone Town'], ['icon' => 'fa-seedling', 'text' => 'Spice Tour'], ['icon' => 'fa-ship', 'text' => 'Sunset Dhow'], ['icon' => 'fa-fish', 'text' => 'Snorkelling'], ['icon' => 'fa-camera', 'text' => 'Photography']],
                'itinerary' => [
                    ['label' => 'DAY 01', 'title' => 'Arrive Zanzibar', 'desc' => 'Airport pickup and transfer to your beach resort.', 'activities' => 'Transfer', 'meals' => 'Dinner', 'accommodation' => 'Beach Resort'],
                    ['label' => 'DAY 02', 'title' => 'Stone Town & Spice Tour', 'desc' => 'Guided tour of Stone Town and a spice farm.', 'activities' => 'Guided tour', 'meals' => 'Breakfast, Lunch', 'accommodation' => 'Beach Resort'],
                    ['label' => 'DAY 03', 'title' => 'Snorkelling & Sunset Dhow', 'desc' => 'Snorkelling trip and a sunset dhow cruise.', 'activities' => 'Snorkelling, dhow', 'meals' => 'Breakfast, Lunch', 'accommodation' => 'Beach Resort'],
                    ['label' => 'DAY 04', 'title' => 'Departure', 'desc' => 'Transfer to the airport.', 'activities' => 'Transfer', 'meals' => 'Breakfast', 'accommodation' => '—'],
                ],
                'included' => ['Airport transfers', '3 nights beach resort accommodation', 'Daily breakfast', 'Stone Town & spice tour', 'Snorkelling trip', 'Sunset dhow cruise', 'Government taxes'],
                'excluded' => ['International flights', 'Visa', 'Insurance', 'Tips', 'Drinks', 'Personal expenses', 'Optional activities'],
                'faqs' => [
                    ['q' => 'Can this combine with a safari?', 'a' => 'Yes — the perfect combination is a northern circuit safari followed by a Zanzibar beach escape.'],
                    ['q' => 'What is the best time to visit?', 'a' => 'June to October offers the driest and most comfortable weather.'],
                    ['q' => 'Is it family friendly?', 'a' => 'Yes, Zanzibar is a great destination for families.'],
                    ['q' => 'Do I need a visa?', 'a' => 'Most nationalities require a Tanzania visa. Please check with your local embassy.'],
                    ['q' => 'Are meals included?', 'a' => 'Breakfast is included daily. Other meals can be added on request.'],
                ],
                'gallery' => ['zanzibarBeach', 'galleryLandscape1', 'galleryPeople1'],
                'reviews' => [['author' => 'Sophie L.', 'country' => 'France', 'text' => 'The perfect end to our Tanzania trip. Stone Town was fascinating.']],
            ],

            'kilimanjaro-trek-machame' => [
                'id' => 'kilimanjaro-trek',
                'category' => 'kilimanjaro',
                'location' => 'Machame Route, Kilimanjaro',
                'durationDays' => 7,
                'price' => 1850,
                'rating' => '5.0',
                'popularity' => 88,
                'db' => null,
                'overview' => 'The Machame Route is the most scenic route on Kilimanjaro, with excellent acclimatisation and a high summit success rate. Seven days through rainforest, moorland, alpine desert and the arctic summit zone.',
                'quickFacts' => ['Duration' => '7 Days / 6 Nights', 'Location' => 'Machame Route, Kilimanjaro', 'Activity Level' => 'Challenging', 'Group Type' => 'Private or small group', 'Best Time' => 'Jan–Mar, Jun–Oct', 'Start Point' => 'Moshi'],
                'highlights' => [['icon' => 'fa-mountain', 'text' => 'Uhuru Peak 5,895m'], ['icon' => 'fa-tree', 'text' => 'Rainforest Zone'], ['icon' => 'fa-mountain-sun', 'text' => 'Alpine Desert'], ['icon' => 'fa-snowflake', 'text' => 'Arctic Summit'], ['icon' => 'fa-hiking', 'text' => 'Expert Crews'], ['icon' => 'fa-camera', 'text' => 'Stunning Views']],
                'itinerary' => [
                    ['label' => 'DAY 01', 'title' => 'Machame Gate → Machame Camp', 'desc' => 'Begin your trek through the rainforest (1,830m to 3,000m).', 'activities' => 'Trekking', 'meals' => 'All meals', 'accommodation' => 'Machame Camp'],
                    ['label' => 'DAY 02', 'title' => 'Machame Camp → Shira Camp', 'desc' => 'Trek through moorland to Shira Plateau (3,840m).', 'activities' => 'Trekking', 'meals' => 'All meals', 'accommodation' => 'Shira Camp'],
                    ['label' => 'DAY 03', 'title' => 'Shira Camp → Lava Tower → Barranco', 'desc' => 'Acclimatisation day via Lava Tower (4,630m).', 'activities' => 'Trekking', 'meals' => 'All meals', 'accommodation' => 'Barranco Camp'],
                    ['label' => 'DAY 04', 'title' => 'Barranco Camp → Karanga Camp', 'desc' => 'Trek through alpine desert to Karanga (4,035m).', 'activities' => 'Trekking', 'meals' => 'All meals', 'accommodation' => 'Karanga Camp'],
                    ['label' => 'DAY 05', 'title' => 'Karanga Camp → Barafu Camp', 'desc' => 'Trek to Barafu Base Camp (4,673m), prepare for summit.', 'activities' => 'Trekking', 'meals' => 'All meals', 'accommodation' => 'Barafu Camp'],
                    ['label' => 'DAY 06', 'title' => 'Summit Day → Mweka Camp', 'desc' => 'Reach Uhuru Peak (5,895m) at sunrise, then descend to Mweka.', 'activities' => 'Summit, descent', 'meals' => 'All meals', 'accommodation' => 'Mweka Camp'],
                    ['label' => 'DAY 07', 'title' => 'Mweka Camp → Moshi', 'desc' => 'Descend through rainforest and receive your summit certificate.', 'activities' => 'Trekking, transfer', 'meals' => 'Breakfast', 'accommodation' => '—'],
                ],
                'included' => ['Park fees and rescue fees', 'Professional mountain guides', 'Porters and cook', 'Camping equipment (tents, mats)', 'All meals on the mountain', 'Drinking water', 'Transfers', 'Summit certificate'],
                'excluded' => ['International flights', 'Visa', 'Insurance', 'Personal hiking gear', 'Tips for crew', 'Personal expenses'],
                'faqs' => [
                    ['q' => 'How difficult is the Machame Route?', 'a' => 'It\'s a challenging trek suitable for reasonably fit hikers. The main challenge is altitude, which is why we use a 7-day itinerary for better acclimatisation.'],
                    ['q' => 'Do I need previous hiking experience?', 'a' => 'No, but a good level of fitness and some training is strongly recommended.'],
                    ['q' => 'What gear do I need?', 'a' => 'Warm layers, waterproof jacket, hiking boots, sleeping bag, headlamp, sun protection and personal medication.'],
                    ['q' => 'What is the success rate?', 'a' => 'The Machame Route has a high summit success rate, especially on the 7-day itinerary.'],
                    ['q' => 'Is travel insurance required?', 'a' => 'Yes, comprehensive travel insurance with high-altitude coverage is mandatory.'],
                ],
                'gallery' => ['safariKilimanjaro', 'tourKiliDay', 'galleryLandscape2'],
                'reviews' => [['author' => 'James H.', 'country' => 'USA', 'text' => 'Summiting at sunrise was the experience of a lifetime. The crew was outstanding.']],
            ],
        ];
    }

    /**
     * Build the window.TDTS.TOURS payload: static content map merged with published DB destinations.
     *
     * DB rows win for admin-editable fields. Rich content stored on the destination row
     * (long_description, highlights, itinerary, includes, excluded, faqs, gallery, quick_facts,
     * location, rating) takes precedence over the static map; the static map acts as a fallback
     * so unedited tours render exactly as before. Admin-created rows with no static counterpart
     * are rendered from the DB alone, and the synthetic "custom safari" entry is always appended.
     *
     * @param  Collection|iterable  $destinations  published destinations
     */
    public static function buildTours($destinations): array
    {
        $tours = [];
        $byId = [];
        $bySlug = [];
        $claimed = [];

        foreach ($destinations as $d) {
            $o = is_object($d) ? $d : (object) $d;
            $byId[(int) ($o->id ?? 0)] = $o;
            if (! empty($o->slug)) {
                $bySlug[$o->slug] = $o;
            }
        }

        // 1. Static tours first (preserves current ordering); the DB row wins where one exists.
        foreach (self::contentTours() as $key => $t) {
            $d = null;
            $dbId = $t['db']['id'] ?? null;
            if ($dbId !== null && isset($byId[(int) $dbId])) {
                $d = $byId[(int) $dbId];
            } elseif (isset($bySlug[$key])) {
                $d = $bySlug[$key];
            }
            if ($d) {
                $claimed[(int) $d->id] = true;
            }
            $tours[] = self::mergeTour($key, $t, $d);
        }

        // 2. Admin-created destinations that have no static counterpart.
        foreach ($destinations as $row) {
            $o = is_object($row) ? $row : (object) $row;
            $id = (int) ($o->id ?? 0);
            if (isset($claimed[$id])) {
                continue;
            }
            $key = $o->slug ?: ('tour-'.$id);
            $tours[] = self::mergeTour($key, [], $o);
        }

        // 3. Synthetic custom safari entry (routes to /contact as an admin Message).
        $tours[] = self::syntheticCustomSafari();

        return $tours;
    }

    /** Front-end listing categories — aligned with the /tours landing pages. */
    public const LISTING_CATEGORIES = ['day-trip', 'safari', 'kilimanjaro', 'cultural', 'beach', 'custom'];

    /**
     * Render a single tour entry, preferring DB values over the static content map.
     *
     * @param  string  $key  content-map key (code slug)
     * @param  array  $t  static content (may be empty for admin-only rows)
     * @param  object|null  $d  matched DB destination row
     */
    private static function mergeTour(string $key, array $t, ?object $d): array
    {
        $hasCode = ! empty($t);

        $title = $d->name ?? ($t['title'] ?? self::titleFromKey($key));
        $slug = $d->slug ?? ($t['slug'] ?? $key);
        $category = self::listingCategory($d->category ?? ($t['category'] ?? null));

        $duration = $d && $d->duration ? $d->duration : ($t['duration'] ?? self::durationFromDays($t['durationDays'] ?? 1));
        $durationDays = (int) ($t['durationDays'] ?? 1);
        if (preg_match('/^\s*(\d+)/', (string) $duration, $m) && (int) $m[1] > 0) {
            $durationDays = (int) $m[1];
        }

        $adult = $d
            ? (float) ($d->price_adult ?: ($d->price ?: ($t['db']['adult'] ?? $t['price'] ?? 0)))
            : (float) ($t['db']['adult'] ?? $t['price'] ?? 0);
        $child = $d
            ? (float) ($d->price_child ?: ($t['db']['child'] ?? ($adult / 2)))
            : (float) ($t['db']['child'] ?? 0);
        $price = $d ? (float) ($d->price_adult ?: ($d->price ?: $adult)) : (float) ($t['price'] ?? $adult);
        $db = $d
            ? ['id' => (int) $d->id, 'adult' => $adult, 'child' => $child]
            : ($hasCode ? ($t['db'] ?: null) : null);

        $location = $d && trim((string) ($d->location ?? '')) !== '' ? $d->location : ($t['location'] ?? '');
        $overview = $d && trim((string) ($d->long_description ?? '')) !== '' ? $d->long_description : ($t['overview'] ?? ($d->desc ?? ''));
        $rating = $d && trim((string) ($d->rating ?? '')) !== '' ? trim((string) $d->rating) : (string) ($t['rating'] ?? '4.9');
        $popularity = (int) ($t['popularity'] ?? 50);

        $quickFacts = self::quickFactsOrNull($d->quick_facts ?? null) ?? ($t['quickFacts'] ?? []);
        $highlights = self::rowsOrNull($d->highlights ?? null) ?? ($t['highlights'] ?? []);
        $itinerary = self::rowsOrNull($d->itinerary ?? null) ?? ($t['itinerary'] ?? []);
        $included = self::listOrNull($d->includes ?? null) ?? ($t['included'] ?? []);
        $excluded = self::listOrNull($d->excluded ?? null) ?? ($t['excluded'] ?? []);
        $faqs = array_values(array_filter(self::rowsOrNull($d->faqs ?? null) ?? ($t['faqs'] ?? []), fn ($f) => is_array($f) && trim((string) ($f['q'] ?? '')) !== '' && trim((string) ($f['a'] ?? '')) !== ''));
        $gallery = self::resolveGallery($d->gallery ?? null);
        if (! $gallery) {
            $gallery = self::resolveGallery($t['gallery'] ?? []);
        }

        $image = $d && $d->image ? $d->image : ($t['image'] ?? self::cld(self::F['safariSerengeti'], 900));

        return [
            'id' => $hasCode ? ($t['id'] ?? $key) : (int) ($d->id ?? 0),
            'title' => $title,
            'slug' => $slug,
            'category' => $category,
            'location' => $location,
            'duration' => $duration,
            'durationDays' => $durationDays,
            'price' => $price,
            'image' => $image,
            'rating' => $rating,
            'popularity' => $popularity,
            'db' => $db,
            'overview' => $overview,
            'quickFacts' => $quickFacts,
            'highlights' => $highlights,
            'itinerary' => $itinerary,
            'included' => $included,
            'excluded' => $excluded,
            'faqs' => $faqs,
            'gallery' => $gallery,
            'reviews' => $t['reviews'] ?? [],
        ];
    }

    /** Map a stored DB category to a front-end listing category (legacy values included). */
    public static function listingCategory($category): string
    {
        $c = is_string($category) ? mb_strtolower(trim($category)) : '';

        if (in_array($c, self::LISTING_CATEGORIES, true)) {
            return $c;
        }

        return match ($c) {
            'day trip' => 'day-trip',
            'multi-day safari', 'multi-day' => 'safari',
            default => 'day-trip',
        };
    }

    /** Title-case a content-map key for display. */
    private static function titleFromKey(string $key): string
    {
        return ucwords(str_replace(['-', '_'], ' ', $key));
    }

    /** Build a "N Days / N-1 Nights" duration string (or "1 Day"). */
    private static function durationFromDays(int $days): string
    {
        return $days > 1 ? $days.' Days / '.($days - 1).' Nights' : '1 Day';
    }

    /** Filter a list of strings, returning null when every entry is blank. */
    private static function listOrNull($arr): ?array
    {
        if (! is_array($arr)) {
            return null;
        }
        $out = array_values(array_filter($arr, fn ($i) => trim((string) $i) !== ''));

        return $out ?: null;
    }

    /** Filter an array of keyed rows, dropping fully-blank rows; null when none remain. */
    private static function rowsOrNull($arr): ?array
    {
        if (! is_array($arr)) {
            return null;
        }
        $out = [];
        foreach ($arr as $row) {
            if (! is_array($row)) {
                continue;
            }
            $vals = array_map(fn ($v) => trim((string) ($v ?? '')), $row);
            if (implode('', $vals) !== '') {
                $out[] = $row;
            }
        }

        return $out ?: null;
    }

    /** Convert [{label, value}] quick-fact rows to the assoc shape the front-end expects. */
    private static function quickFactsOrNull($arr): ?array
    {
        $out = [];
        foreach (is_array($arr) ? $arr : [] as $row) {
            $label = trim((string) ($row['label'] ?? ''));
            $value = trim((string) ($row['value'] ?? ''));
            if ($label === '' || $value === '') {
                continue;
            }
            $out[$label] = $value;
        }

        return $out ?: null;
    }

    /** Resolve gallery entries (Cloudinary keys or raw URLs). */
    private static function resolveGallery($arr): array
    {
        $out = [];
        foreach (is_array($arr) ? $arr : [] as $g) {
            $g = trim((string) $g);
            if ($g === '') {
                continue;
            }
            $out[] = isset(self::F[$g]) ? self::cld(self::F[$g], 700) : $g;
        }

        return $out;
    }

    /** The synthetic "custom safari" tour entry. */
    private static function syntheticCustomSafari(): array
    {
        return [
            'id' => 'custom-safari',
            'title' => 'Custom Tanzania Safari',
            'slug' => 'custom-safari',
            'category' => 'custom',
            'location' => 'Tanzania — Your Choice',
            'duration' => 'Flexible',
            'durationDays' => 0,
            'price' => 0,
            'image' => self::cld(self::F['safariMikumi'], 900),
            'rating' => '5.0',
            'popularity' => 75,
            'db' => null,
            'overview' => 'Design a Tanzania journey around your time, interests and travel style. Whether you want a family safari, honeymoon escape, photography expedition or a mix of safari and beach — we\'ll build it for you.',
            'quickFacts' => ['Duration' => 'Flexible', 'Location' => 'Tanzania — Your Choice', 'Activity Level' => 'Your Choice', 'Group Type' => 'Private', 'Best Time' => 'Any', 'Start Point' => 'Your Choice'],
            'highlights' => [['icon' => 'fa-pencil-ruler', 'text' => 'Tailor-Made'], ['icon' => 'fa-user-tie', 'text' => 'Private Guide'], ['icon' => 'fa-calendar-alt', 'text' => 'Your Dates'], ['icon' => 'fa-wallet', 'text' => 'Your Budget'], ['icon' => 'fa-map', 'text' => 'Your Route'], ['icon' => 'fa-heart', 'text' => 'Your Interests']],
            'itinerary' => [
                ['label' => 'STEP 01', 'title' => 'Tell Us Your Dream', 'desc' => 'Share your travel dates, interests, budget and group size.', 'activities' => 'Consultation', 'meals' => '—', 'accommodation' => '—'],
                ['label' => 'STEP 02', 'title' => 'We Design', 'desc' => 'Our safari experts craft a custom itinerary tailored to you.', 'activities' => 'Itinerary design', 'meals' => '—', 'accommodation' => '—'],
                ['label' => 'STEP 03', 'title' => 'You Review', 'desc' => 'We refine the itinerary together until it\'s perfect.', 'activities' => 'Revision', 'meals' => '—', 'accommodation' => '—'],
                ['label' => 'STEP 04', 'title' => 'Confirm & Travel', 'desc' => 'Confirm your booking and enjoy your unique Tanzania journey.', 'activities' => 'Booking', 'meals' => '—', 'accommodation' => '—'],
            ],
            'included' => ['Personal safari consultant', 'Custom itinerary design', 'Private guide and 4x4 vehicle', 'Accommodation booking', 'Park fees (as per itinerary)', 'Meals (as per itinerary)'],
            'excluded' => ['International flights', 'Visa', 'Insurance', 'Tips', 'Personal expenses', 'Optional activities'],
            'faqs' => [
                ['q' => 'How much does a custom safari cost?', 'a' => 'Pricing depends on duration, accommodation level, group size and season. Contact us for a personalised quote.'],
                ['q' => 'How far in advance should I book?', 'a' => 'We recommend 3–6 months in advance, especially for peak season (June–October).'],
                ['q' => 'Can you accommodate dietary requirements?', 'a' => 'Yes, please let us know at the time of booking.'],
                ['q' => 'Can you combine safari and beach?', 'a' => 'Yes — a popular combination is a northern circuit safari followed by Zanzibar.'],
                ['q' => 'Do you arrange flights?', 'a' => 'We can advise on flights but international flights are booked separately.'],
            ],
            'gallery' => [self::cld(self::F['safariMikumi'], 700), self::cld(self::F['safariSerengeti'], 700), self::cld(self::F['zanzibarBeach'], 700)],
            'reviews' => [['author' => 'The Harris Family', 'country' => 'Canada', 'text' => 'They designed the perfect family safari for us. Every detail was considered.']],
        ];
    }

    /**
     * Build the window.TDTS.GALLERY payload from the DB gallery (fallback = static set).
     *
     * @param  Collection|iterable  $galleryRows
     */
    public static function buildGallery($galleryRows): array
    {
        $map = ['wildlife' => 'wildlife', 'landscape' => 'landscapes', 'landscapes' => 'landscapes', 'people' => 'safaris', 'tours' => 'safaris', 'culture' => 'culture'];

        $out = [];
        foreach ($galleryRows as $g) {
            $src = is_object($g) ? ($g->url ?? '') : ($g['url'] ?? '');
            if (empty($src)) {
                continue;
            }
            $cat = is_object($g) ? ($g->category ?? '') : ($g['category'] ?? '');
            $caption = is_object($g) ? ($g->caption ?? '') : ($g['caption'] ?? '');
            $out[] = ['src' => $src, 'cat' => $map[mb_strtolower((string) $cat)] ?? 'safaris', 'alt' => $caption ?: 'Tanzania safari photo'];
        }

        if ($out) {
            return $out;
        }

        // Static fallback so the gallery is never empty
        $static = [
            ['f' => 'safariSerengeti', 'cat' => 'wildlife', 'alt' => 'Lion portrait in the golden savanna'],
            ['f' => 'galleryWildlife1', 'cat' => 'wildlife', 'alt' => 'Lion resting in Serengeti'],
            ['f' => 'galleryWildlife2', 'cat' => 'wildlife', 'alt' => 'Elephant family at sunset'],
            ['f' => 'galleryLandscape1', 'cat' => 'landscapes', 'alt' => 'Serengeti dawn'],
            ['f' => 'galleryLandscape2', 'cat' => 'landscapes', 'alt' => 'Ngorongoro aerial view'],
            ['f' => 'tourMateruni', 'cat' => 'landscapes', 'alt' => 'Materuni waterfall'],
            ['f' => 'tourChemka', 'cat' => 'landscapes', 'alt' => 'Chemka hot springs'],
            ['f' => 'galleryPeople1', 'cat' => 'safaris', 'alt' => 'Safari excitement on a game drive'],
            ['f' => 'aboutHero', 'cat' => 'safaris', 'alt' => 'Campfire evening under the stars'],
            ['f' => 'tourArusha', 'cat' => 'safaris', 'alt' => 'Walking safari in Arusha'],
            ['f' => 'safariNgorongoro', 'cat' => 'safaris', 'alt' => 'Ngorongoro Crater game drive'],
            ['f' => 'safariKilimanjaro', 'cat' => 'kilimanjaro', 'alt' => 'Mount Kilimanjaro snow cap'],
            ['f' => 'tourKiliDay', 'cat' => 'kilimanjaro', 'alt' => 'Kilimanjaro rainforest trek'],
            ['f' => 'galleryCulture1', 'cat' => 'culture', 'alt' => 'Maasai village'],
            ['f' => 'tourMaasai', 'cat' => 'culture', 'alt' => 'Maasai warriors'],
            ['f' => 'zanzibarBeach', 'cat' => 'zanzibar', 'alt' => 'Zanzibar beach escape'],
        ];

        return array_map(function ($s) {
            return ['src' => self::cld(self::F[$s['f']], 700), 'cat' => $s['cat'], 'alt' => $s['alt']];
        }, $static);
    }

    /**
     * Build the window.TDTS.REVIEWS payload from published DB reviews (fallback = static set).
     *
     * @param  Collection|iterable  $reviewRows
     */
    public static function buildReviews($reviewRows): array
    {
        $out = [];
        foreach ($reviewRows as $r) {
            $name = is_object($r) ? ($r->name ?? '') : ($r['name'] ?? '');
            $tour = is_object($r) ? ($r->tour ?? '') : ($r['tour'] ?? '');
            $rating = (int) (is_object($r) ? ($r->rating ?? 5) : ($r['rating'] ?? 5));
            $text = is_object($r) ? ($r->text ?? '') : ($r['text'] ?? '');
            if (! $name || ! $text) {
                continue;
            }
            $out[] = ['stars' => max(1, min(5, $rating)), 'quote' => $text, 'author' => $name, 'meta' => $tour ? ucwords($tour).' Tour' : 'Tanzania Tour'];
        }

        if ($out) {
            return $out;
        }

        return [
            ['stars' => 5, 'quote' => 'An incredible day at Materuni. Our guide was knowledgeable, the coffee experience was authentic, and the waterfall was stunning.', 'author' => 'Sarah M.', 'meta' => 'United Kingdom • Materuni Waterfall Tour'],
            ['stars' => 5, 'quote' => 'We did the 3-day Tarangire and Ngorongoro safari. Everything was well organised, the vehicle was comfortable and we saw so much wildlife.', 'author' => 'Mark & Julia T.', 'meta' => 'Germany • 3-Day Safari'],
            ['stars' => 5, 'quote' => 'Perfect day trip to Chemka Hot Springs. Swimming in the warm water was a highlight of our trip. Highly recommend.', 'author' => 'Elena R.', 'meta' => 'Italy • Chemka Hot Springs'],
            ['stars' => 5, 'quote' => 'Our Kilimanjaro day hike was perfectly paced. Reaching Mandara Hut in the rainforest was a great taste of the mountain.', 'author' => 'David K.', 'meta' => 'USA • Kilimanjaro Day Hike'],
        ];
    }
}
