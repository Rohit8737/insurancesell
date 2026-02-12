<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MorePostsSeeder extends Seeder
{
    public function run(): void
    {
        $startOrder = Post::max('sort_order') + 1;
        $articles = $this->getArticles();
        
        foreach ($articles as $index => $article) {
            Post::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'description' => $article['content'],
                'bridge_text' => $article['bridge'],
                'meta_title' => $article['meta_title'],
                'meta_description' => $article['meta_desc'],
                'focus_keyword' => $article['keyword'],
                'is_active' => true,
                'sort_order' => $startOrder + $index,
                'views' => rand(100, 5000),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
        
        // Relink all posts in arbitrage loop
        $posts = Post::orderBy('sort_order')->get();
        foreach ($posts as $i => $post) {
            $nextIndex = ($i + 1) % $posts->count();
            $post->update(['next_post_id' => $posts[$nextIndex]->id]);
        }
    }

    private function getArticles(): array
    {
        return [
            // MORE LIFE INSURANCE - CPC $50-80
            ['title' => 'Final Expense Insurance: Affordable Burial Coverage Guide', 'keyword' => 'final expense insurance', 'bridge' => '⚱️ Leave no financial burden behind for your loved ones...', 'meta_title' => 'Final Expense Insurance - Burial Coverage & Costs', 'meta_desc' => 'Learn about final expense insurance for burial costs. Affordable whole life coverage from $5,000-$25,000 with no medical exam options.', 'content' => $this->gen('final expense insurance')],
            ['title' => 'Guaranteed Issue Life Insurance: No Questions Asked Coverage', 'keyword' => 'guaranteed issue life insurance', 'bridge' => '✅ Get approved regardless of health conditions...', 'meta_title' => 'Guaranteed Issue Life Insurance - No Health Questions', 'meta_desc' => 'Guaranteed issue life insurance accepts everyone. No medical exam or health questions required for approval.', 'content' => $this->gen('guaranteed issue life insurance')],
            ['title' => 'Variable Life Insurance: Investment and Protection Combined', 'keyword' => 'variable life insurance', 'bridge' => '📈 Combine life insurance with investment growth potential...', 'meta_title' => 'Variable Life Insurance - Investment + Protection', 'meta_desc' => 'Learn about variable life insurance with investment options. Understand risks, benefits, and if this policy fits your financial goals.', 'content' => $this->gen('variable life insurance')],
            ['title' => 'Group Life Insurance Through Employer: Benefits Explained', 'keyword' => 'group life insurance', 'bridge' => '🏢 Maximize your employer provided life insurance benefits...', 'meta_title' => 'Group Life Insurance - Employer Benefits Guide', 'meta_desc' => 'Understand group life insurance through your employer. Learn coverage limits, portability options, and when to get additional coverage.', 'content' => $this->gen('group life insurance')],
            ['title' => 'Survivorship Life Insurance: Joint Coverage for Couples', 'keyword' => 'survivorship life insurance', 'bridge' => '💑 Second-to-die policies for estate planning and wealth transfer...', 'meta_title' => 'Survivorship Life Insurance - Joint Policy for Couples', 'meta_desc' => 'Learn about survivorship life insurance for couples. Understand second-to-die policies for estate planning and inheritance protection.', 'content' => $this->gen('survivorship life insurance')],
            
            // MORE HEALTH INSURANCE - CPC $40-60
            ['title' => 'COBRA Health Insurance: Continuing Coverage After Job Loss', 'keyword' => 'cobra health insurance', 'bridge' => '📋 Keep your health coverage when leaving your job...', 'meta_title' => 'COBRA Health Insurance - Coverage After Job Loss', 'meta_desc' => 'Learn about COBRA health insurance after job loss. Understand costs, enrollment deadlines, and alternatives to COBRA coverage.', 'content' => $this->gen('cobra health insurance')],
            ['title' => 'Marketplace Health Insurance: ACA Plans and Subsidies Guide', 'keyword' => 'marketplace health insurance', 'bridge' => '🏥 Find affordable coverage through the ACA marketplace...', 'meta_title' => 'Marketplace Health Insurance - ACA Plans Guide', 'meta_desc' => 'Navigate the health insurance marketplace. Understand ACA plans, subsidies, and how to find affordable coverage that fits your needs.', 'content' => $this->gen('marketplace health insurance')],
            ['title' => 'Catastrophic Health Insurance: High Deductible Protection', 'keyword' => 'catastrophic health insurance', 'bridge' => '🛡️ Low premium protection against worst-case scenarios...', 'meta_title' => 'Catastrophic Health Insurance - Low Cost Protection', 'meta_desc' => 'Learn about catastrophic health insurance plans. Understand eligibility, coverage, and if high-deductible protection fits your needs.', 'content' => $this->gen('catastrophic health insurance')],
            ['title' => 'Dental Insurance Plans: Coverage for Oral Health Care', 'keyword' => 'dental insurance', 'bridge' => '🦷 Protect your smile with affordable dental coverage...', 'meta_title' => 'Dental Insurance Plans - Coverage and Costs', 'meta_desc' => 'Compare dental insurance plans for preventive, basic, and major services. Find affordable coverage for you and your family.', 'content' => $this->gen('dental insurance')],
            ['title' => 'Vision Insurance: Eye Care Coverage Options Explained', 'keyword' => 'vision insurance', 'bridge' => '👓 Affordable coverage for eye exams, glasses, and contacts...', 'meta_title' => 'Vision Insurance Guide - Eye Care Coverage', 'meta_desc' => 'Learn about vision insurance coverage for eye exams, glasses, and contacts. Compare plans to find affordable eye care protection.', 'content' => $this->gen('vision insurance')],
            
            // MORE AUTO INSURANCE - CPC $45-70
            ['title' => 'Motorcycle Insurance: Coverage for Two-Wheel Riders', 'keyword' => 'motorcycle insurance', 'bridge' => '🏍️ Essential protection for motorcycle enthusiasts...', 'meta_title' => 'Motorcycle Insurance - Coverage and Rates', 'meta_desc' => 'Learn about motorcycle insurance coverage options. Compare rates and understand the protection every rider needs.', 'content' => $this->gen('motorcycle insurance')],
            ['title' => 'Classic Car Insurance: Specialty Coverage for Antiques', 'keyword' => 'classic car insurance', 'bridge' => '🚗 Protect your vintage vehicle investment...', 'meta_title' => 'Classic Car Insurance - Antique Vehicle Coverage', 'meta_desc' => 'Learn about classic car insurance for antique and vintage vehicles. Understand agreed value coverage and specialty protection.', 'content' => $this->gen('classic car insurance')],
            ['title' => 'Gap Insurance: Protect Your Car Loan Investment', 'keyword' => 'gap insurance', 'bridge' => '💰 Cover the gap between your loan and car value...', 'meta_title' => 'Gap Insurance Explained - Auto Loan Protection', 'meta_desc' => 'Learn about gap insurance for auto loans. Understand when you need it and how it protects your investment if your car is totaled.', 'content' => $this->gen('gap insurance')],
            ['title' => 'Usage Based Car Insurance: Pay Per Mile Coverage', 'keyword' => 'usage based insurance', 'bridge' => '📱 Drive less, pay less with telematics insurance...', 'meta_title' => 'Usage Based Insurance - Pay Per Mile Auto Coverage', 'meta_desc' => 'Learn about usage-based car insurance programs. Understand how telematics and pay-per-mile coverage can save you money.', 'content' => $this->gen('usage based insurance')],
            ['title' => 'Rideshare Insurance: Uber and Lyft Driver Coverage', 'keyword' => 'rideshare insurance', 'bridge' => '🚕 Essential coverage gaps for Uber and Lyft drivers...', 'meta_title' => 'Rideshare Insurance - Uber & Lyft Driver Coverage', 'meta_desc' => 'Learn about rideshare insurance for Uber and Lyft drivers. Understand coverage gaps and protection options for gig drivers.', 'content' => $this->gen('rideshare insurance')],
            
            // MORE HOME INSURANCE - CPC $35-55
            ['title' => 'Condo Insurance: HO-6 Policy Coverage Explained', 'keyword' => 'condo insurance', 'bridge' => '🏢 Protect your condo unit and personal belongings...', 'meta_title' => 'Condo Insurance (HO-6) - Coverage Guide', 'meta_desc' => 'Learn about condo insurance HO-6 policies. Understand walls-in coverage, personal property protection, and liability for condo owners.', 'content' => $this->gen('condo insurance')],
            ['title' => 'Mobile Home Insurance: Manufactured Housing Protection', 'keyword' => 'mobile home insurance', 'bridge' => '🏠 Specialized coverage for manufactured homes...', 'meta_title' => 'Mobile Home Insurance - Manufactured Housing Coverage', 'meta_desc' => 'Learn about mobile home insurance for manufactured housing. Compare coverage options and find affordable protection for your home.', 'content' => $this->gen('mobile home insurance')],
            ['title' => 'Earthquake Insurance: Protection for Seismic Risks', 'keyword' => 'earthquake insurance', 'bridge' => '🌍 Standard home insurance excludes earthquake damage...', 'meta_title' => 'Earthquake Insurance - Seismic Coverage Guide', 'meta_desc' => 'Learn about earthquake insurance for your home. Understand coverage, costs, and deductibles for seismic protection.', 'content' => $this->gen('earthquake insurance')],
            ['title' => 'Landlord Insurance: Rental Property Coverage Guide', 'keyword' => 'landlord insurance', 'bridge' => '🏘️ Protect your rental property investment...', 'meta_title' => 'Landlord Insurance - Rental Property Protection', 'meta_desc' => 'Learn about landlord insurance for rental properties. Understand liability, property damage, and loss of rental income coverage.', 'content' => $this->gen('landlord insurance')],
            ['title' => 'Home Warranty vs Insurance: Understanding the Difference', 'keyword' => 'home warranty', 'bridge' => '🔧 Home warranty covers systems and appliances...', 'meta_title' => 'Home Warranty vs Insurance - What\'s the Difference', 'meta_desc' => 'Understand the difference between home warranty and insurance. Learn what each covers and if you need both for complete protection.', 'content' => $this->gen('home warranty')],
            
            // MORE BUSINESS & SPECIALTY - CPC $30-50
            ['title' => 'Cyber Liability Insurance: Data Breach Protection', 'keyword' => 'cyber liability insurance', 'bridge' => '💻 Protect your business from data breaches and hacking...', 'meta_title' => 'Cyber Liability Insurance - Data Breach Coverage', 'meta_desc' => 'Learn about cyber liability insurance for businesses. Understand data breach coverage, costs, and why every company needs protection.', 'content' => $this->gen('cyber liability insurance')],
            ['title' => 'Professional Liability Insurance: E&O Coverage Explained', 'keyword' => 'professional liability insurance', 'bridge' => '⚖️ Protect against professional errors and malpractice claims...', 'meta_title' => 'Professional Liability Insurance - E&O Coverage', 'meta_desc' => 'Learn about professional liability and errors & omissions insurance. Understand coverage for professional service providers.', 'content' => $this->gen('professional liability insurance')],
            ['title' => 'Product Liability Insurance: Manufacturer Protection', 'keyword' => 'product liability insurance', 'bridge' => '📦 Protect your business from product-related claims...', 'meta_title' => 'Product Liability Insurance - Manufacturer Protection', 'meta_desc' => 'Learn about product liability insurance for manufacturers and sellers. Understand coverage for product defects and injury claims.', 'content' => $this->gen('product liability insurance')],
            ['title' => 'Key Person Insurance: Protecting Your Business', 'keyword' => 'key person insurance', 'bridge' => '👔 Protect your business from losing essential employees...', 'meta_title' => 'Key Person Insurance - Business Protection Guide', 'meta_desc' => 'Learn about key person insurance to protect your business. Understand coverage for losing essential employees and partners.', 'content' => $this->gen('key person insurance')],
            ['title' => 'Long Term Care Insurance: Planning for Future Care Needs', 'keyword' => 'long term care insurance', 'bridge' => '🏥 Prepare for potential nursing home and home care costs...', 'meta_title' => 'Long Term Care Insurance - Future Care Planning', 'meta_desc' => 'Learn about long term care insurance for nursing homes and assisted living. Understand costs, benefits, and planning for future care.', 'content' => $this->gen('long term care insurance')],
        ];
    }

    private function gen(string $keyword): string
    {
        $paragraphs = [
            "<p>Understanding <strong>{$keyword}</strong> is crucial for financial security in today's unpredictable world. Whether you're protecting your family, your assets, or your business, having the right insurance coverage provides peace of mind and financial protection when you need it most.</p>",
            "<h2>Why {$keyword} Matters</h2><p>Every year, thousands of people face unexpected situations that highlight the importance of proper insurance coverage. Without adequate protection, these events can lead to financial devastation. <strong>{$keyword}</strong> helps ensure you're prepared for whatever life brings.</p>",
            "<h2>Key Coverage Features</h2><p>When evaluating {$keyword} options, it's essential to understand what's covered and what's excluded. Most policies include protection for common risks, but reading the fine print helps avoid surprises when you need to file a claim. Coverage limits, deductibles, and exclusions vary significantly between insurers.</p>",
            "<h2>Cost Considerations</h2><p>The cost of {$keyword} depends on numerous factors including your personal circumstances, coverage amounts, and the insurer you choose. Shopping around and comparing quotes from multiple providers ensures you're getting the best value for your premium dollars. Don't sacrifice coverage quality just to save money.</p>",
            "<h2>How to Choose the Right Policy</h2><p>Selecting the best {$keyword} policy requires careful consideration of your specific needs and circumstances. Work with a licensed insurance professional who can explain your options and help you find coverage that fits your budget while providing adequate protection.</p>",
            "<h2>Common Mistakes to Avoid</h2><p>Many people make costly mistakes when purchasing {$keyword}. These include underinsuring, not reading policy details, failing to update coverage as circumstances change, and choosing the cheapest option without considering coverage quality. Avoid these pitfalls by educating yourself before purchasing.</p>",
            "<h2>Take Action Now</h2><p>Don't wait until it's too late to get proper {$keyword} coverage. The best time to secure protection is before you need it. Compare quotes from reputable insurers, understand your coverage options, and make an informed decision to protect yourself and your loved ones today.</p>",
        ];
        return implode('', $paragraphs);
    }
}
