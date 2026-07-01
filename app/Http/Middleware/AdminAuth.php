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

        $admin = AdminUser::find(session('admin_user_id'));
        if (!$admin || !$admin->is_active) {
            session()->forget(['admin_logged_in', 'admin_user_id']);
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
