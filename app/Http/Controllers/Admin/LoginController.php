<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->isAdmin()) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard.index');
            }
            
            Auth::logout();
            return back()->withErrors([
                'message' => 'You do not have admin access.'
            ]);
        }

        return back()->withErrors([
            'message' => 'Invalid login credentials'
        ]);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
