<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        // General Content
        SiteContent::updateOrCreate(
            ['key' => 'site_title'],
            ['label' => 'Site Title', 'type' => 'text', 'group' => 'general', 'value' => 'TDTS - Tanzania Wild']
        );

        SiteContent::updateOrCreate(
            ['key' => 'site_tagline'],
            ['label' => 'Site Tagline', 'type' => 'text', 'group' => 'general', 'value' => 'Discover Tanzania\'s Wilderness']
        );

        // Home Page Content
        SiteContent::updateOrCreate(
            ['key' => 'home_hero_title'],
            ['label' => 'Hero Title', 'type' => 'text', 'group' => 'home', 'value' => 'Experience the Wild']
        );

        SiteContent::updateOrCreate(
            ['key' => 'home_hero_subtitle'],
            ['label' => 'Hero Subtitle', 'type' => 'text', 'group' => 'home', 'value' => 'We offer a variety of safari packages to suit every budget and interest, from luxury lodges to budget camping trips.']
        );

        SiteContent::updateOrCreate(
            ['key' => 'popular_tours_title'],
            ['label' => 'Popular Tours Title', 'type' => 'text', 'group' => 'home', 'value' => 'Day Trip Adventures']
        );

        SiteContent::updateOrCreate(
            ['key' => 'why_choose_us_title'],
            ['label' => 'Why Choose Us Title', 'type' => 'text', 'group' => 'home', 'value' => 'Your Trusted Safari Partner']
        );

        SiteContent::updateOrCreate(
            ['key' => 'why_choose_us_subtitle'],
            ['label' => 'Why Choose Us Subtitle', 'type' => 'text', 'group' => 'home', 'value' => 'With over a decade of experience, we craft safari experiences that go beyond the ordinary.']
        );

        SiteContent::updateOrCreate(
            ['key' => 'testimonials_title'],
            ['label' => 'Testimonials Title', 'type' => 'text', 'group' => 'home', 'value' => 'What Our Travelers Say']
        );

        SiteContent::updateOrCreate(
            ['key' => 'testimonials_subtitle'],
            ['label' => 'Testimonials Subtitle', 'type' => 'text', 'group' => 'home', 'value' => 'Real experiences from real adventurers']
        );

        // About Page Content
        SiteContent::updateOrCreate(
            ['key' => 'about_title'],
            ['label' => 'About Page Title', 'type' => 'text', 'group' => 'about', 'value' => 'About Us']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_description'],
            ['label' => 'About Page Description', 'type' => 'html', 'group' => 'about', 'value' => 'Your adventure begins here with TDTS.']
        );

        // Settings - General
        SiteContent::updateOrCreate(
            ['key' => 'default_currency'],
            ['label' => 'Default Currency', 'type' => 'select', 'group' => 'general', 'value' => 'USD ($)']
        );

        SiteContent::updateOrCreate(
            ['key' => 'timezone'],
            ['label' => 'Timezone', 'type' => 'select', 'group' => 'general', 'value' => 'Africa/Dar es Salaam (EAT)']
        );

        // Settings - Brand
        SiteContent::updateOrCreate(
            ['key' => 'logo_brown'],
            ['label' => 'Logo (Brown)', 'type' => 'image', 'group' => 'brand', 'value' => '/images/safari-logo-brown.png']
        );

        SiteContent::updateOrCreate(
            ['key' => 'logo_white'],
            ['label' => 'Logo (White)', 'type' => 'image', 'group' => 'brand', 'value' => '/images/safari-logo-white.png']
        );

        // Settings - Contact
        SiteContent::updateOrCreate(
            ['key' => 'contact_phone'],
            ['label' => 'Phone Number', 'type' => 'text', 'group' => 'contact', 'value' => '+255 123 456 789']
        );

        SiteContent::updateOrCreate(
            ['key' => 'contact_whatsapp'],
            ['label' => 'WhatsApp Number', 'type' => 'text', 'group' => 'contact', 'value' => '+255 123 456 789']
        );

        SiteContent::updateOrCreate(
            ['key' => 'contact_email'],
            ['label' => 'Email Address', 'type' => 'email', 'group' => 'contact', 'value' => 'info@tanzaniadailytours.com']
        );

        SiteContent::updateOrCreate(
            ['key' => 'contact_location'],
            ['label' => 'Location', 'type' => 'text', 'group' => 'contact', 'value' => 'Arusha, Tanzania']
        );

        SiteContent::updateOrCreate(
            ['key' => 'social_instagram'],
            ['label' => 'Instagram URL', 'type' => 'text', 'group' => 'contact', 'value' => 'https://instagram.com/tanzaniadailytours']
        );

        // Settings - Notifications
        SiteContent::updateOrCreate(
            ['key' => 'notify_new_booking'],
            ['label' => 'New Booking Alerts', 'type' => 'toggle', 'group' => 'notifications', 'value' => '1']
        );

        SiteContent::updateOrCreate(
            ['key' => 'notify_new_message'],
            ['label' => 'New Message Alerts', 'type' => 'toggle', 'group' => 'notifications', 'value' => '1']
        );

        SiteContent::updateOrCreate(
            ['key' => 'review_moderation'],
            ['label' => 'Review Moderation', 'type' => 'toggle', 'group' => 'notifications', 'value' => '1']
        );

        SiteContent::updateOrCreate(
            ['key' => 'weekly_summary'],
            ['label' => 'Weekly Summary', 'type' => 'toggle', 'group' => 'notifications', 'value' => '0']
        );

        // Home Page - Hero
        SiteContent::updateOrCreate(
            ['key' => 'hero_tagline'],
            ['label' => 'Hero Tagline', 'type' => 'text', 'group' => 'home', 'value' => "Discover Tanzania's Wilderness"]
        );

        SiteContent::updateOrCreate(
            ['key' => 'hero_subtitle'],
            ['label' => 'Hero Subtitle', 'type' => 'textarea', 'group' => 'home', 'value' => 'We offer a variety of safari packages to suit every budget and interest, from luxury lodges to budget camping trips.']
        );

        // Home Page - Popular Tours
        SiteContent::updateOrCreate(
            ['key' => 'popular_tours_label'],
            ['label' => 'Popular Tours Label', 'type' => 'text', 'group' => 'home', 'value' => 'Popular Destinations']
        );

        SiteContent::updateOrCreate(
            ['key' => 'popular_tours_title'],
            ['label' => 'Popular Tours Title', 'type' => 'text', 'group' => 'home', 'value' => 'Day Trip Adventures']
        );

        SiteContent::updateOrCreate(
            ['key' => 'popular_tours_subtitle'],
            ['label' => 'Popular Tours Subtitle', 'type' => 'textarea', 'group' => 'home', 'value' => 'Explore Tanzania\'s most beloved natural wonders in a single day']
        );

        // Home Page - Multi-Day
        SiteContent::updateOrCreate(
            ['key' => 'multi_day_label'],
            ['label' => 'Multi-Day Label', 'type' => 'text', 'group' => 'home', 'value' => 'Extended Adventures']
        );

        SiteContent::updateOrCreate(
            ['key' => 'multi_day_title'],
            ['label' => 'Multi-Day Title', 'type' => 'text', 'group' => 'home', 'value' => 'Multi-Day Safari Packages']
        );

        SiteContent::updateOrCreate(
            ['key' => 'multi_day_description'],
            ['label' => 'Multi-Day Description', 'type' => 'textarea', 'group' => 'home', 'value' => 'Immerse yourself in Tanzania\'s wilderness with our carefully crafted multi-day itineraries. Witness the Great Migration, explore the Ngorongoro Crater, and sleep under the African stars.']
        );

        // Home Page - Why Choose Us
        SiteContent::updateOrCreate(
            ['key' => 'why_choose_label'],
            ['label' => 'Why Choose Label', 'type' => 'text', 'group' => 'home', 'value' => 'Why Travel With Us']
        );

        SiteContent::updateOrCreate(
            ['key' => 'why_choose_title'],
            ['label' => 'Why Choose Title', 'type' => 'text', 'group' => 'home', 'value' => 'Your Trusted Safari Partner']
        );

        SiteContent::updateOrCreate(
            ['key' => 'why_choose_description'],
            ['label' => 'Why Choose Description', 'type' => 'textarea', 'group' => 'home', 'value' => 'With over a decade of experience, we craft safari experiences that go beyond the ordinary. Our expert guides, comfortable 4x4 vehicles, and deep local knowledge ensure every moment is unforgettable.']
        );

        // Home Page - Testimonials
        SiteContent::updateOrCreate(
            ['key' => 'testimonials_label'],
            ['label' => 'Testimonials Label', 'type' => 'text', 'group' => 'home', 'value' => 'Testimonials']
        );

        SiteContent::updateOrCreate(
            ['key' => 'testimonials_title'],
            ['label' => 'Testimonials Title', 'type' => 'text', 'group' => 'home', 'value' => 'What Our Travelers Say']
        );

        SiteContent::updateOrCreate(
            ['key' => 'testimonials_subtitle'],
            ['label' => 'Testimonials Subtitle', 'type' => 'text', 'group' => 'home', 'value' => 'Real experiences from real adventurers']
        );

        // Home Page - Gallery
        SiteContent::updateOrCreate(
            ['key' => 'gallery_label'],
            ['label' => 'Gallery Label', 'type' => 'text', 'group' => 'home', 'value' => 'Photo Gallery']
        );

        SiteContent::updateOrCreate(
            ['key' => 'gallery_title'],
            ['label' => 'Gallery Title', 'type' => 'text', 'group' => 'home', 'value' => 'Moments from the Wild']
        );

        // Home Page - CTA
        SiteContent::updateOrCreate(
            ['key' => 'cta_title'],
            ['label' => 'CTA Title', 'type' => 'text', 'group' => 'home', 'value' => 'Ready for Your African Adventure?']
        );

        SiteContent::updateOrCreate(
            ['key' => 'cta_description'],
            ['label' => 'CTA Description', 'type' => 'textarea', 'group' => 'home', 'value' => 'Let our experts craft the perfect safari itinerary for you. From day trips to multi-week expeditions, we make your dream trip a reality.']
        );

        // About Page
        SiteContent::updateOrCreate(
            ['key' => 'about_page_title'],
            ['label' => 'About Page Title', 'type' => 'text', 'group' => 'about', 'value' => 'About Tanzania Daily Tours']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_story_label'],
            ['label' => 'About Story Label', 'type' => 'text', 'group' => 'about', 'value' => 'Our Story']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_story_title'],
            ['label' => 'About Story Title', 'type' => 'text', 'group' => 'about', 'value' => 'Passionate About Tanzania\'s Natural Heritage']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_story_text'],
            ['label' => 'About Story Text', 'type' => 'html', 'group' => 'about', 'value' => '<p>Founded by local guides with deep knowledge of Tanzania\'s parks and cultures, Tanzania Daily Tours was born from a love of sharing our incredible homeland with visitors from around the world.</p><p>What started as a small team of passionate safari guides has grown into one of the most trusted tour operators in the region. We\'ve spent over a decade crafting unforgettable experiences, from Kilimanjaro\'s summit to the Serengeti\'s endless plains.</p><p>Our mission is simple: to show you the real Tanzania. Not just the postcard views, but the warmth of our people, the depth of our cultures, and the raw beauty of our wilderness.</p>']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_values_label'],
            ['label' => 'About Values Label', 'type' => 'text', 'group' => 'about', 'value' => 'Our Values']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_values_title'],
            ['label' => 'About Values Title', 'type' => 'text', 'group' => 'about', 'value' => 'What Drives Us']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_team_label'],
            ['label' => 'About Team Label', 'type' => 'text', 'group' => 'about', 'value' => 'Our Team']
        );

        SiteContent::updateOrCreate(
            ['key' => 'about_team_title'],
            ['label' => 'About Team Title', 'type' => 'text', 'group' => 'about', 'value' => 'Meet the Experts']
        );

        // Contact Page
        SiteContent::updateOrCreate(
            ['key' => 'contact_page_title'],
            ['label' => 'Contact Page Title', 'type' => 'text', 'group' => 'contact', 'value' => 'Get in Touch']
        );

        SiteContent::updateOrCreate(
            ['key' => 'contact_subtitle'],
            ['label' => 'Contact Subtitle', 'type' => 'text', 'group' => 'contact', 'value' => 'Plan Your Perfect Safari']
        );

        SiteContent::updateOrCreate(
            ['key' => 'contact_description'],
            ['label' => 'Contact Description', 'type' => 'textarea', 'group' => 'contact', 'value' => 'Ready to start your adventure? Send us a message and we\'ll get back to you within 24 hours to help plan your personalized Tanzanian experience.']
        );

        // Destinations Page
        SiteContent::updateOrCreate(
            ['key' => 'destinations_page_title'],
            ['label' => 'Destinations Page Title', 'type' => 'text', 'group' => 'destinations', 'value' => 'Our Destinations']
        );

        SiteContent::updateOrCreate(
            ['key' => 'destinations_cta_text'],
            ['label' => 'Destinations CTA Text', 'type' => 'textarea', 'group' => 'destinations', 'value' => 'Can\'t find what you\'re looking for? We create custom itineraries!']
        );

        SiteContent::updateOrCreate(
            ['key' => 'destinations_cta_button'],
            ['label' => 'Destinations CTA Button', 'type' => 'text', 'group' => 'destinations', 'value' => 'Plan a Custom Trip']
        );

        // Gallery Page
        SiteContent::updateOrCreate(
            ['key' => 'gallery_page_title'],
            ['label' => 'Gallery Page Title', 'type' => 'text', 'group' => 'gallery', 'value' => 'Photo Gallery']
        );

        // Reviews Page
        SiteContent::updateOrCreate(
            ['key' => 'reviews_page_title'],
            ['label' => 'Reviews Page Title', 'type' => 'text', 'group' => 'reviews', 'value' => 'Traveler Reviews']
        );

        SiteContent::updateOrCreate(
            ['key' => 'reviews_cta_text'],
            ['label' => 'Reviews CTA Text', 'type' => 'text', 'group' => 'reviews', 'value' => 'Traveled with us? Share your experience!']
        );

        SiteContent::updateOrCreate(
            ['key' => 'reviews_cta_button'],
            ['label' => 'Reviews CTA Button', 'type' => 'text', 'group' => 'reviews', 'value' => 'Write a Review']
        );

        // Destination Detail Page
        SiteContent::updateOrCreate(
            ['key' => 'destination_back_text'],
            ['label' => 'Destination Back Text', 'type' => 'text', 'group' => 'destination', 'value' => 'Back to Destinations']
        );

        SiteContent::updateOrCreate(
            ['key' => 'destination_about_title'],
            ['label' => 'Destination About Title', 'type' => 'text', 'group' => 'destination', 'value' => 'About This Tour']
        );

        SiteContent::updateOrCreate(
            ['key' => 'destination_includes_title'],
            ['label' => 'Destination Includes Title', 'type' => 'text', 'group' => 'destination', 'value' => 'What\'s Included']
        );

        SiteContent::updateOrCreate(
            ['key' => 'destination_related_title'],
            ['label' => 'Destination Related Title', 'type' => 'text', 'group' => 'destination', 'value' => 'You May Also Like']
        );

        // Terms Page
        SiteContent::updateOrCreate(
            ['key' => 'terms_page_title'],
            ['label' => 'Terms Page Title', 'type' => 'text', 'group' => 'terms', 'value' => 'Terms and Conditions']
        );

        SiteContent::updateOrCreate(
            ['key' => 'terms_company_name'],
            ['label' => 'Terms Company Name', 'type' => 'text', 'group' => 'terms', 'value' => 'Tanzania Daily Tours & Safaris']
        );

        SiteContent::updateOrCreate(
            ['key' => 'terms_company_address'],
            ['label' => 'Terms Company Address', 'type' => 'textarea', 'group' => 'terms', 'value' => 'Wakala wa Vipimo Building,\nMoshi, Kilimanjaro,\nUnited Republic of Tanzania']
        );

        SiteContent::updateOrCreate(
            ['key' => 'terms_effective_date'],
            ['label' => 'Terms Effective Date', 'type' => 'text', 'group' => 'terms', 'value' => 'June 2026']
        );
    }
}
