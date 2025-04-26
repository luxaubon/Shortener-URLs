<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Url;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_urls' => Url::count(),
            'recent_urls' => Url::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}