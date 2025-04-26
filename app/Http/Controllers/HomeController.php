<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $urls = Url::where('user_id', auth()->id())->latest()->paginate(10);
        return view('home', compact('urls'));
    }
}