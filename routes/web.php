<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tours = App\Helpers\TourData::tours();
    $featuredTours = array_filter($tours, function($tour) { return $tour['featured'] ?? false; });
    $testimonials = App\Helpers\TourData::testimonials();
    $gallery = array_slice(App\Helpers\TourData::gallery(), 0, 6);
    return view('pages.home', compact('featuredTours', 'tours', 'testimonials', 'gallery'));
})->name('home');

Route::get('/destinations', function () {
    $tours = App\Helpers\TourData::tours();
    return view('pages.destinations', compact('tours'));
})->name('destinations');

Route::get('/destinations/{slug}', function ($slug) {
    $tour = App\Helpers\TourData::getTourBySlug($slug);
    if (!$tour) {
        abort(404);
    }
    $tours = App\Helpers\TourData::tours();
    $relatedTours = array_filter($tours, function($t) use ($tour) {
        return $t['category'] === $tour['category'] && $t['id'] !== $tour['id'];
    });
    return view('pages.destination-detail', compact('tour', 'relatedTours'));
})->name('destination.detail');

Route::get('/about', function () {
    $team = App\Helpers\TourData::team();
    return view('pages.about', compact('team'));
})->name('about');

Route::get('/reviews', function () {
    $testimonials = App\Helpers\TourData::testimonials();
    return view('pages.reviews', compact('testimonials'));
})->name('reviews');

Route::get('/gallery', function () {
    $gallery = App\Helpers\TourData::gallery();
    return view('pages.gallery', compact('gallery'));
})->name('gallery');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');
