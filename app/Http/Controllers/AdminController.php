<?php

namespace App\Http\Controllers;

use App\Helpers\CurrencyHelper;
use App\Models\AdminLoginLog;
use App\Models\AdminUser;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Review;
use App\Models\SiteContent;
use App\Services\AdminAudit;
use App\Services\MailSettings;
use App\Services\PaymentSettings;
use App\Services\PesaPalService;
use App\Support\SafariContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function login()
    {
        if (session()->has('admin_logged_in') && session()->has('admin_user_id')) {
            return redirect()->route('admin.dashboard');
        }
        // Clear old session data to prevent redirect loops
        session()->forget('admin_logged_in');
        session()->forget('admin_user_id');

        return view('admin.login');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = AdminUser::where('email', $credentials['email'])->first();

        $loggedIn = $admin && $admin->checkPassword($credentials['password']) && $admin->is_active;

        AdminLoginLog::create([
            'admin_user_id' => $admin?->id,
            'email' => $credentials['email'],
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
            'success' => $loggedIn,
        ]);

        if ($loggedIn) {
            $admin->update(['last_login_at' => now()]);
            session([
                'admin_logged_in' => true,
                'admin_user_id' => $admin->id,
                'admin_role' => $admin->role,
                'admin_last_activity' => time(),
            ]);

            if ($admin->must_change_password) {
                return redirect()->route('admin.change-password')
                    ->with('success', 'Welcome! For security, set a new password to continue.');
            }

            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_logged_in', 'admin_user_id', 'admin_role']);

        return redirect()->route('admin.login');
    }

    public function currencySwitch(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|in:USD,EUR,GBP,JPY,CAD,AUD,INR,TZS,KES,UGX,ZAR',
        ]);
        session(['admin_currency' => $validated['currency']]);

        return response()->json(['success' => true, 'currency' => $validated['currency']]);
    }

    public function dashboard()
    {
        $totalBookings = Booking::count();
        $thisMonthBookings = Booking::whereYear('created_at', '>=', now()->startOfMonth())->count();

        // Calculate total revenue in USD by converting each booking's amount to USD
        $totalRevenue = 0;
        foreach (Booking::all() as $booking) {
            $amount = $booking->amount ?? $booking->total_price ?? 0;
            $currency = $booking->currency ?? 'USD';
            $totalRevenue += CurrencyHelper::convert($amount, $currency, 'USD');
        }

        $recentBookings = Booking::latest()->take(5)->get();
        $activeDestinations = Destination::where('status', 'Published')->count();
        $unreadMessages = Message::where('read', false)->count();
        $pendingReviews = Review::where('status', 'Pending')->count();

        $collectedPayments = Payment::where('status', Payment::STATUS_COMPLETED)->sum('amount');
        $pendingPayments = Payment::whereIn('status', [Payment::STATUS_PENDING, Payment::STATUS_PROCESSING])->sum('amount');
        $pendingPaymentCount = Payment::whereIn('status', [Payment::STATUS_PENDING, Payment::STATUS_PROCESSING])->count();
        $recentPayments = Payment::with('booking')->latest()->take(5)->get();

        $dayTripCount = Booking::whereHas('destination', function ($q) {
            $q->where('category', 'Day Trip');
        })->count();
        $multiDayCount = Booking::whereHas('destination', function ($q) {
            $q->where('category', 'Multi-Day Safari');
        })->count();

        return view('admin.dashboard', [
            'totalBookings' => $totalBookings,
            'thisMonthBookings' => $thisMonthBookings,
            'totalRevenue' => $totalRevenue,
            'recentBookings' => $recentBookings,
            'activeDestinations' => $activeDestinations,
            'unreadMessages' => $unreadMessages,
            'pendingReviews' => $pendingReviews,
            'dayTripCount' => $dayTripCount,
            'multiDayCount' => $multiDayCount,
            'collectedPayments' => $collectedPayments,
            'pendingPayments' => $pendingPayments,
            'pendingPaymentCount' => $pendingPaymentCount,
            'recentPayments' => $recentPayments,
            'paymentCurrency' => PaymentSettings::currency(),
            'destCount' => Destination::count(),
            'reviewCount' => $pendingReviews,
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => $unreadMessages,
        ]);
    }

    public function bookings()
    {
        $bookings = Booking::latest()->paginate(10);
        $destinations = Destination::all();

        return view('admin.bookings', [
            'bookings' => $bookings,
            'destinations' => $destinations,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'tour_name' => 'required|string',
            'destination_id' => 'nullable|integer|exists:destinations,id',
            'travel_date' => 'required|date',
            'guests' => 'required|integer|min:1',
            'status' => 'required|string',
        ]);

        $amount = 0;
        if (! empty($validated['destination_id'])) {
            $destination = Destination::find($validated['destination_id']);
            if ($destination) {
                $amount = ($destination->price_adult ?? $destination->price ?? 0) * $validated['guests'];
            }
        }

        Booking::create([...$validated, 'amount' => $amount]);

        return back()->with('success', 'Booking saved!');
    }

    public function updateBooking(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'country_code' => 'required|string',
            'phone_number' => 'required|string',
            'tour_name' => 'required|string',
            'destination_id' => 'nullable|integer|exists:destinations,id',
            'travel_date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);

        $guests = $validated['adults'] + ($validated['children'] ?? 0);
        $amount = 0;
        $destinationId = $validated['destination_id'] ?? $booking->destination_id;
        if ($destinationId) {
            $destination = Destination::find($destinationId);
            if ($destination) {
                $adultPrice = $destination->price_adult ?? $destination->price ?? 0;
                $childPrice = $destination->price_child ?? ($adultPrice / 2);
                $amount = ($adultPrice * $validated['adults']) + ($childPrice * ($validated['children'] ?? 0));
            }
        }

        $booking->update([...$validated, 'amount' => $amount, 'guests' => $guests]);

        return redirect()->route('admin.bookings')->with('success', 'Booking updated successfully!');
    }

    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return back()->with('success', 'Booking deleted successfully.');
    }

    public function destinations()
    {
        $destinations = Destination::latest()->paginate(10);

        return view('admin.destinations', [
            'destinations' => $destinations,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function destinationEdit($id)
    {
        $dest = Destination::findOrFail($id);

        $allTours = collect(SafariContent::buildTours(Destination::where('status', 'Published')->get()));
        $merged = $allTours->first(fn ($t) => $t['slug'] === $dest->slug
            || (isset($t['db']['id']) && (int) $t['db']['id'] === (int) $dest->id));

        $currentAdmin = session('admin_user_id') ? AdminUser::find(session('admin_user_id')) : null;

        return view('admin.destination-edit', $this->layoutData([
            'dest' => $dest,
            'merged' => $merged,
            'listingCategories' => SafariContent::LISTING_CATEGORIES,
            'currentAdmin' => $currentAdmin,
        ]));
    }

    public function storeDestination(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'duration' => 'required|string',
            'location' => 'nullable|string',
            'price_adult' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'price_child' => 'nullable|numeric',
            'rating' => 'nullable|numeric|between:0,5',
            'image' => 'nullable|url',
            'desc' => 'nullable|string',
            'long_description' => 'nullable|string',
            'quick_facts' => 'nullable|array',
            'quick_facts.*.label' => 'nullable|string',
            'quick_facts.*.value' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*.icon' => 'nullable|string',
            'highlights.*.text' => 'nullable|string',
            'itinerary' => 'nullable|array',
            'itinerary.*.label' => 'nullable|string',
            'itinerary.*.title' => 'nullable|string',
            'itinerary.*.desc' => 'nullable|string',
            'itinerary.*.activities' => 'nullable|string',
            'itinerary.*.meals' => 'nullable|string',
            'itinerary.*.accommodation' => 'nullable|string',
            'includes' => 'nullable|array',
            'includes.*' => 'nullable|string',
            'excluded' => 'nullable|array',
            'excluded.*' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.q' => 'nullable|string',
            'faqs.*.a' => 'nullable|string',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Handle price fields: if price_adult not set, use price; set price from price_adult
        if (empty($validated['price_adult']) && ! empty($validated['price'])) {
            $validated['price_adult'] = $validated['price'];
        }
        if (empty($validated['price']) && ! empty($validated['price_adult'])) {
            $validated['price'] = $validated['price_adult'];
        }

        // Empty rating → null; JSON repeaters normalized (blank rows dropped).
        if (array_key_exists('rating', $validated)) {
            $validated['rating'] = $validated['rating'] === '' || $validated['rating'] === null ? null : $validated['rating'];
        }

        $listFields = ['includes', 'excluded', 'gallery'];
        foreach ($listFields as $field) {
            if (array_key_exists($field, $validated)) {
                $validated[$field] = $this->normalizeListField($validated[$field]);
            }
        }

        $rowFields = [
            'highlights' => ['icon', 'text'],
            'itinerary' => ['label', 'title', 'desc', 'activities', 'meals', 'accommodation'],
            'quick_facts' => ['label', 'value'],
        ];
        foreach ($rowFields as $field => $keys) {
            if (array_key_exists($field, $validated)) {
                $validated[$field] = $this->normalizeRowsField($validated[$field], $keys);
            }
        }
        if (array_key_exists('faqs', $validated)) {
            $validated['faqs'] = $this->normalizeFaqRows($validated['faqs']);
        }

        $dest = Destination::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'destination' => $dest, 'message' => 'Destination added!']);
        }

        return back()->with('success', 'Destination added!');
    }

    public function updateDestination(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'duration' => 'required|string',
            'location' => 'nullable|string',
            'price_adult' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'price_child' => 'nullable|numeric',
            'rating' => 'nullable|numeric|between:0,5',
            'image' => 'nullable|url',
            'desc' => 'nullable|string',
            'long_description' => 'nullable|string',
            'quick_facts' => 'nullable|array',
            'quick_facts.*.label' => 'nullable|string',
            'quick_facts.*.value' => 'nullable|string',
            'highlights' => 'nullable|array',
            'highlights.*.icon' => 'nullable|string',
            'highlights.*.text' => 'nullable|string',
            'itinerary' => 'nullable|array',
            'itinerary.*.label' => 'nullable|string',
            'itinerary.*.title' => 'nullable|string',
            'itinerary.*.desc' => 'nullable|string',
            'itinerary.*.activities' => 'nullable|string',
            'itinerary.*.meals' => 'nullable|string',
            'itinerary.*.accommodation' => 'nullable|string',
            'includes' => 'nullable|array',
            'includes.*' => 'nullable|string',
            'excluded' => 'nullable|array',
            'excluded.*' => 'nullable|string',
            'faqs' => 'nullable|array',
            'faqs.*.q' => 'nullable|string',
            'faqs.*.a' => 'nullable|string',
            'gallery' => 'nullable|array',
            'gallery.*' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $dest = Destination::findOrFail($id);

        // Handle price fields: if price_adult not set, use existing price or price from request
        if (empty($validated['price_adult'])) {
            if (! empty($validated['price'])) {
                $validated['price_adult'] = $validated['price'];
            } elseif (! empty($dest->price)) {
                $validated['price_adult'] = $dest->price;
            }
        }
        if (empty($validated['price']) && ! empty($validated['price_adult'])) {
            $validated['price'] = $validated['price_adult'];
        }

        // Explicit per-field assignment so a partial save never blanks untouched content.
        $scalars = ['name', 'category', 'status', 'duration', 'location', 'price', 'price_adult', 'price_child', 'image', 'desc', 'long_description', 'meta_title', 'meta_description', 'meta_keywords'];
        foreach ($scalars as $field) {
            if (array_key_exists($field, $validated)) {
                $dest->{$field} = $validated[$field];
            }
        }

        if (array_key_exists('rating', $validated)) {
            $dest->rating = $validated['rating'] === '' || $validated['rating'] === null ? null : $validated['rating'];
        }

        // JSON repeaters — normalized and stored as arrays (null when every row is blank).
        $listFields = ['includes', 'excluded', 'gallery'];
        foreach ($listFields as $field) {
            if (array_key_exists($field, $validated)) {
                $dest->{$field} = $this->normalizeListField($validated[$field]);
            }
        }

        $rowFields = [
            'highlights' => ['icon', 'text'],
            'itinerary' => ['label', 'title', 'desc', 'activities', 'meals', 'accommodation'],
            'quick_facts' => ['label', 'value'],
        ];
        foreach ($rowFields as $field => $keys) {
            if (array_key_exists($field, $validated)) {
                $dest->{$field} = $this->normalizeRowsField($validated[$field], $keys);
            }
        }
        if (array_key_exists('faqs', $validated)) {
            $dest->faqs = $this->normalizeFaqRows($validated['faqs']);
        }

        $dest->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'destination' => $dest, 'message' => 'Destination updated!']);
        }

        return back()->with('success', 'Destination updated!');
    }

    /**
     * Filter a submitted list of strings, dropping blanks; null when nothing remains.
     */
    protected function normalizeListField($value): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $out = array_values(array_filter($value, fn ($item) => ! is_null($item) && trim((string) $item) !== ''));

        return $out ?: null;
    }

    /**
     * Filter a submitted array of keyed rows, dropping fully-blank rows and trimming values.
     */
    protected function normalizeRowsField($value, array $keys): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $out = [];
        foreach ($value as $row) {
            if (! is_array($row)) {
                continue;
            }
            $filtered = [];
            foreach ($keys as $key) {
                $filtered[$key] = trim((string) ($row[$key] ?? ''));
            }
            if (implode('', $filtered) !== '') {
                $out[] = $filtered;
            }
        }

        return $out ?: null;
    }

    /**
     * Filter FAQ rows, keeping only complete question + answer pairs.
     */
    protected function normalizeFaqRows($value): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $out = [];
        foreach ($value as $row) {
            if (! is_array($row)) {
                continue;
            }
            $q = trim((string) ($row['q'] ?? ''));
            $a = trim((string) ($row['a'] ?? ''));
            if ($q !== '' && $a !== '') {
                $out[] = ['q' => $q, 'a' => $a];
            }
        }

        return $out ?: null;
    }

    public function destroyDestination($id)
    {
        $dest = Destination::findOrFail($id);
        $dest->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Destination deleted!']);
        }

        return back()->with('success', 'Destination deleted!');
    }

    public function gallery()
    {
        $gallery = Gallery::all();

        return view('admin.gallery', [
            'gallery' => $gallery,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function storeGallery(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'caption' => 'nullable|string',
            'category' => 'required|string',
        ]);

        Gallery::create($validated);

        return back()->with('success', 'Image added to gallery!');
    }

    public function destroyGallery($id)
    {
        $img = Gallery::findOrFail($id);
        $img->delete();

        return back()->with('success', 'Gallery item deleted!');
    }

    public function reviews()
    {
        $reviews = Review::all();

        return view('admin.reviews', [
            'reviews' => $reviews,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function updateReviewStatus($id, $status)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => $status]);

        return back()->with('success', 'Review updated!');
    }

    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Review deleted!');
    }

    public function messages()
    {
        $messages = Message::latest()->get();

        return view('admin.messages', [
            'messages' => $messages,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function markMessageRead($id)
    {
        $msg = Message::findOrFail($id);
        $msg->update(['read' => true]);

        return back()->with('success', 'Message marked as read');
    }

    public function destroyMessage($id)
    {
        $msg = Message::findOrFail($id);
        $msg->delete();

        return back()->with('success', 'Message deleted!');
    }

    public function content()
    {
        return view('admin.content', $this->layoutData([
            'contents' => SiteContent::all(),
            'contentGroups' => [
                'general' => 'General information',
                'home' => 'Home page',
                'about' => 'About page',
                'contact' => 'Contact page',
                'destinations' => 'Destinations page',
                'destination' => 'Destination tour pages',
                'gallery' => 'Gallery page',
                'reviews' => 'Reviews page',
                'terms' => 'Terms page',
            ],
        ]));
    }

    public function contentUpdate(Request $request)
    {
        foreach ($request->input('content', []) as $key => $value) {
            $content = SiteContent::firstOrNew(['key' => $key]);
            $content->value = $value;
            if (! $content->exists) {
                $content->label = ucwords(str_replace(['_', '-'], ' ', $key));
            }
            $content->save();
        }

        return back()->with('success', 'Content saved!');
    }

    public function settings()
    {
        $contents = SiteContent::all();
        $currencies = array_values(array_intersect(
            CurrencyHelper::getSupportedCurrencies(),
            PesaPalService::SUPPORTED_CURRENCIES
        ));

        return view('admin.settings', [
            'contents' => $contents,
            'settings' => PaymentSettings::toArray(),
            'currencies' => $currencies ?: ['USD', 'TZS', 'KES', 'UGX'],
            'secretsStored' => [
                'pesapal_consumer_key' => PaymentSettings::isStored('pesapal_consumer_key'),
                'pesapal_consumer_secret' => PaymentSettings::isStored('pesapal_consumer_secret'),
            ],
            'depositPercentage' => PaymentSettings::depositPercentage(),
            'mailSettings' => MailSettings::toArray(),
            'mailPasswordStored' => MailSettings::isStored('mail_smtp_password'),
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        foreach ($request->input('content', []) as $key => $value) {
            $content = SiteContent::firstOrNew(['key' => $key]);
            $content->value = $value;
            if (! $content->exists) {
                $content->label = ucwords(str_replace(['_', '-'], ' ', $key));
            }
            $content->save();
        }

        return back()->with('success', 'Settings saved!');
    }

    public static function statusTag($status)
    {
        $map = [
            'Confirmed' => 'tag-green',
            'Pending' => 'tag-gold',
            'Completed' => 'tag-grey',
            'Cancelled' => 'tag-red',
            'Published' => 'tag-green',
            'Draft' => 'tag-grey',
        ];
        $class = $map[$status] ?? 'tag-grey';

        return '<span class="tag '.$class.'">'.htmlspecialchars($status).'</span>';
    }

    // Admin User Management
    public function users(Request $request)
    {
        $query = AdminUser::query();

        $filters = [
            'q' => trim((string) $request->input('q', '')),
            'role' => in_array($request->input('role'), AdminUser::ROLES, true) ? $request->input('role') : '',
            'status' => in_array($request->input('status'), ['active', 'inactive'], true) ? $request->input('status') : '',
        ];

        if ($filters['q'] !== '') {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['q']}%")
                    ->orWhere('email', 'like', "%{$filters['q']}%");
            });
        }
        if ($filters['role'] !== '') {
            $query->where('role', $filters['role']);
        }
        if ($filters['status'] !== '') {
            $query->where('is_active', $filters['status'] === 'active');
        }

        $users = $query
            ->withCount(['loginLogs as successful_logins' => fn ($q) => $q->where('success', true)])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $roleCounts = AdminUser::query()
            ->selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        $stats = [
            'total' => AdminUser::count(),
            'active' => AdminUser::where('is_active', true)->count(),
            'inactive' => AdminUser::where('is_active', false)->count(),
            'roles' => $roleCounts,
        ];

        $currentAdmin = session('admin_user_id') ? AdminUser::find(session('admin_user_id')) : null;

        return view('admin.users', $this->layoutData([
            'users' => $users,
            'stats' => $stats,
            'filters' => $filters,
            'currentAdmin' => $currentAdmin,
            'activePane' => 'users',
        ]));
    }

    public function storeUser(Request $request)
    {
        $actor = AdminAudit::actor();

        if (! $actor || ! $actor->canManageUsers()) {
            return back()->with('error', 'You do not have permission to manage users.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:super_admin,admin,editor,viewer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['must_change_password'] = $request->boolean('must_change_password');

        $user = AdminUser::create($validated);

        AdminAudit::log('user.created', 'admin_user', $user->id, [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'is_active' => $user->is_active,
        ], $actor);

        return back()->with('success', "User {$user->name} created successfully!");
    }

    public function updateUser(Request $request, $id)
    {
        $actor = AdminAudit::actor();

        if (! $actor || ! $actor->canManageUsers()) {
            return back()->with('error', 'You do not have permission to manage users.');
        }

        $user = AdminUser::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_users,email,'.$id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:super_admin,admin,editor,viewer',
            'is_active' => 'nullable|boolean',
            'must_change_password' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['must_change_password'] = $request->boolean('must_change_password');

        // An admin may never alter their own role or deactivate themselves.
        $isSelf = (int) $id === (int) $actor->id;
        if ($isSelf) {
            if ($validated['role'] !== $user->role) {
                return back()->with('error', 'You cannot change your own role.');
            }
            if ($request->boolean('is_active') === false) {
                return back()->with('error', 'You cannot deactivate your own account.');
            }
            $validated['must_change_password'] = false;
        }

        // Never demote the last remaining super admin.
        if ($user->isSuperAdmin() && $validated['role'] !== 'super_admin') {
            $superAdmins = AdminUser::where('role', 'super_admin')->count();
            if ($superAdmins <= 1) {
                return back()->with('error', 'At least one super admin must remain. Promote another user first.');
            }
        }

        $changes = [];

        if ($validated['role'] !== $user->role) {
            $changes['role'] = ['from' => $user->role, 'to' => $validated['role']];
        }

        if ($request->filled('password')) {
            $user->password = $validated['password'];
            $user->password_changed_at = now();
            $changes['password'] = true;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->is_active = $validated['is_active'];
        $user->must_change_password = $validated['must_change_password'];
        $user->save();

        AdminAudit::log('user.updated', 'admin_user', $user->id, [
            'changes' => $changes,
            'is_active' => $user->is_active,
            'must_change_password' => $user->must_change_password,
        ], $actor);

        return back()->with('success', "User {$user->name} updated successfully!");
    }

    public function destroyUser($id)
    {
        $actor = AdminAudit::actor();

        if (! $actor || ! $actor->canDeleteUsers()) {
            return back()->with('error', 'Only a super admin can delete users.');
        }

        $user = AdminUser::findOrFail($id);

        if ((int) $id === (int) $actor->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->isSuperAdmin()) {
            $superAdmins = AdminUser::where('role', 'super_admin')->count();
            if ($superAdmins <= 1) {
                return back()->with('error', 'At least one super admin must remain.');
            }
        }

        $user->delete();

        AdminAudit::log('user.deleted', 'admin_user', null, [
            'name' => $user->name,
            'email' => $user->email,
        ], $actor);

        return back()->with('success', "User {$user->name} deleted successfully!");
    }

    public function toggleUserStatus($id)
    {
        $actor = AdminAudit::actor();

        if (! $actor || ! $actor->canManageUsers()) {
            return back()->with('error', 'You do not have permission to manage users.');
        }

        $user = AdminUser::findOrFail($id);

        if ((int) $id === (int) $actor->id) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $wasActive = $user->is_active;
        $user->is_active = ! $wasActive;
        $user->save();

        AdminAudit::log('user.toggled', 'admin_user', $user->id, [
            'from' => $wasActive ? 'active' : 'inactive',
            'to' => $user->is_active ? 'active' : 'inactive',
            'name' => $user->name,
        ], $actor);

        $state = $user->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "User {$user->name} {$state} successfully!");
    }

    public function resetPassword(Request $request, $id)
    {
        $actor = AdminAudit::actor();

        if (! $actor || ! $actor->canManageUsers()) {
            return back()->with('error', 'You do not have permission to manage users.');
        }

        $user = AdminUser::findOrFail($id);

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = $validated['password'];
        $user->password_changed_at = now();

        $isSelf = (int) $id === (int) $actor->id;
        $user->must_change_password = ! $isSelf;
        $user->save();

        AdminAudit::log('user.password_reset', 'admin_user', $user->id, [
            'by' => $isSelf ? 'self' : $actor->email,
            'must_change_password' => $user->must_change_password,
        ], $actor);

        return back()->with('success', "Password updated for {$user->name}. They must change it on next login.");
    }

    public function userDetail($id)
    {
        $user = AdminUser::with(['loginLogs', 'activityLogs'])->findOrFail($id);

        $currentAdmin = session('admin_user_id') ? AdminUser::find(session('admin_user_id')) : null;

        return view('admin.user-detail', $this->layoutData([
            'user' => $user,
            'currentAdmin' => $currentAdmin,
            'isSelf' => $currentAdmin && (int) $currentAdmin->id === (int) $user->id,
            'loginLogs' => $user->loginLogs()->limit(20)->get(),
            'recentActivity' => $user->activityLogs()->limit(25)->get(),
            'loginCount' => $user->loginLogs()->where('success', true)->count(),
            'activePane' => 'users',
        ]));
    }

    // Forced/self password change
    public function changePasswordPage()
    {
        $currentAdmin = AdminAudit::actor();

        return view('admin.change-password', $this->layoutData([
            'currentAdmin' => $currentAdmin,
        ]));
    }

    public function submitChangePassword(Request $request)
    {
        $currentAdmin = AdminAudit::actor();
        if (! $currentAdmin) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $currentAdmin->password = $validated['password'];
        $currentAdmin->must_change_password = false;
        $currentAdmin->password_changed_at = now();
        $currentAdmin->save();

        session(['admin_role' => $currentAdmin->role]);

        AdminAudit::log('auth.password_changed', 'admin_user', $currentAdmin->id, [], $currentAdmin);

        return redirect()->route('admin.dashboard')->with('success', 'Your password has been updated successfully!');
    }

    // Profile Management
    public function profile()
    {
        $currentUser = AdminUser::find(session('admin_user_id'));

        return view('admin.profile', [
            'currentUser' => $currentUser,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $currentUser = AdminUser::find(session('admin_user_id'));

        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admin_users,email,'.$currentUser->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update name
        $currentUser->name = $validated['name'];

        // Update password if provided
        if (! empty($validated['new_password'])) {
            // Verify current password
            if (! $currentUser->checkPassword($validated['current_password'])) {
                return back()->with('error', 'Current password is incorrect.');
            }
            $currentUser->password = $validated['new_password'];
        }

        $currentUser->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    protected function layoutData(array $data): array
    {
        return array_merge($data, [
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
            'paymentCount' => Payment::count(),
            'currentAdminUser' => session('admin_user_id') ? AdminUser::find(session('admin_user_id')) : null,
        ]);
    }
}
