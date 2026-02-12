<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage - redirects to first post or shows listing
Route::get('/', [PostController::class, 'home'])->name('home');

// Post routes
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');

// Contact form
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware('throttle:3,60'); // 3 per hour per IP

// SEO Routes (SeoController)
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('robots');
Route::get('/ads.txt', [SeoController::class, 'adsTxt'])->name('ads-txt');

// Static Pages (MUST BE LAST - catch-all route)
Route::get('/{slug}', [PageController::class, 'showPage'])->name('page.show');
