<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Chalet;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardhController extends Controller
{
    public function showDashboard()
    {
        $admins_count = Admin::count();
        $users_count = User::count();
        $chalets_count = Chalet::count();
        return response()->view(
            'dashboard.home',
            [
                'admins_count' => $admins_count,
                'users_count' => $users_count, 'chalets_count' => $chalets_count,
            ]
        );
    }
}
