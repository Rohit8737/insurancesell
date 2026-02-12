<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // ========== GENERAL (6) ==========
            ['key' => 'site_name', 'value' => 'InsuranceSell', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Your Insurance Guide', 'group' => 'general'],
            ['key' => 'site_url', 'value' => 'https://insurancesell.com', 'group' => 'general'],
            ['key' => 'logo_path', 'value' => null, 'group' => 'general'],
            ['key' => 'favicon_path', 'value' => null, 'group' => 'general'],
            ['key' => 'homepage_mode', 'value' => 'redirect', 'group' => 'general'],
            
            // ========== UI TEXTS (4) ==========
            ['key' => 'scroll_text', 'value' => '⬇️ Watch Full Video - Scroll Down ⬇️', 'group' => 'ui'],
            ['key' => 'btn_text_hindi', 'value' => 'अगला वीडियो देखें', 'group' => 'ui'],
            ['key' => 'btn_text_english', 'value' => '▶ Next Video', 'group' => 'ui'],
            ['key' => 'default_bridge_text', 'value' => '💡 Discover why smart financial planning can change your life...', 'group' => 'ui'],
            
            // ========== AD SLOTS (8) ==========
            ['key' => 'ad_header', 'value' => null, 'group' => 'ads'],
            ['key' => 'ad_content_1', 'value' => null, 'group' => 'ads'],
            ['key' => 'ad_content_2', 'value' => null, 'group' => 'ads'],
            ['key' => 'ad_video_top', 'value' => null, 'group' => 'ads'],
            ['key' => 'ad_video_bottom', 'value' => null, 'group' => 'ads'],
            ['key' => 'ad_paragraph_1', 'value' => '2', 'group' => 'ads'],
            ['key' => 'ad_paragraph_2', 'value' => '4', 'group' => 'ads'],
            ['key' => 'ads_txt_content', 'value' => 'google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0', 'group' => 'ads'],
            
            // ========== SCRIPTS (4) ==========
            ['key' => 'header_scripts', 'value' => null, 'group' => 'scripts'],
            ['key' => 'footer_scripts', 'value' => null, 'group' => 'scripts'],
            ['key' => 'google_verification', 'value' => null, 'group' => 'scripts'],
            ['key' => 'bing_verification', 'value' => null, 'group' => 'scripts'],
            
            // ========== SOCIAL (4) ==========
            ['key' => 'social_facebook', 'value' => null, 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => null, 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => null, 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => null, 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
