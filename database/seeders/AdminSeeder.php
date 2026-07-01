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
            ['category' => 'Day Trip', 'duration' => 'Full day', 'price' => 80, 'status' => 'Published', 'image' => 'https://tanzaniadailytoursandsafari.com/images/tour-materuni.jpg', 'desc' => 'Hike through lush forests to a stunning waterfall, then experience traditional coffee making.']
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Chemka Hot Springs'],
            ['category' => 'Day Trip', 'duration' => 'Full day', 'price' => 90, 'status' => 'Published', 'image' => 'https://tanzaniadailytoursandsafari.com/images/tour-chemka.jpg', 'desc' => 'Crystal-clear natural hot springs surrounded by jungle. Swim, swing, and relax.']
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Marangu Cultural Tour'],
            ['category' => 'Day Trip', 'duration' => 'Full day', 'price' => 70, 'status' => 'Published', 'image' => 'https://tanzaniadailytoursandsafari.com/images/tour-maasai.jpg', 'desc' => 'Visit the historic Chagga tribe caves, waterfalls, and learn about local culture.']
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Kilimanjaro Day Hike'],
            ['category' => 'Day Trip', 'duration' => 'Full day', 'price' => 250, 'status' => 'Published', 'image' => 'https://tanzaniadailytoursandsafari.com/images/tour-arusha.jpg', 'desc' => 'Trek through Kilimanjaro\'s rainforest zone to Mandara Hut.']
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Serengeti Safari'],
            ['category' => 'Multi-Day Safari', 'duration' => '3-5 Days', 'price' => 800, 'status' => 'Published', 'image' => 'https://tanzaniadailytoursandsafari.com/images/gallery-landscape-1.jpg', 'desc' => '3-5 days of unparalleled wildlife viewing in the world\'s most famous savanna.']
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Ngorongoro Crater'],
            ['category' => 'Multi-Day Safari', 'duration' => '2-3 Days', 'price' => 600, 'status' => 'Published', 'image' => 'https://tanzaniadailytoursandsafari.com/images/gallery-landscape-2.jpg', 'desc' => 'Descend into the world\'s largest inactive volcanic caldera teeming with wildlife.']
        );
        \App\Models\Destination::updateOrCreate(
            ['name' => 'Mikumi & Selous Safari'],
            ['category' => 'Multi-Day Safari', 'duration' => '3-4 Days', 'price' => 700, 'status' => 'Draft', 'image' => 'https://tanzaniadailytoursandsafari.com/images/gallery-wildlife-2.jpg', 'desc' => 'Explore southern Tanzania\'s hidden gems with fewer crowds.']
        );

        // Gallery
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/gallery-wildlife-1.jpg'],
            ['caption' => 'Lion Portrait', 'category' => 'Wildlife']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/gallery-wildlife-2.jpg'],
            ['caption' => 'Elephant Family at Sunset', 'category' => 'Wildlife']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/gallery-landscape-1.jpg'],
            ['caption' => 'Serengeti Dawn', 'category' => 'Landscape']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/gallery-landscape-2.jpg'],
            ['caption' => 'Ngorongoro Aerial', 'category' => 'Landscape']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/gallery-people-1.jpg'],
            ['caption' => 'Safari Excitement', 'category' => 'People']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/gallery-culture-1.jpg'],
            ['caption' => 'Maasai Village', 'category' => 'Culture']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/tour-materuni.jpg'],
            ['caption' => 'Materuni Waterfall', 'category' => 'Tours']
        );
        \App\Models\Gallery::updateOrCreate(
            ['url' => 'https://tanzaniadailytoursandsafari.com/images/tour-chemka.jpg'],
            ['caption' => 'Chemka Hot Springs', 'category' => 'Tours']
        );

        // Reviews
        \App\Models\Review::updateOrCreate(
            ['name' => 'Sarah M.'],
            ['tour' => 'Serengeti Safari', 'rating' => 5, 'status' => 'Published', 'text' => 'An absolutely magical experience. Our guide spotted a leopard in a tree within the first hour! The accommodations were perfect and every meal was delicious.']
        );
        \App\Models\Review::updateOrCreate(
            ['name' => 'James K.'],
            ['tour' => 'Family Safari', 'rating' => 5, 'status' => 'Published', 'text' => 'We took our entire family including our 8-year-old. The team was so accommodating and patient. The kids still talk about the elephants every day.']
        );
        \App\Models\Review::updateOrCreate(
            ['name' => 'Elena R.'],
            ['tour' => 'Kilimanjaro Trek', 'rating' => 5, 'status' => 'Published', 'text' => 'Climbing Kilimanjaro was a life-changing experience. The porters and guides were incredibly supportive. I couldn\'t have done it without their encouragement.']
        );
        \App\Models\Review::updateOrCreate(
            ['name' => 'Tom B.'],
            ['tour' => 'Chemka Hot Springs', 'rating' => 4, 'status' => 'Pending', 'text' => 'Beautiful spot, very relaxing day out. Pickup was a little late but the team kept us updated the whole time.']
        );
        \App\Models\Review::updateOrCreate(
            ['name' => 'Priya N.'],
            ['tour' => 'Ngorongoro Crater', 'rating' => 5, 'status' => 'Pending', 'text' => 'Best wildlife day of our trip — saw all of the Big Five before lunch! Guide was incredibly knowledgeable.']
        );

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
