<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SeoController extends Controller
{
    /**
     * Generate dynamic XML sitemap
     */
    public function sitemap()
    {
        $posts = Post::where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->get();
        
        $pages = Page::where('is_active', true)->get();
        
        $sitemapContent = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemapContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        // Homepage
        $sitemapContent .= '  <url>' . PHP_EOL;
        $sitemapContent .= '    <loc>' . url('/') . '</loc>' . PHP_EOL;
        $sitemapContent .= '    <changefreq>daily</changefreq>' . PHP_EOL;
        $sitemapContent .= '    <priority>1.0</priority>' . PHP_EOL;
        $sitemapContent .= '  </url>' . PHP_EOL;
        
        // Posts
        foreach ($posts as $post) {
            $sitemapContent .= '  <url>' . PHP_EOL;
            $sitemapContent .= '    <loc>' . route('post.show', $post->slug) . '</loc>' . PHP_EOL;
            $sitemapContent .= '    <lastmod>' . $post->updated_at->toW3cString() . '</lastmod>' . PHP_EOL;
            $sitemapContent .= '    <changefreq>weekly</changefreq>' . PHP_EOL;
            $sitemapContent .= '    <priority>0.8</priority>' . PHP_EOL;
            $sitemapContent .= '  </url>' . PHP_EOL;
        }
        
        // Static Pages
        foreach ($pages as $page) {
            $sitemapContent .= '  <url>' . PHP_EOL;
            $sitemapContent .= '    <loc>' . route('page.show', $page->slug) . '</loc>' . PHP_EOL;
            $sitemapContent .= '    <lastmod>' . $page->updated_at->toW3cString() . '</lastmod>' . PHP_EOL;
            $sitemapContent .= '    <changefreq>monthly</changefreq>' . PHP_EOL;
            $sitemapContent .= '    <priority>0.5</priority>' . PHP_EOL;
            $sitemapContent .= '  </url>' . PHP_EOL;
        }
        
        $sitemapContent .= '</urlset>';
        
        return response($sitemapContent, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    /**
     * Generate robots.txt
     */
    public function robots()
    {
        $sitemapUrl = url('/sitemap.xml');
        $content = <<<TXT
User-agent: *
Allow: /

# Block admin panel from crawlers
Disallow: /admin
Disallow: /admin/*
Disallow: /storage/
Disallow: /livewire/

# Sitemap
Sitemap: {$sitemapUrl}
TXT;
        
        return response($content, 200, ['Content-Type' => 'text/plain']);
    }

    /**
     * Generate ads.txt
     */
    public function adsTxt()
    {
        $content = Setting::get('ads_txt_content', 'google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0');
        
        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
