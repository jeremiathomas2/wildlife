<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Destinations
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Materuni Waterfall & Coffee Tour'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 80, 'price_adult' => 80, 'price_child' => 40, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890319/tour-materuni_fnsdea.jpg', 'desc' => 'Hike through lush forests to a stunning waterfall, then experience traditional coffee making.', 'long_description' => 'Embark on a scenic hike through the lush green forests of Materuni village near Moshi. The trail leads you to a magnificent 80-meter waterfall where you can swim in the refreshing pool below. After the hike, visit a local Chagga family to learn about traditional coffee processing — from bean to cup. Roast, grind, and brew your own coffee while hearing stories of local culture and traditions.', 'includes' => ['Private transport', 'Professional guide', 'Village entry fees', 'Lunch box', 'Coffee tasting', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Chemka Hot Springs'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 90, 'price_adult' => 90, 'price_child' => 45, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890325/tour-chemka_tdh78w.jpg', 'desc' => 'Crystal-clear natural hot springs surrounded by jungle. Swim, swing, and relax.', 'long_description' => 'Also known as Kikuletwa Hot Springs, this hidden oasis features crystal-clear turquoise water surrounded by lush jungle and palm trees. The natural spring maintains a perfect temperature year-round. Swing from ropes, swim in the clear water, and enjoy a picnic lunch in this paradise-like setting. A perfect day trip for relaxation and nature lovers.', 'includes' => ['Private 4x4 transport', 'English-speaking guide', 'Entry fees', 'Picnic lunch', 'Bottled water', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Marangu Cultural Tour'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 70, 'price_adult' => 70, 'price_child' => 35, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890321/tour-marangu_bprorr.jpg', 'desc' => 'Visit the historic Chagga tribe caves, waterfalls, and learn about local culture.', 'long_description' => 'Explore the rich cultural heritage of the Chagga people in Marangu village. Visit the historic Chagga Caves used during tribal wars, see the beautiful Ndoro Waterfalls, and walk through banana and coffee plantations. Learn about traditional Chagga building techniques, taste local banana beer, and experience the warm hospitality of the local community.', 'includes' => ['Private transport', 'Local guide', 'Village entry fees', 'Lunch', 'Waterfall visit', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Kilimanjaro Day Hike'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 250, 'price_adult' => 250, 'price_child' => 125, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890324/tour-kili-day_brcn7n.jpg', 'desc' => 'Trek through Kilimanjaro\'s rainforest zone to Mandara Hut.', 'long_description' => 'Experience the majesty of Mount Kilimanjaro on a day hike to Mandara Hut (2,700m) via the Marangu Route. Trek through lush rainforest where you may spot Colobus monkeys and exotic birds. The trail offers stunning views of the mountain and surrounding landscape. Perfect for those who want a taste of Kilimanjaro without the full summit trek.', 'includes' => ['Park entry fees', 'Professional mountain guide', 'Lunch box', 'Drinking water', 'Rescue fees', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Arusha National Park'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 180, 'price_adult' => 180, 'price_child' => 90, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/tour-arusha_bzqksh.jpg', 'desc' => 'Walking safaris, canoe rides, and incredible wildlife in a compact park.', 'long_description' => 'Discover one of Tanzania\'s most diverse national parks. Arusha National Park offers unique walking safaris with an armed ranger, canoe trips on Momella Lakes, and game drives with stunning views of Mount Meru. Spot giraffes, buffalos, zebras, flamingos, and the elusive colobus monkeys in their natural habitat.', 'includes' => ['Private 4x4 safari vehicle', 'Professional guide', 'Park entry fees', 'Walking safari', 'Picnic lunch', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Serval Wildlife Sanctuary'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 150, 'price_adult' => 150, 'price_child' => 75, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/tour-serval_sxetg3.jpg', 'desc' => 'An intimate wildlife experience with rescued animals.', 'long_description' => 'Visit the Serval Wildlife Sanctuary for an up-close encounter with rescued and rehabilitated animals. Hand-feed giraffes, observe habituated wildlife, and learn about conservation efforts in Tanzania. This ethical wildlife experience supports animal rescue and rehabilitation programs while offering unforgettable interactions.', 'includes' => ['Private transport', 'Sanctuary entry fees', 'Guided tour', 'Animal feeding experience', 'Lunch', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Maasai Boma Visit'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 60, 'price_adult' => 60, 'price_child' => 30, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890319/tour-maasai_owadcl.jpg', 'desc' => 'Experience authentic Maasai culture, dance, and traditional life.', 'long_description' => 'Immerse yourself in the vibrant culture of the Maasai people. Visit a traditional boma (village enclosure), witness the famous adumu jumping dance, learn about beadwork and traditional medicine, and hear stories passed down through generations. This authentic cultural experience directly supports the local Maasai community.', 'includes' => ['Private transport', 'Maasai guide', 'Village donation', 'Traditional dance performance', 'Light refreshments', 'Hotel pick-up & drop-off']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Zanzibar Day Trip'],
            ['category' => 'Day Trip', 'duration' => '1 Day', 'price' => 200, 'price_adult' => 200, 'price_child' => 100, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890319/tour-zanzibar_y2syxk.jpg', 'desc' => 'Stone Town spice markets, pristine beaches, and rich history.', 'long_description' => 'Explore the magical island of Zanzibar on a day trip from the mainland. Wander through the narrow alleys of historic Stone Town, visit the vibrant spice markets, see the House of Wonders and the Old Fort, and relax on pristine white-sand beaches with crystal-clear turquoise waters. A perfect blend of history, culture, and tropical paradise.', 'includes' => ['Ferry tickets', 'Guided Stone Town tour', 'Spice tour', 'Lunch at local restaurant', 'Beach time', 'Hotel transfers']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Serengeti Safari'],
            ['category' => 'Multi-Day Safari', 'duration' => '3-5 Days', 'price' => 800, 'price_adult' => 800, 'price_child' => 400, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-serengeti_agwjrp.jpg', 'desc' => '3-5 days of unparalleled wildlife viewing in the world\'s most famous savanna.', 'long_description' => 'Witness the breathtaking Serengeti, home to the Great Migration and the highest concentration of wildlife on Earth. Our multi-day safari takes you deep into the heart of the savanna, where you\'ll encounter lions, elephants, leopards, cheetahs, and hundreds of thousands of wildebeest and zebras. Stay in comfortable lodges or luxury tented camps under the African stars.', 'includes' => ['Private 4x4 safari vehicle', 'Professional guide', 'Park entry fees', 'Accommodation', 'All meals', 'Airport transfers']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Ngorongoro Crater'],
            ['category' => 'Multi-Day Safari', 'duration' => '2-3 Days', 'price' => 600, 'price_adult' => 600, 'price_child' => 300, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-ngorongoro_j04gqg.jpg', 'desc' => 'Descend into the world\'s largest inactive volcanic caldera teeming with wildlife.', 'long_description' => 'The Ngorongoro Crater is a UNESCO World Heritage Site and one of Africa\'s most remarkable natural wonders. Descend 600 meters into the world\'s largest inactive volcanic caldera, home to over 25,000 animals including the Big Five. The crater\'s enclosed ecosystem creates incredible wildlife density and some of the best game viewing in Africa.', 'includes' => ['Private 4x4 safari vehicle', 'Professional guide', 'Crater entry fees', 'Accommodation', 'All meals', 'Airport transfers']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Mount Kilimanjaro Trek'],
            ['category' => 'Multi-Day Safari', 'duration' => '5-9 Days', 'price' => 1500, 'price_adult' => 1500, 'price_child' => 750, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890322/safari-kilimanjaro_rnqbaj.jpg', 'desc' => 'Conquer Africa\'s highest peak on routes ranging from 5 to 9 days.', 'long_description' => 'Stand on the Roof of Africa! Our Kilimanjaro treks offer routes for all experience levels, from the scenic Machame Route to the classic Marangu Route. With experienced mountain guides, porters, and quality equipment, we ensure your safety and comfort as you ascend through five distinct climate zones to reach Uhuru Peak at 5,895 meters.', 'includes' => ['Park fees & permits', 'Experienced guides & porters', 'All camping gear', 'All meals on mountain', 'Rescue fees', 'Hotel before & after trek']]
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Mikumi & Selous Safari'],
            ['category' => 'Multi-Day Safari', 'duration' => '3-4 Days', 'price' => 700, 'price_adult' => 700, 'price_child' => 350, 'status' => 'Published', 'image' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890326/safari-mikumi_suogue.jpg', 'desc' => 'Explore southern Tanzania\'s hidden gems with fewer crowds.', 'long_description' => 'Discover the wild beauty of southern Tanzania. Mikumi National Park offers excellent game viewing with large populations of elephants, lions, and wild dogs. Combined with Selous Game Reserve, one of the largest protected areas in Africa, this safari offers boat trips on the Rufiji River, walking safaris, and an authentic wilderness experience away from the crowds.', 'includes' => ['Private 4x4 vehicle', 'Professional guide', 'Park entry fees', 'Accommodation', 'All meals', 'Boat safari', 'Airport transfers']]
        );

        // Gallery
        $galleryItems = [
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890321/gallery-wildlife-1_tzfe6e.jpg', 'caption' => 'Lion Portrait', 'category' => 'wildlife'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890322/gallery-wildlife-2_fnrchg.jpg', 'caption' => 'Elephant Family at Sunset', 'category' => 'wildlife'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890318/gallery-landscape-1_dxdd6x.jpg', 'caption' => 'Serengeti Dawn', 'category' => 'landscape'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890321/gallery-landscape-2_cmzfxg.jpg', 'caption' => 'Ngorongoro Aerial', 'category' => 'landscape'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890321/gallery-people-1_q8uyjd.jpg', 'caption' => 'Safari Excitement', 'category' => 'people'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890319/gallery-culture-1_xmbakz.jpg', 'caption' => 'Maasai Village', 'category' => 'culture'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890319/tour-materuni_fnsdea.jpg', 'caption' => 'Materuni Waterfall', 'category' => 'landscape'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890325/tour-chemka_tdh78w.jpg', 'caption' => 'Chemka Hot Springs', 'category' => 'landscape'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/tour-arusha_bzqksh.jpg', 'caption' => 'Walking Safari', 'category' => 'people'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890319/tour-maasai_owadcl.jpg', 'caption' => 'Maasai Warriors', 'category' => 'culture'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890320/about-hero_dbeshf.jpg', 'caption' => 'Campfire Evening', 'category' => 'people'],
            ['url' => 'https://res.cloudinary.com/aenplcpl/image/upload/v1782890323/safari-serengeti_agwjrp.jpg', 'caption' => 'Golden Savanna', 'category' => 'landscape'],
        ];
        foreach ($galleryItems as $item) {
            \App\Models\Gallery::updateOrCreate(['url' => $item['url']], $item);
        }

        // Reviews
        $reviews = [
            ['name' => 'Sarah M.', 'tour' => 'Serengeti Safari', 'rating' => 5, 'status' => 'Published', 'text' => 'An absolutely magical experience. Our guide spotted a leopard in a tree within the first hour! The accommodations were perfect and every meal was delicious.'],
            ['name' => 'James K.', 'tour' => 'Family Safari', 'rating' => 5, 'status' => 'Published', 'text' => 'We took our entire family including our 8-year-old. The team was so accommodating and patient. The kids still talk about the elephants every day.'],
            ['name' => 'Elena R.', 'tour' => 'Kilimanjaro Trek', 'rating' => 5, 'status' => 'Published', 'text' => 'Climbing Kilimanjaro was a life-changing experience. The porters and guides were incredibly supportive. I couldn\'t have done it without their encouragement.'],
            ['name' => 'Michael T.', 'tour' => 'Chemka Hot Springs', 'rating' => 5, 'status' => 'Published', 'text' => 'The most relaxing day of our entire trip! The hot springs are like a hidden paradise. Our guide made sure we had the best spots and told fascinating stories about the area.'],
            ['name' => 'Anna L.', 'tour' => 'Maasai Boma Visit', 'rating' => 5, 'status' => 'Published', 'text' => 'An eye-opening cultural experience. The Maasai people were so welcoming and generous. The jumping dance was incredible to witness in person. Highly recommend!'],
            ['name' => 'David W.', 'tour' => 'Ngorongoro Crater', 'rating' => 5, 'status' => 'Published', 'text' => 'The crater is like another planet. We saw rhinos, lions, and thousands of flamingos in one day. Our guide knew exactly where to go for the best sightings.'],
            ['name' => 'Tom B.', 'tour' => 'Chemka Hot Springs', 'rating' => 4, 'status' => 'Pending', 'text' => 'Beautiful spot, very relaxing day out. Pickup was a little late but the team kept us updated the whole time.'],
            ['name' => 'Priya N.', 'tour' => 'Ngorongoro Crater', 'rating' => 5, 'status' => 'Pending', 'text' => 'Best wildlife day of our trip — saw all of the Big Five before lunch! Guide was incredibly knowledgeable.'],
        ];
        foreach ($reviews as $review) {
            \App\Models\Review::updateOrCreate(
                ['name' => $review['name']],
                ['tour' => $review['tour'], 'rating' => $review['rating'], 'status' => $review['status'], 'text' => $review['text']]
            );
        }

        // Messages
        \App\Models\Message::updateOrCreate(
            ['name' => 'Michael Chen'],
            ['email' => 'michael.chen@email.com', 'subject' => 'Group safari for 8 people', 'body' => 'Hi there, we\'re a group of 8 friends looking to do a 5-day Serengeti and Ngorongoro safari in late August. Could you send a quote and availability? We\'d also like to know if the vehicles have charging ports.', 'read' => false]
        );
        \App\Models\Message::updateOrCreate(
            ['name' => 'Olivia Bennett'],
            ['email' => 'olivia.b@email.com', 'subject' => 'Kilimanjaro day hike question', 'body' => 'Hello, is the Kilimanjaro Day Hike suitable for someone with moderate fitness but no prior hiking experience? Also, what should we pack?', 'read' => false]
        );
        \App\Models\Message::updateOrCreate(
            ['name' => 'Daniel Mwangi'],
            ['email' => 'd.mwangi@email.com', 'subject' => 'Custom honeymoon itinerary', 'body' => 'We\'re celebrating our honeymoon in September and want something special — a mix of a short safari and a relaxing day at Chemka Hot Springs. What would you recommend?', 'read' => true]
        );
        \App\Models\Message::updateOrCreate(
            ['name' => 'Grace Oduya'],
            ['email' => 'grace.oduya@email.com', 'subject' => 'Payment / deposit question', 'body' => 'Hi, I just booked the Materuni Waterfall tour. Can you confirm how the deposit works and whether it\'s refundable if we need to reschedule?', 'read' => true]
        );
        \App\Models\Message::updateOrCreate(
            ['name' => 'Felix Bauer'],
            ['email' => 'felix.bauer@email.com', 'subject' => 'WhatsApp not responding', 'body' => 'I messaged your WhatsApp number twice this week about the Mikumi & Selous Safari and haven\'t heard back. Could someone follow up please?', 'read' => false]
        );
    }
}
