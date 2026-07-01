<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    $tours = App\Models\Destination::where('status', 'Published')->get();
    $featuredTours = $tours->take(4);
    $testimonials = App\Helpers\TourData::testimonials();
    $gallery = App\Models\Gallery::take(6)->get() ?? [];
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.home', compact('featuredTours', 'tours', 'testimonials', 'gallery', 'contents'));
})->name('home');

Route::get('/destinations', function () {
    $tours = App\Models\Destination::where('status', 'Published')->get();
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.destinations', compact('tours', 'contents'));
})->name('destinations');

Route::get('/destinations/{slug}', function ($slug) {
    $tour = App\Models\Destination::where('name', ucwords(str_replace('-', ' ', $slug)))->where('status', 'Published')->first();
    if (!$tour) {
        $tour = App\Models\Destination::where('status', 'Published')->first();
        if (!$tour) abort(404);
    }
    $tours = App\Models\Destination::where('status', 'Published')->get();
    $relatedTours = $tours->filter(function($t) use ($tour) {
        return $t->category === $tour->category && $t->id !== $tour->id;
    });
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.destination-detail', compact('tour', 'relatedTours', 'contents'));
})->name('destination.detail');

Route::get('/about', function () {
    $team = App\Helpers\TourData::team();
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.about', compact('team', 'contents'));
})->name('about');

Route::get('/reviews', function () {
    $testimonials = App\Helpers\TourData::testimonials();
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.reviews', compact('testimonials', 'contents'));
})->name('reviews');

Route::get('/gallery', function () {
    $gallery = App\Models\Gallery::all();
    $galleryData = collect($gallery)->map(function($item) {
        $src = '';
        $title = '';
        $category = '';
        if (is_object($item)) {
            $src = $item->url ?? '';
            $title = $item->caption ?? '';
            $category = $item->category ?? '';
        } elseif (is_array($item)) {
            $src = $item['url'] ?? ($item[0] ?? '');
            $title = $item['caption'] ?? ($item[1] ?? '');
            $category = $item['category'] ?? ($item[2] ?? '');
        }
        return [
            'src' => $src,
            'title' => $title,
            'category' => $category,
        ];
    });
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.gallery', compact('gallery', 'galleryData', 'contents'));
})->name('gallery');

Route::get('/contact', function () {
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.contact', compact('contents'));
})->name('contact');

Route::get('/terms', function () {
    $contents = App\Models\SiteContent::all()->keyBy('key');
    return view('pages.terms', compact('contents'));
})->name('terms');

Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::post('/contact', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'interest' => 'required|string',
        'message' => 'required|string',
    ]);

    App\Models\Message::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'subject' => $validated['interest'],
        'body' => $validated['message'],
        'read' => false,
    ]);

    return back()->with('success', 'Thank you! We will get back to you soon.');
})->name('contact.submit');

// Admin Auth Routes
Route::prefix('live')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->name('login.submit');
});

// Protected Admin Routes
Route::prefix('live')->name('admin.')->middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Bookings
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::post('/bookings', [AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::put('/bookings/{id}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::delete('/bookings/{id}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');
    
    // Destinations
    Route::get('/destinations', [AdminController::class, 'destinations'])->name('destinations');
    Route::post('/destinations', [AdminController::class, 'storeDestination'])->name('destinations.store');
    Route::put('/destinations/{id}', [AdminController::class, 'updateDestination'])->name('destinations.update');
    Route::delete('/destinations/{id}', [AdminController::class, 'destroyDestination'])->name('destinations.destroy');
    
    // Gallery
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
    Route::post('/gallery', [AdminController::class, 'storeGallery'])->name('gallery.store');
    Route::delete('/gallery/{id}', [AdminController::class, 'destroyGallery'])->name('gallery.destroy');
    
    // Reviews
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::put('/reviews/{id}/{status}', [AdminController::class, 'updateReviewStatus'])->name('reviews.update');
    Route::delete('/reviews/{id}', [AdminController::class, 'destroyReview'])->name('reviews.destroy');
    
    // Messages
    Route::get('/messages', [AdminController::class, 'messages'])->name('messages');
    Route::put('/messages/{id}/read', [AdminController::class, 'markMessageRead'])->name('messages.read');
    Route::delete('/messages/{id}', [AdminController::class, 'destroyMessage'])->name('messages.destroy');
    
    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Admin Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});
