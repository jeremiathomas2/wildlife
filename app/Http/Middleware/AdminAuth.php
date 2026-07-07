<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AdminUser;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('admin_logged_in') || !session()->has('admin_user_id')) {
            return redirect()->route('admin.login');
        }

        // Check if last activity was more than 5 minutes (300 seconds) ago
        $timeout = 300; // 5 minutes in seconds
        if (session()->has('admin_last_activity') && (time() - session('admin_last_activity')) > $timeout) {
            session()->forget(['admin_logged_in', 'admin_user_id', 'admin_last_activity']);
            return redirect()->route('admin.login')->with('error', 'Session expired! Please login again.');
        }

        $admin = AdminUser::find(session('admin_user_id'));
        if (!$admin || !$admin->is_active) {
            session()->forget(['admin_logged_in', 'admin_user_id', 'admin_last_activity']);
            return redirect()->route('admin.login');
        }

        // Update last activity time
        session(['admin_last_activity' => time()]);

        return $next($request);
    }
}
