<?php

namespace App\Helpers;

class TourData
{
    public static function tours()
    {
        return [
            [
                'id' => 1,
                'slug' => 'materuni-waterfall-coffee-tour',
                'name' => 'Materuni Waterfall & Coffee Tour',
                'description' => 'Hike through lush forests to a stunning waterfall, then experience traditional coffee making.',
                'longDescription' => 'Embark on a scenic hike through the lush green forests of Materuni village near Moshi. The trail leads you to a magnificent 80-meter waterfall where you can swim in the refreshing pool below. After the hike, visit a local Chagga family to learn about traditional coffee processing — from bean to cup. Roast, grind, and brew your own coffee while hearing stories of local culture and traditions.',
                'image' => '/images/tour-materuni.jpg',
                'price' => 80,
                'duration' => '1 Day',
                'category' => 'day',
                'featured' => true,
                'includes' => ['Private transport', 'Professional guide', 'Village entry fees', 'Lunch box', 'Coffee tasting', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 2,
                'slug' => 'chemka-hot-springs',
                'name' => 'Chemka Hot Springs',
                'description' => 'Crystal-clear natural hot springs surrounded by jungle. Swim, swing, and relax.',
                'longDescription' => 'Also known as Kikuletwa Hot Springs, this hidden oasis features crystal-clear turquoise water surrounded by lush jungle and palm trees. The natural spring maintains a perfect temperature year-round. Swing from ropes, swim in the clear water, and enjoy a picnic lunch in this paradise-like setting. A perfect day trip for relaxation and nature lovers.',
                'image' => '/images/tour-chemka.jpg',
                'price' => 90,
                'duration' => '1 Day',
                'category' => 'day',
                'featured' => true,
                'includes' => ['Private 4x4 transport', 'English-speaking guide', 'Entry fees', 'Picnic lunch', 'Bottled water', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 3,
                'slug' => 'marangu-cultural-tour',
                'name' => 'Marangu Cultural Tour',
                'description' => 'Visit the historic Chagga tribe caves, waterfalls, and learn about local culture.',
                'longDescription' => 'Explore the rich cultural heritage of the Chagga people in Marangu village. Visit the historic Chagga Caves used during tribal wars, see the beautiful Ndoro Waterfalls, and walk through banana and coffee plantations. Learn about traditional Chagga building techniques, taste local banana beer, and experience the warm hospitality of the local community.',
                'image' => '/images/tour-marangu.jpg',
                'price' => 70,
                'duration' => '1 Day',
                'category' => 'cultural',
                'featured' => true,
                'includes' => ['Private transport', 'Local guide', 'Village entry fees', 'Lunch', 'Waterfall visit', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 4,
                'slug' => 'kilimanjaro-day-hike',
                'name' => 'Kilimanjaro Day Hike',
                'description' => 'Trek through Kilimanjaro\'s rainforest zone to Mandara Hut.',
                'longDescription' => 'Experience the majesty of Mount Kilimanjaro on a day hike to Mandara Hut (2,700m) via the Marangu Route. Trek through lush rainforest where you may spot Colobus monkeys and exotic birds. The trail offers stunning views of the mountain and surrounding landscape. Perfect for those who want a taste of Kilimanjaro without the full summit trek.',
                'image' => '/images/tour-kili-day.jpg',
                'price' => 250,
                'duration' => '1 Day',
                'category' => 'adventure',
                'featured' => true,
                'includes' => ['Park entry fees', 'Professional mountain guide', 'Lunch box', 'Drinking water', 'Rescue fees', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 5,
                'slug' => 'arusha-national-park',
                'name' => 'Arusha National Park',
                'description' => 'Walking safaris, canoe rides, and incredible wildlife in a compact park.',
                'longDescription' => 'Discover one of Tanzania\'s most diverse national parks. Arusha National Park offers unique walking safaris with an armed ranger, canoe trips on Momella Lakes, and game drives with stunning views of Mount Meru. Spot giraffes, buffalos, zebras, flamingos, and the elusive colobus monkeys in their natural habitat.',
                'image' => '/images/tour-arusha.jpg',
                'price' => 180,
                'duration' => '1 Day',
                'category' => 'wildlife',
                'featured' => true,
                'includes' => ['Private 4x4 safari vehicle', 'Professional guide', 'Park entry fees', 'Walking safari', 'Picnic lunch', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 6,
                'slug' => 'serval-wildlife-sanctuary',
                'name' => 'Serval Wildlife Sanctuary',
                'description' => 'An intimate wildlife experience with rescued animals.',
                'longDescription' => 'Visit the Serval Wildlife Sanctuary for an up-close encounter with rescued and rehabilitated animals. Hand-feed giraffes, observe habituated wildlife, and learn about conservation efforts in Tanzania. This ethical wildlife experience supports animal rescue and rehabilitation programs while offering unforgettable interactions.',
                'image' => '/images/tour-serval.jpg',
                'price' => 150,
                'duration' => '1 Day',
                'category' => 'wildlife',
                'featured' => true,
                'includes' => ['Private transport', 'Sanctuary entry fees', 'Guided tour', 'Animal feeding experience', 'Lunch', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 7,
                'slug' => 'maasai-boma-visit',
                'name' => 'Maasai Boma Visit',
                'description' => 'Experience authentic Maasai culture, dance, and traditional life.',
                'longDescription' => 'Immerse yourself in the vibrant culture of the Maasai people. Visit a traditional boma (village enclosure), witness the famous adumu jumping dance, learn about beadwork and traditional medicine, and hear stories passed down through generations. This authentic cultural experience directly supports the local Maasai community.',
                'image' => '/images/tour-maasai.jpg',
                'price' => 60,
                'duration' => '1 Day',
                'category' => 'cultural',
                'featured' => true,
                'includes' => ['Private transport', 'Maasai guide', 'Village donation', 'Traditional dance performance', 'Light refreshments', 'Hotel pick-up & drop-off']
            ],
            [
                'id' => 8,
                'slug' => 'zanzibar-day-trip',
                'name' => 'Zanzibar Day Trip',
                'description' => 'Stone Town spice markets, pristine beaches, and rich history.',
                'longDescription' => 'Explore the magical island of Zanzibar on a day trip from the mainland. Wander through the narrow alleys of historic Stone Town, visit the vibrant spice markets, see the House of Wonders and the Old Fort, and relax on pristine white-sand beaches with crystal-clear turquoise waters. A perfect blend of history, culture, and tropical paradise.',
                'image' => '/images/tour-zanzibar.jpg',
                'price' => 200,
                'duration' => '1 Day',
                'category' => 'day',
                'featured' => true,
                'includes' => ['Ferry tickets', 'Guided Stone Town tour', 'Spice tour', 'Lunch at local restaurant', 'Beach time', 'Hotel transfers']
            ],
            [
                'id' => 9,
                'slug' => 'serengeti-safari',
                'name' => 'Serengeti Safari',
                'description' => '3-5 days of unparalleled wildlife viewing in the world\'s most famous savanna.',
                'longDescription' => 'Witness the breathtaking Serengeti, home to the Great Migration and the highest concentration of wildlife on Earth. Our multi-day safari takes you deep into the heart of the savanna, where you\'ll encounter lions, elephants, leopards, cheetahs, and hundreds of thousands of wildebeest and zebras. Stay in comfortable lodges or luxury tented camps under the African stars.',
                'image' => '/images/safari-serengeti.jpg',
                'price' => 800,
                'duration' => '3-5 Days',
                'category' => 'multi',
                'featured' => true,
                'includes' => ['Private 4x4 safari vehicle', 'Professional guide', 'Park entry fees', 'Accommodation', 'All meals', 'Airport transfers']
            ],
            [
                'id' => 10,
                'slug' => 'ngorongoro-crater',
                'name' => 'Ngorongoro Crater',
                'description' => 'Descend into the world\'s largest inactive volcanic caldera teeming with wildlife.',
                'longDescription' => 'The Ngorongoro Crater is a UNESCO World Heritage Site and one of Africa\'s most remarkable natural wonders. Descend 600 meters into the world\'s largest inactive volcanic caldera, home to over 25,000 animals including the Big Five. The crater\'s enclosed ecosystem creates incredible wildlife density and some of the best game viewing in Africa.',
                'image' => '/images/safari-ngorongoro.jpg',
                'price' => 600,
                'duration' => '2-3 Days',
                'category' => 'multi',
                'featured' => true,
                'includes' => ['Private 4x4 safari vehicle', 'Professional guide', 'Crater entry fees', 'Accommodation', 'All meals', 'Airport transfers']
            ],
            [
                'id' => 11,
                'slug' => 'kilimanjaro-trek',
                'name' => 'Mount Kilimanjaro Trek',
                'description' => 'Conquer Africa\'s highest peak on routes ranging from 5 to 9 days.',
                'longDescription' => 'Stand on the Roof of Africa! Our Kilimanjaro treks offer routes for all experience levels, from the scenic Machame Route to the classic Marangu Route. With experienced mountain guides, porters, and quality equipment, we ensure your safety and comfort as you ascend through five distinct climate zones to reach Uhuru Peak at 5,895 meters.',
                'image' => '/images/safari-kilimanjaro.jpg',
                'price' => 1500,
                'duration' => '5-9 Days',
                'category' => 'adventure',
                'featured' => true,
                'includes' => ['Park fees & permits', 'Experienced guides & porters', 'All camping gear', 'All meals on mountain', 'Rescue fees', 'Hotel before & after trek']
            ],
            [
                'id' => 12,
                'slug' => 'mikumi-selous-safari',
                'name' => 'Mikumi & Selous Safari',
                'description' => 'Explore southern Tanzania\'s hidden gems with fewer crowds.',
                'longDescription' => 'Discover the wild beauty of southern Tanzania. Mikumi National Park offers excellent game viewing with large populations of elephants, lions, and wild dogs. Combined with Selous Game Reserve, one of the largest protected areas in Africa, this safari offers boat trips on the Rufiji River, walking safaris, and an authentic wilderness experience away from the crowds.',
                'image' => '/images/safari-mikumi.jpg',
                'price' => 700,
                'duration' => '3-4 Days',
                'category' => 'multi',
                'featured' => true,
                'includes' => ['Private 4x4 vehicle', 'Professional guide', 'Park entry fees', 'Accommodation', 'All meals', 'Boat safari', 'Airport transfers']
            ]
        ];
    }

    public static function testimonials()
    {
        return [
            [
                'id' => 1,
                'name' => 'Sarah M.',
                'trip' => 'Serengeti Safari',
                'text' => 'An absolutely magical experience. Our guide spotted a leopard in a tree within the first hour! The accommodations were perfect and every meal was delicious.',
                'rating' => 5,
                'verified' => true
            ],
            [
                'id' => 2,
                'name' => 'James K.',
                'trip' => 'Family Safari',
                'text' => 'We took our entire family including our 8-year-old. The team was so accommodating and patient. The kids still talk about the elephants every day.',
                'rating' => 5,
                'verified' => true
            ],
            [
                'id' => 3,
                'name' => 'Elena R.',
                'trip' => 'Kilimanjaro Trek',
                'text' => 'Climbing Kilimanjaro was a life-changing experience. The porters and guides were incredibly supportive. I couldn\'t have done it without their encouragement.',
                'rating' => 5,
                'verified' => true
            ],
            [
                'id' => 4,
                'name' => 'Michael T.',
                'trip' => 'Chemka Hot Springs',
                'text' => 'The most relaxing day of our entire trip! The hot springs are like a hidden paradise. Our guide made sure we had the best spots and told fascinating stories about the area.',
                'rating' => 5,
                'verified' => true
            ],
            [
                'id' => 5,
                'name' => 'Anna L.',
                'trip' => 'Maasai Boma Visit',
                'text' => 'An eye-opening cultural experience. The Maasai people were so welcoming and generous. The jumping dance was incredible to witness in person. Highly recommend!',
                'rating' => 5,
                'verified' => true
            ],
            [
                'id' => 6,
                'name' => 'David W.',
                'trip' => 'Ngorongoro Crater',
                'text' => 'The crater is like another planet. We saw rhinos, lions, and thousands of flamingos in one day. Our guide knew exactly where to go for the best sightings.',
                'rating' => 5,
                'verified' => true
            ]
        ];
    }

    public static function gallery()
    {
        return [
            ['id' => 1, 'src' => '/images/gallery-wildlife-1.jpg', 'title' => 'Lion Portrait', 'category' => 'wildlife'],
            ['id' => 2, 'src' => '/images/gallery-wildlife-2.jpg', 'title' => 'Elephant Family at Sunset', 'category' => 'wildlife'],
            ['id' => 3, 'src' => '/images/gallery-landscape-1.jpg', 'title' => 'Serengeti Dawn', 'category' => 'landscape'],
            ['id' => 4, 'src' => '/images/gallery-landscape-2.jpg', 'title' => 'Ngorongoro Aerial', 'category' => 'landscape'],
            ['id' => 5, 'src' => '/images/gallery-people-1.jpg', 'title' => 'Safari Excitement', 'category' => 'people'],
            ['id' => 6, 'src' => '/images/gallery-culture-1.jpg', 'title' => 'Maasai Village', 'category' => 'culture'],
            ['id' => 7, 'src' => '/images/tour-materuni.jpg', 'title' => 'Materuni Waterfall', 'category' => 'landscape'],
            ['id' => 8, 'src' => '/images/tour-chemka.jpg', 'title' => 'Chemka Hot Springs', 'category' => 'landscape'],
            ['id' => 9, 'src' => '/images/tour-arusha.jpg', 'title' => 'Walking Safari', 'category' => 'people'],
            ['id' => 10, 'src' => '/images/tour-maasai.jpg', 'title' => 'Maasai Warriors', 'category' => 'culture'],
            ['id' => 11, 'src' => '/images/about-hero.jpg', 'title' => 'Campfire Evening', 'category' => 'people'],
            ['id' => 12, 'src' => '/images/safari-serengeti.jpg', 'title' => 'Golden Savanna', 'category' => 'landscape']
        ];
    }

    public static function team()
    {
        return [
            [
                'id' => 1,
                'name' => 'John M.',
                'role' => 'Founder & Lead Guide',
                'bio' => '20 years of safari experience across all Tanzanian parks.',
                'image' => '/images/about-story.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Grace K.',
                'role' => 'Operations Manager',
                'bio' => 'Ensures every trip runs smoothly from booking to departure.',
                'image' => '/images/about-story.jpg'
            ],
            [
                'id' => 3,
                'name' => 'David N.',
                'role' => 'Senior Safari Guide',
                'bio' => 'Wildlife photographer and birding expert.',
                'image' => '/images/about-story.jpg'
            ],
            [
                'id' => 4,
                'name' => 'Maria S.',
                'role' => 'Customer Relations',
                'bio' => 'Your first point of contact for planning the perfect trip.',
                'image' => '/images/about-story.jpg'
            ]
        ];
    }

    public static function getTourBySlug($slug)
    {
        $tours = self::tours();
        foreach ($tours as $tour) {
            if ($tour['slug'] === $slug) {
                return $tour;
            }
        }
        return null;
    }
}
