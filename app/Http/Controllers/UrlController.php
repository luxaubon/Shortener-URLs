<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::where('user_id', auth()->id())->paginate(10);
        return view('urls.index', compact('urls'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url|max:2048',
            'title' => 'required|string|max:255',
        ]);

        $url = Url::create([
            'user_id' => auth()->id(),
            'original_url' => $request->original_url,
            'shortener_url' => $this->generateUniqueShortUrl(),
            'title' => $request->title,
        ]);

        return redirect()->back()->with('success', 'URL shortened successfully!');
    }

    public function show(Url $url)
    {
        $this->authorize('view', $url);
        return view('urls.show', compact('url'));
    }

    public function edit(Url $url)
    {
        return view('urls.edit', [
            'url' => $url,
        ]);
    }

    public function update(Request $request, Url $url)
    {
        $this->authorize('update', $url);
        
        $url->update($request->validated());
        return redirect()->route('urls.index')->with('success', 'URL updated successfully!');
    }

    public function destroy(Url $url)
    {
        $this->authorize('delete', $url);
        
        $url->delete();
        return redirect()->back()->with('success', 'URL deleted successfully.');
    }

    public function redirect($shortener_url)
    {
        $url = Url::where('shortener_url', $shortener_url)->firstOrFail();
        return redirect($url->original_url);
    }

    private function generateUniqueShortUrl()
    {
        do {
            $shortUrl = substr(md5(uniqid()), 0, 6);
        } while (Url::where('shortener_url', $shortUrl)->exists());

        return $shortUrl;
    }
}