<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::with('user')->latest()->paginate(10);
        return view('admin.urls.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => 'required|url|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,id'
        ]);

        $url = Url::create([
            ...$validated,
            'shortener_url' => $this->generateUniqueShortUrl(),
        ]);

        return redirect()->route('admin.urls.index')
            ->with('success', 'URL created successfully');
    }

    public function show(Url $url)
    {
        return view('admin.urls.show', compact('url'));
    }

    public function update(Request $request, Url $url)
    {
        $validated = $request->validate([
            'original_url' => 'required|url|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_id' => 'required|exists:users,id'
        ]);

        $url->update($validated);

        return redirect()->route('admin.urls.show', $url)
            ->with('success', 'URL updated successfully');
    }

    public function destroy(Url $url)
    {
        $url->delete();
        return redirect()->route('admin.urls.index')
            ->with('success', 'URL deleted successfully');
    }

    private function generateUniqueShortUrl()
    {
        do {
            $shortUrl = substr(md5(uniqid()), 0, 6);
        } while (Url::where('shortener_url', $shortUrl)->exists());

        return $shortUrl;
    }
}