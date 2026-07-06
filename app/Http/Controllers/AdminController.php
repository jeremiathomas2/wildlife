<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\Message;
use App\Models\SiteContent;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Redirect;

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

        if ($admin && $admin->checkPassword($credentials['password']) && $admin->is_active) {
            $admin->update(['last_login_at' => now()]);
            session(['admin_logged_in' => true, 'admin_user_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid credentials!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }

    public function currencySwitch(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|in:USD,EUR,GBP,KES,TZS,UGX,ZAR'
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
            $totalRevenue += \App\Helpers\CurrencyHelper::convert($amount, $currency, 'USD');
        }
        
        $recentBookings = Booking::latest()->take(5)->get();
        $activeDestinations = Destination::where('status', 'Published')->count();
        $unreadMessages = Message::where('read', false)->count();
        $pendingReviews = Review::where('status', 'Pending')->count();

        $dayTripCount = Booking::whereHas('destination', function($q) {
            $q->where('category', 'Day Trip');
        })->count();
        $multiDayCount = Booking::whereHas('destination', function($q) {
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
            'travel_date' => 'required|date',
            'guests' => 'required|integer|min:1',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        Booking::create($validated);
        return back()->with('success', 'Booking saved!');
    }

    public function updateBooking(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'tour_name' => 'required|string',
            'travel_date' => 'required|date',
            'guests' => 'required|integer|min:1',
            'amount' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($validated);
        return back()->with('success', 'Booking updated!');
    }

    public function destroyBooking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return back()->with('success', 'Booking deleted successfully.');
    }

    public function destinations()
    {
        $destinations = Destination::all();
        return view('admin.destinations', [
            'destinations' => $destinations,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function storeDestination(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'duration' => 'required|string',
            'price_adult' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'price_child' => 'nullable|numeric',
            'image' => 'nullable|url',
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Handle price fields: if price_adult not set, use price; set price from price_adult
        if (empty($validated['price_adult']) && !empty($validated['price'])) {
            $validated['price_adult'] = $validated['price'];
        }
        if (empty($validated['price']) && !empty($validated['price_adult'])) {
            $validated['price'] = $validated['price_adult'];
        }
        
        $dest = Destination::create($validated);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'destination' => $dest, 'message' => 'Destination added!']);
        }
        return back()->with('success', 'Destination added!');
    }

    public function updateDestination(Request $request, $id)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'duration' => 'required|string',
            'price_adult' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'price_child' => 'nullable|numeric',
            'image' => 'nullable|url',
            'desc' => 'nullable|string',
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
            if (!empty($validated['price'])) {
                $validated['price_adult'] = $validated['price'];
            } else if (!empty($dest->price)) {
                $validated['price_adult'] = $dest->price;
            }
        }
        if (empty($validated['price']) && !empty($validated['price_adult'])) {
            $validated['price'] = $validated['price_adult'];
        }

        $dest->update($validated);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'destination' => $dest, 'message' => 'Destination updated!']);
        }
        return back()->with('success', 'Destination updated!');
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

    public function settings()
    {
        $contents = SiteContent::all();
        return view('admin.settings', [
            'contents' => $contents,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function updateSettings(Request $request)
    {
        foreach($request->input('content', []) as $key => $value) {
            SiteContent::where('key', $key)->update(['value' => $value]);
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
        return '<span class="tag ' . $class . '">' . htmlspecialchars($status) . '</span>';
    }

    // Admin User Management
    public function users()
    {
        $users = AdminUser::paginate(10);
        return view('admin.users', [
            'users' => $users,
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admin_users,email',
            'password' => 'required|string|min:6',
            'is_active' => 'boolean',
        ]);

        AdminUser::create($validated);
        return back()->with('success', 'User added successfully!');
    }

    public function updateUser(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:admin_users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'is_active' => 'boolean',
        ]);

        $user = AdminUser::findOrFail($id);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);
        return back()->with('success', 'User updated successfully!');
    }

    public function destroyUser($id)
    {
        $user = AdminUser::findOrFail($id);

        // Prevent deleting the last admin user
        if (AdminUser::count() <= 1) {
            return back()->with('error', 'Cannot delete the last admin user!');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully!');
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
            'email' => 'required|email|unique:admin_users,email,' . $currentUser->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update name
        $currentUser->name = $validated['name'];

        // Update password if provided
        if (!empty($validated['new_password'])) {
            // Verify current password
            if (!$currentUser->checkPassword($validated['current_password'])) {
                return back()->with('error', 'Current password is incorrect.');
            }
            $currentUser->password = $validated['new_password'];
        }

        $currentUser->save();
        return back()->with('success', 'Profile updated successfully!');
    }
}
