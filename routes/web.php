<?php

use App\Helpers\CurrencyHelper;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMailController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\AdminAuth;
use App\Mail\NewMessageAlert;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Review;
use App\Models\SiteContent;
use App\Support\SafariContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $tours = Destination::where('status', 'Published')->get() ?? [];
    $featuredTours = collect($tours)->take(4);
    $testimonials = Review::where('status', 'Published')->get();
    $gallery = Gallery::take(6)->get() ?? [];
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.home', compact('featuredTours', 'tours', 'testimonials', 'gallery', 'contents'));
})->name('home');

Route::get('/destinations', function () {
    $tours = Destination::where('status', 'Published')->get() ?? [];
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.destinations', compact('tours', 'contents'));
})->name('destinations');

Route::get('/destinations/{slug}', function ($slug) {
    $destinations = Destination::where('status', 'Published')->get();
    $contents = SiteContent::all()->keyBy('key') ?? [];

    $allTours = collect(SafariContent::buildTours($destinations));
    $tourData = $allTours->first(fn ($t) => $t['slug'] === $slug || $t['id'] === $slug);

    if (! $tourData) {
        abort(404);
    }

    $masterDbId = (int) ($tourData['db']['id'] ?? 0);
    $tour = $masterDbId ? ($destinations->firstWhere('id', $masterDbId) ?? null) : null;
    $relatedTours = $allTours
        ->filter(fn ($t) => $t['slug'] !== $tourData['slug'] && $t['id'] !== 'custom-safari')
        ->take(3)
        ->values()
        ->all();

    return view('pages.destination-detail', compact('tour', 'tourData', 'relatedTours', 'contents'));
})->name('destination.detail');

Route::get('/tours', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.tours', [
        'contents' => $contents,
        'eyebrow' => 'OUR TOURS & SAFARIS',
        'pageTitle' => 'TOURS & SAFARIS',
        'heroCopy' => 'Day trips, cultural experiences, Kilimanjaro adventures and multi-day wildlife safaris — complete, transparent itineraries for every traveller.',
        'heroImage' => SafariContent::cld(SafariContent::F['safariSerengeti'], 1920),
        'presetFilter' => null,
        'crumbLabel' => 'Tours',
        'meta_title' => 'Tours & Safaris in Tanzania - Tanzania Daily Tours & Safari',
        'meta_description' => 'Browse all Tanzania tours and safari packages: day trips from Moshi, Kilimanjaro hikes, cultural experiences, Zanzibar escapes and multi-day safaris.',
    ]);
})->name('tours.index');

Route::get('/tours/{category}', function ($category) {
    $map = SafariContent::tourCategories();
    if (! isset($map[$category])) {
        abort(404);
    }
    $c = $map[$category];
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.tours', [
        'contents' => $contents,
        'eyebrow' => $c['eyebrow'],
        'pageTitle' => strtoupper($c['title']),
        'heroCopy' => $c['description'],
        'heroImage' => $c['hero'],
        'presetFilter' => $c['category'],
        'crumbLabel' => $c['title'],
        'meta_title' => $c['meta_title'],
        'meta_description' => $c['meta_description'],
    ]);
})->name('tours.category');

Route::get('/safaris', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.tours', [
        'contents' => $contents,
        'eyebrow' => 'WILDLIFE ADVENTURES',
        'pageTitle' => 'SAFARI PACKAGES',
        'heroCopy' => 'Serengeti, Ngorongoro and Tarangire in one seamless journey — or pick a style below and we\'ll match the itinerary to you.',
        'heroImage' => SafariContent::cld(SafariContent::F['heroSerengeti'], 1920),
        'presetFilter' => 'safari',
        'crumbLabel' => 'Safaris',
        'meta_title' => 'Safari Packages in Tanzania - Tanzania Daily Tours & Safari',
        'meta_description' => 'Tanzania safari packages to Serengeti, Ngorongoro and Tarangire — budget, luxury, private, family and honeymoon options.',
    ]);
})->name('safaris');

Route::get('/safaris/{style}', function ($style) {
    $map = SafariContent::safariStyles();
    if (! isset($map[$style])) {
        abort(404);
    }
    $s = $map[$style];
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.tours', [
        'contents' => $contents,
        'eyebrow' => $s['eyebrow'],
        'pageTitle' => strtoupper($s['title']),
        'heroCopy' => $s['description'],
        'heroImage' => $s['hero'],
        'presetFilter' => 'safari',
        'crumbLabel' => $s['title'],
        'meta_title' => $s['meta_title'],
        'meta_description' => $s['meta_description'],
    ]);
})->name('safaris.style');

Route::get('/travel-guide', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.travel-guide', compact('contents'));
})->name('travel-guide');

Route::get('/about', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.about', compact('contents'));
})->name('about');

Route::get('/reviews', function () {
    $testimonials = Review::where('status', 'Published')->get();
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.reviews', compact('testimonials', 'contents'));
})->name('reviews');

Route::get('/gallery', function () {
    $gallery = Gallery::all() ?? [];
    $galleryData = collect($gallery)->map(function ($item) {
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
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.gallery', compact('gallery', 'galleryData', 'contents'));
})->name('gallery');

Route::get('/contact', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.contact', compact('contents'));
})->name('contact');

Route::get('/terms', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.terms', compact('contents'));
})->name('terms');

Route::get('/privacy', function () {
    $contents = SiteContent::all()->keyBy('key') ?? [];

    return view('pages.privacy', compact('contents'));
})->name('privacy');

Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

// PesaPal payment routes (public)
Route::get('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');
Route::get('/payments/cancelled', [PaymentController::class, 'cancelled'])->name('payments.cancelled');
Route::get('/payments/pay/{reference}', [PaymentController::class, 'resume'])->name('payments.resume');
Route::match(['get', 'post'], '/api/pesapal/ipn', [PaymentController::class, 'ipn'])->name('payments.ipn');

Route::get('/api/currency-rates', function () {
    return response()->json(CurrencyHelper::getRatesWithSymbols());
})->name('api.currency-rates');

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'interest' => 'required|string',
        'message' => 'required|string',
    ]);

    $message = Message::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'subject' => $validated['interest'],
        'body' => $validated['message'],
        'read' => false,
    ]);

    Mail::to(config('mail.from.address'))->queue(new NewMessageAlert($message));

    return back()->with('success', 'Thank you! We will get back to you soon.');
})->name('contact.submit');

// Admin Auth Routes
Route::prefix('live')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'loginSubmit'])->middleware('throttle:5,1')->name('login.submit');
});

// Protected Admin Routes
Route::prefix('live')->name('admin.')->middleware(AdminAuth::class)->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Bookings
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::post('/bookings', [AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::put('/bookings/{id}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::delete('/bookings/{id}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');
    Route::post('/bookings/{id}/payment-link', [AdminPaymentController::class, 'resendPaymentLink'])->name('bookings.payment-link');
    Route::post('/bookings/{id}/payment-link/copy', [AdminPaymentController::class, 'copyPaymentLink'])->name('bookings.payment-link.copy');

    // Payments
    Route::get('/payments/settings', [AdminPaymentController::class, 'settings'])->name('payments.settings');
    Route::put('/payments/settings', [AdminPaymentController::class, 'updateSettings'])->name('payments.settings.update');
    Route::post('/payments/settings/test', [AdminPaymentController::class, 'testConnection'])->name('payments.settings.test');
    Route::post('/payments/settings/ipn', [AdminPaymentController::class, 'registerIpn'])->name('payments.settings.ipn');
    Route::match(['GET', 'POST'], '/payments/settings/ipns', [AdminPaymentController::class, 'ipnList'])->name('payments.settings.ipns');
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments');
    Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{id}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
    Route::post('/payments/{id}/status', [AdminPaymentController::class, 'markStatus'])->name('payments.status');

    // Destinations
    Route::get('/destinations', [AdminController::class, 'destinations'])->name('destinations');
    Route::post('/destinations', [AdminController::class, 'storeDestination'])->name('destinations.store');
    Route::get('/destinations/{id}/edit', [AdminController::class, 'destinationEdit'])->name('destinations.edit');
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

    // Site Content
    Route::get('/content', [AdminController::class, 'content'])->name('content');
    Route::put('/content', [AdminController::class, 'contentUpdate'])->name('content.update');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // Mail Settings
    Route::put('/settings/mail', [AdminMailController::class, 'updateSettings'])->name('settings.mail.update');
    Route::post('/settings/mail/test', [AdminMailController::class, 'sendTest'])->name('settings.mail.test');

    // Admin Users
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}', [AdminController::class, 'userDetail'])->name('users.show');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::post('/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');
    Route::post('/users/{id}/reset-password', [AdminController::class, 'resetPassword'])->name('users.reset-password');

    // Forced / self password change
    Route::get('/change-password', [AdminController::class, 'changePasswordPage'])->name('change-password');
    Route::post('/change-password', [AdminController::class, 'submitChangePassword'])->name('change-password.submit');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');

    Route::post('/currency-switch', [AdminController::class, 'currencySwitch'])->name('currency.switch');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
