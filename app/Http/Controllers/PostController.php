<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Redirect homepage to first active post
     */
    public function home()
    {
        $mode = Setting::get('homepage_mode', 'redirect');
        
        if ($mode === 'listing') {
            $posts = Post::active()
                ->published()
                ->ordered()
                ->paginate(12);
            
            return view('posts.index', compact('posts'));
        }
        
        // Redirect mode - go to RANDOM post (different every time)
        $firstPost = Post::active()
            ->published()
            ->inRandomOrder()
            ->first();
        
        if (!$firstPost) {
            return view('posts.empty');
        }
        
        return redirect()->route('post.show', $firstPost->slug);
    }

    /**
     * Show single post - THE REVENUE ENGINE
     */
    public function show(Request $request, string $slug)
    {
        // Cache post for 10 minutes
        $post = Cache::remember("post_{$slug}", 600, function () use ($slug) {
            return Post::where('slug', $slug)
                ->active()
                ->published()
                ->first();
        });
        
        if (!$post) {
            abort(404);
        }
        
        // SESSION-BASED VIEW COUNTING (prevent spam)
        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            Post::where('id', $post->id)->increment('views');
            session()->put($sessionKey, true);
        }
        
        // RESOLVE NEXT POST (ARBITRAGE LOOP)
        $nextPost = $this->resolveNextPost($post);
        
        // INJECT ADS INTO CONTENT
        $content = $this->injectAdsIntoContent($post->description);
        
        // Get scroll text (post-specific or global)
        $scrollText = $post->scroll_text ?: Setting::get('scroll_text', '⬇️ Watch Full Video - Scroll Down ⬇️');
        
        // Get bridge text (post-specific or global)
        $bridgeText = $post->bridge_text ?: Setting::get('default_bridge_text', '💡 Discover why smart financial planning...');
        
        // Check if visitor is a bot (set by FilterBotTraffic middleware)
        $isBot = $request->attributes->get('is_bot', false);
        
        return view('posts.show', [
            'post' => $post,
            'nextPost' => $nextPost,
            'content' => $content,
            'scrollText' => $scrollText,
            'bridgeText' => $bridgeText,
            'isBot' => $isBot,
        ]);
    }

    /**
     * Resolve next post in arbitrage loop
     */
    protected function resolveNextPost(Post $post): ?Post
    {
        // Try explicit next post first
        if ($post->next_post_id) {
            $next = Post::find($post->next_post_id);
            if ($next && $next->is_active) {
                return $next;
            }
        }
        
        // Find next by sort order
        $next = Post::active()
            ->published()
            ->where('sort_order', '>', $post->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();
        
        if ($next) {
            return $next;
        }
        
        // Loop back to first post (arbitrage loop complete!)
        $first = Post::active()
            ->published()
            ->orderBy('sort_order', 'asc')
            ->first();
        
        // Don't loop to self
        if ($first && $first->id !== $post->id) {
            return $first;
        }
        
        return null;
    }

    /**
     * Inject ads into content at specified paragraph positions
     */
    protected function injectAdsIntoContent(string $content): string
    {
        // Check if ads should be shown (not a bot)
        if (view()->shared('isBot', false)) {
            return $content;
        }
        
        // Get ad positions from settings (default: after 2nd and 4th paragraph)
        $pos1 = (int) Setting::get('ad_paragraph_1', 2);
        $pos2 = (int) Setting::get('ad_paragraph_2', 4);
        
        // Get ad content from settings (empty = no ad)
        $ad1Code = Setting::get('ad_content_1_code', '');
        $ad2Code = Setting::get('ad_content_2_code', '');
        
        // Check if enabled
        $ad1Enabled = Setting::get('ad_content_1_enabled', 'true') !== 'false';
        $ad2Enabled = Setting::get('ad_content_2_enabled', 'true') !== 'false';
        
        // Only inject if enabled AND code exists
        $ad1 = ($ad1Enabled && $ad1Code) ? $ad1Code : '';
        $ad2 = ($ad2Enabled && $ad2Code) ? $ad2Code : '';
        
        // Split content by paragraphs
        $paragraphs = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        
        $result = '';
        $pCount = 0;
        
        for ($i = 0; $i < count($paragraphs); $i++) {
            $result .= $paragraphs[$i];
            
            // Count closing p tags
            if (preg_match('/<\/p>/i', $paragraphs[$i])) {
                $pCount++;
                
                // Inject first ad after position 1
                if ($pCount == $pos1 && $ad1) {
                    $result .= '<div class="ad-slot my-4">' . $ad1 . '</div>';
                }
                
                // Inject second ad after position 2
                if ($pCount == $pos2 && $ad2) {
                    $result .= '<div class="ad-slot my-4">' . $ad2 . '</div>';
                }
            }
        }
        
        return $result;
    }

    /**
     * Decode Base64 encoded ad content
     */
    protected function decodeAd(?string $encoded): string
    {
        if (empty($encoded)) {
            return '';
        }
        
        try {
            return base64_decode($encoded) ?: '';
        } catch (\Exception $e) {
            return '';
        }
    }
}
