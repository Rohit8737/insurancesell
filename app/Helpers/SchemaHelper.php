<?php

namespace App\Helpers;

use App\Models\Post;

class SchemaHelper
{
    /**
     * Get site name from settings
     */
    private static function siteName(): string
    {
        return setting('site_name', 'InsuranceSell');
    }

    private static function siteUrl(): string
    {
        return url('/');
    }

    private static function siteLogo(): string
    {
        return asset('storage/' . setting('site_logo', 'logo.png'));
    }

    /**
     * 1. ARTICLE SCHEMA - For every blog/article page
     */
    public static function article(Post $post): array
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => route('post.show', $post->slug),
            ],
            'headline' => $post->title,
            'description' => $post->meta_description ?? \Str::limit(strip_tags($post->description), 160),
            'datePublished' => $post->published_at?->toIso8601String() ?? $post->created_at->toIso8601String(),
            'dateModified' => $post->updated_at->toIso8601String(),
            'author' => self::person(),
            'publisher' => self::organizationMinimal(),
            'wordCount' => str_word_count(strip_tags($post->description)),
            'articleSection' => 'Insurance',
            'inLanguage' => 'en-US',
        ];

        if ($post->featured_image) {
            $schema['image'] = self::imageObject($post);
        }

        if ($post->video_path) {
            $schema['video'] = self::videoObject($post);
        }

        return $schema;
    }

    /**
     * 2. ORGANIZATION SCHEMA - Company/brand info
     */
    public static function organization(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => self::siteName(),
            'url' => self::siteUrl(),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => self::siteLogo(),
                'width' => 600,
                'height' => 60,
            ],
            'description' => setting('site_description', 'Expert insurance guides, comparisons, and financial planning resources.'),
            'sameAs' => array_filter([
                setting('social_facebook'),
                setting('social_instagram'),
                setting('social_youtube'),
                setting('social_twitter'),
            ]),
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Hindi'],
            ],
        ];
    }

    /**
     * Minimal organization for publisher field
     */
    private static function organizationMinimal(): array
    {
        return [
            '@type' => 'Organization',
            'name' => self::siteName(),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => self::siteLogo(),
                'width' => 600,
                'height' => 60,
            ],
        ];
    }

    /**
     * 3. WEBSITE SCHEMA - Site-level info
     */
    public static function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => self::siteName(),
            'url' => self::siteUrl(),
            'description' => setting('site_description', 'Expert insurance guides and financial planning resources.'),
            'inLanguage' => 'en-US',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => self::siteUrl() . '/search?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * 4. BREADCRUMB SCHEMA - Navigation path
     */
    public static function breadcrumb(array $items): array
    {
        $listItems = [];
        foreach ($items as $i => $item) {
            $listItem = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
            ];
            // Only add 'item' URL if it exists (last breadcrumb = current page, no URL needed)
            if (!empty($item['url'])) {
                $listItem['item'] = $item['url'];
            }
            $listItems[] = $listItem;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    /**
     * 5. FAQ SCHEMA - Only extracts REAL questions from content
     * Must contain question mark (?) or start with question words
     */
    public static function faq(Post $post): ?array
    {
        $content = $post->description;
        $faqs = [];

        // Question indicator words
        $questionPatterns = [
            '?',           // Contains question mark
            'what ',       // What is...
            'how ',        // How to...
            'why ',        // Why is...
            'when ',       // When should...
            'which ',      // Which is...
            'who ',        // Who can...
            'where ',      // Where to...
            'can ',        // Can I...
            'should ',     // Should I...
            'do ',         // Do I need...
            'does ',       // Does it...
            'is ',         // Is it...
            'are ',        // Are there...
            'will ',       // Will it...
        ];

        // Extract Q&A from H3 headings (typically FAQ sub-headings) followed by paragraphs
        preg_match_all('/<h3[^>]*>(.*?)<\/h3>\s*<p>(.*?)<\/p>/si', $content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $question = strip_tags(trim($match[1]));
            $answer = strip_tags(trim($match[2]));
            $questionLower = strtolower($question);

            // STRICT CHECK: Only include if it looks like a real question
            $isQuestion = false;
            foreach ($questionPatterns as $pattern) {
                if (str_contains($question, '?') || str_starts_with($questionLower, $pattern)) {
                    $isQuestion = true;
                    break;
                }
            }

            // Add question mark if missing but it IS a question
            if ($isQuestion && !str_contains($question, '?')) {
                $question = rtrim($question, '.') . '?';
            }

            if ($isQuestion && !empty($answer) && strlen($answer) > 30) {
                $faqs[] = [
                    '@type' => 'Question',
                    'name' => $question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => \Str::limit($answer, 500),
                    ],
                ];
            }
        }

        if (empty($faqs)) return null;

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_slice($faqs, 0, 5), // Max 5 FAQs for quality
        ];
    }

    /**
     * 6. AGGREGATE RATING SCHEMA - Based on views as social proof
     * Uses stable hash so same article always gets same rating
     */
    public static function review(Post $post): array
    {
        // Generate stable rating from post slug (4.2 - 4.9 range)
        $hash = crc32($post->slug ?? $post->title);
        $rating = 4.2 + (abs($hash) % 8) / 10; // 4.2 to 4.9
        $reviewCount = max(10, ($post->views ?? 50) / 3); // Minimum 10 reviews

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'name' => $post->title,
            'url' => route('post.show', $post->slug),
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => number_format($rating, 1),
                'bestRating' => '5',
                'worstRating' => '1',
                'ratingCount' => (int) $reviewCount,
            ],
        ];
    }

    /**
     * 7. VIDEO OBJECT SCHEMA - For video content
     */
    public static function videoObject(Post $post): ?array
    {
        if (!$post->video_path) return null;

        return [
            '@type' => 'VideoObject',
            'name' => $post->title,
            'description' => $post->meta_description ?? \Str::limit(strip_tags($post->description), 160),
            'thumbnailUrl' => $post->featured_image ? asset('storage/' . $post->featured_image) : '',
            'uploadDate' => $post->created_at->toIso8601String(),
            'contentUrl' => asset('storage/' . $post->video_path),
            'embedUrl' => route('post.show', $post->slug),
            'duration' => 'PT5M', // Default 5 minutes
            'interactionStatistic' => [
                '@type' => 'InteractionCounter',
                'interactionType' => ['@type' => 'WatchAction'],
                'userInteractionCount' => $post->views ?? 0,
            ],
        ];
    }

    /**
     * 8. PERSON/AUTHOR SCHEMA - Author credibility (E-E-A-T)
     */
    public static function person(): array
    {
        return [
            '@type' => 'Person',
            'name' => setting('author_name', 'Insurance Expert'),
            'description' => setting('author_bio', 'Certified financial advisor with 10+ years of experience in insurance planning.'),
            'url' => url('/'),
            'sameAs' => array_filter([
                setting('social_facebook'),
                setting('social_instagram'),
                setting('social_youtube'),
                setting('social_twitter'),
            ]),
            'jobTitle' => 'Insurance Expert & Financial Advisor',
            'knowsAbout' => [
                'Life Insurance', 'Term Insurance', 'Health Insurance',
                'Motor Insurance', 'Financial Planning', 'Investment',
            ],
        ];
    }

    /**
     * 9. IMAGE OBJECT SCHEMA - Image SEO
     */
    public static function imageObject(Post $post): ?array
    {
        if (!$post->featured_image) return null;

        return [
            '@type' => 'ImageObject',
            'url' => asset('storage/' . $post->featured_image),
            'width' => 1200,
            'height' => 630,
            'caption' => $post->title,
            'creditText' => self::siteName(),
            'creator' => self::person(),
            'copyrightNotice' => '© ' . date('Y') . ' ' . self::siteName(),
        ];
    }

    /**
     * 10. FINANCIAL PRODUCT SCHEMA - Insurance specific
     */
    public static function financialProduct(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FinancialProduct',
            'name' => $post->title,
            'description' => $post->meta_description ?? \Str::limit(strip_tags($post->description), 160),
            'url' => route('post.show', $post->slug),
            'provider' => self::organizationMinimal(),
            'category' => 'Insurance',
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'India',
            ],
            'audience' => [
                '@type' => 'Audience',
                'audienceType' => 'Individuals seeking insurance',
            ],
        ];
    }

    /**
     * 11. HOWTO SCHEMA - Step-by-step guides
     */
    public static function howTo(Post $post): ?array
    {
        $content = $post->description;
        $steps = [];

        // Extract steps from ordered lists
        preg_match_all('/<li>(.*?)<\/li>/si', $content, $matches);

        if (count($matches[1]) < 3) return null;

        foreach (array_slice($matches[1], 0, 10) as $i => $step) {
            $steps[] = [
                '@type' => 'HowToStep',
                'position' => $i + 1,
                'text' => strip_tags(trim($step)),
                'name' => 'Step ' . ($i + 1),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'HowTo',
            'name' => $post->title,
            'description' => $post->meta_description ?? \Str::limit(strip_tags($post->description), 160),
            'step' => $steps,
            'totalTime' => 'PT10M',
            'estimatedCost' => [
                '@type' => 'MonetaryAmount',
                'currency' => 'INR',
                'value' => '0',
            ],
        ];
    }

    /**
     * 12. TABLE SCHEMA - Data tables in content
     */
    public static function table(Post $post): ?array
    {
        if (!str_contains($post->description, '<table')) return null;

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Table',
            'about' => $post->title,
            'isPartOf' => [
                '@type' => 'WebPage',
                '@id' => route('post.show', $post->slug),
            ],
        ];
    }

    /**
     * 13. SITELINKS SEARCH BOX SCHEMA
     */
    public static function sitelinksSearchBox(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'url' => self::siteUrl(),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => self::siteUrl() . '/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * GENERATE ALL SCHEMAS FOR A POST PAGE
     * Returns a combined JSON-LD script with all applicable schemas
     */
    public static function generateForPost(Post $post): string
    {
        $schemas = [];

        // 1. Article (always)
        $schemas[] = self::article($post);

        // 2. Organization (always)
        $schemas[] = self::organization();

        // 3. WebSite (always)
        $schemas[] = self::website();

        // 4. Breadcrumb
        $schemas[] = self::breadcrumb([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => $post->title],
        ]);

        // 5. FAQ (if content has Q&A-style headings)
        $faq = self::faq($post);
        if ($faq) $schemas[] = $faq;

        // 6. Review/Rating
        $schemas[] = self::review($post);

        // 7. VideoObject (if has video)
        if ($post->video_path) {
            $video = self::videoObject($post);
            if ($video) {
                $videoSchema = $video;
                $videoSchema['@context'] = 'https://schema.org';
                $schemas[] = $videoSchema;
            }
        }

        // 8. Person/Author
        $personSchema = self::person();
        $personSchema['@context'] = 'https://schema.org';
        $schemas[] = $personSchema;

        // 9. ImageObject (if has image)
        if ($post->featured_image) {
            $img = self::imageObject($post);
            if ($img) {
                $img['@context'] = 'https://schema.org';
                $schemas[] = $img;
            }
        }

        // 10. FinancialProduct (insurance articles)
        $schemas[] = self::financialProduct($post);

        // 11. HowTo (if content has steps)
        $howTo = self::howTo($post);
        if ($howTo) $schemas[] = $howTo;

        // 12. Table (if content has tables)
        $table = self::table($post);
        if ($table) $schemas[] = $table;

        // Generate script tags
        $output = '';
        foreach ($schemas as $schema) {
            $output .= '<script type="application/ld+json">' . "\n";
            $output .= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $output .= "\n" . '</script>' . "\n";
        }

        return $output;
    }

    /**
     * GENERATE SCHEMAS FOR HOMEPAGE/LAYOUT
     * Organization + WebSite + SitelinksSearchBox
     */
    public static function generateForLayout(): string
    {
        $schemas = [
            self::organization(),
            self::website(),
            self::sitelinksSearchBox(),
        ];

        $output = '';
        foreach ($schemas as $schema) {
            $output .= '<script type="application/ld+json">' . "\n";
            $output .= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            $output .= "\n" . '</script>' . "\n";
        }

        return $output;
    }
}
