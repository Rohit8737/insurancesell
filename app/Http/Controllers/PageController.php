<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    /**
     * Show a static page
     */
    public function showPage(string $slug)
    {
        // Cache page for 1 hour
        $page = Cache::remember("page_{$slug}", 3600, function () use ($slug) {
            return Page::where('slug', $slug)
                ->active()
                ->first();
        });
        
        if (!$page) {
            abort(404);
        }
        
        return view('pages.show', compact('page'));
    }
}
