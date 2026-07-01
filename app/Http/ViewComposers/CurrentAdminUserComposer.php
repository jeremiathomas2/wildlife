<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\AdminUser;

class CurrentAdminUserComposer
{
    public function compose(View $view)
    {
        $adminUser = null;
        if (session()->has('admin_user_id')) {
            $adminUser = AdminUser::find(session('admin_user_id'));
        }
        $view->with('currentAdminUser', $adminUser);
    }
}
