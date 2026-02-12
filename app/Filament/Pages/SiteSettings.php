<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $title = 'Site Settings';

    protected static ?int $navigationSort = 11;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected string $view = 'filament.pages.site-settings';

    public array $general = [];
    public array $ui = [];
    public array $social = [];
    public array $scripts = [];
    public array $ads = [];

    public function mount(): void
    {
        $this->general = [
            'site_name' => Setting::get('site_name', 'InsuranceSell'),
            'site_description' => Setting::get('site_description', 'Your Insurance Guide'),
            'site_url' => Setting::get('site_url', 'https://insurancesell.com'),
            'logo_path' => Setting::get('logo_path'),
            'favicon_path' => Setting::get('favicon_path'),
            'homepage_mode' => Setting::get('homepage_mode', 'redirect'),
            // Author Box Settings
            'author_name' => Setting::get('author_name', 'Insurance Expert'),
            'author_bio' => Setting::get('author_bio', 'Certified financial advisor with 10+ years of experience in insurance planning.'),
            'author_avatar' => Setting::get('author_avatar', '👨‍💼'),
        ];
        
        $this->ui = [
            'scroll_text' => Setting::get('scroll_text', '⬇️ Watch Full Video - Scroll Down ⬇️'),
            'btn_text_hindi' => Setting::get('btn_text_hindi', 'अगला वीडियो देखें'),
            'btn_text_english' => Setting::get('btn_text_english', '▶ Next Video'),
            'default_bridge_text' => Setting::get('default_bridge_text', '💡 Discover why smart financial planning...'),
            'ad_paragraph_1' => Setting::get('ad_paragraph_1', '2'),
            'ad_paragraph_2' => Setting::get('ad_paragraph_2', '4'),
        ];
        
        $this->social = [
            'social_facebook' => Setting::get('social_facebook'),
            'social_instagram' => Setting::get('social_instagram'),
            'social_twitter' => Setting::get('social_twitter'),
            'social_youtube' => Setting::get('social_youtube'),
        ];
        
        $this->scripts = [
            'header_scripts' => Setting::get('header_scripts'),
            'footer_scripts' => Setting::get('footer_scripts'),
            'google_verification' => Setting::get('google_verification'),
            'bing_verification' => Setting::get('bing_verification'),
        ];
        
        $this->ads = [
            'sticky_ad_enabled' => Setting::get('sticky_ad_enabled', 'true'),
            'sticky_ad_code' => Setting::get('sticky_ad_code', ''),
            'sticky_banner_text' => Setting::get('sticky_banner_text', '✨ Get the best insurance quotes today!'),
            // Ad Slot 1-4 Settings
            'ad_slot_1_enabled' => Setting::get('ad_slot_1_enabled', 'true'),
            'ad_slot_1_code' => Setting::get('ad_slot_1_code', ''),
            'ad_slot_2_enabled' => Setting::get('ad_slot_2_enabled', 'true'),
            'ad_slot_2_code' => Setting::get('ad_slot_2_code', ''),
            'ad_slot_3_enabled' => Setting::get('ad_slot_3_enabled', 'true'),
            'ad_slot_3_code' => Setting::get('ad_slot_3_code', ''),
            'ad_slot_4_enabled' => Setting::get('ad_slot_4_enabled', 'true'),
            'ad_slot_4_code' => Setting::get('ad_slot_4_code', ''),
            // Content Ads (between paragraphs)
            'ad_content_1_enabled' => Setting::get('ad_content_1_enabled', 'true'),
            'ad_content_1_code' => Setting::get('ad_content_1_code', ''),
            'ad_content_2_enabled' => Setting::get('ad_content_2_enabled', 'true'),
            'ad_content_2_code' => Setting::get('ad_content_2_code', ''),
        ];
    }

    public function save(): void
    {
        foreach ($this->general as $key => $value) {
            Setting::set($key, $value, 'general');
        }
        
        foreach ($this->ui as $key => $value) {
            Setting::set($key, $value, 'ui');
        }
        
        foreach ($this->social as $key => $value) {
            Setting::set($key, $value, 'social');
        }
        
        foreach ($this->scripts as $key => $value) {
            Setting::set($key, $value, 'scripts');
        }
        
        foreach ($this->ads as $key => $value) {
            Setting::set($key, $value, 'ads');
        }
        
        Notification::make()
            ->title('Settings saved successfully!')
            ->success()
            ->send();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->schema($this->getFormSchema());
    }

    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Settings')
                ->tabs([
                    Tab::make('General')
                        ->icon(Heroicon::OutlinedCog6Tooth)
                        ->schema([
                            TextInput::make('general.site_name')
                                ->label('Site Name')
                                ->required(),
                            
                            TextInput::make('general.site_description')
                                ->label('Site Description'),
                            
                            TextInput::make('general.site_url')
                                ->label('Site URL')
                                ->url(),
                            
                            Select::make('general.homepage_mode')
                                ->label('Homepage Mode')
                                ->options([
                                    'redirect' => 'Redirect to First Post',
                                    'listing' => 'Show Posts Listing',
                                ])
                                ->default('redirect'),
                            
                            Section::make('Author Box Settings')
                                ->schema([
                                    TextInput::make('general.author_name')
                                        ->label('Author Name')
                                        ->default('Insurance Expert'),
                                    
                                    Textarea::make('general.author_bio')
                                        ->label('Author Bio')
                                        ->rows(2)
                                        ->default('Certified financial advisor with 10+ years of experience.'),
                                    
                                    TextInput::make('general.author_avatar')
                                        ->label('Author Avatar (Emoji)')
                                        ->default('👨‍💼')
                                        ->helperText('Use an emoji like 👨‍💼, 👩‍💼, 🧑‍💼'),
                                ])->columns(1),
                        ]),
                    
                    Tab::make('UI Texts')
                        ->icon(Heroicon::OutlinedChatBubbleBottomCenter)
                        ->schema([
                            TextInput::make('ui.scroll_text')
                                ->label('Scroll Indicator Text'),
                            
                            TextInput::make('ui.btn_text_hindi')
                                ->label('Next Button Text (Hindi)'),
                            
                            TextInput::make('ui.btn_text_english')
                                ->label('Next Button Text (English)'),
                            
                            Textarea::make('ui.default_bridge_text')
                                ->label('Default Bridge Text')
                                ->rows(3),
                            
                            TextInput::make('ui.ad_paragraph_1')
                                ->label('Content Ad 1 After Paragraph #')
                                ->numeric()
                                ->default(2),
                            
                            TextInput::make('ui.ad_paragraph_2')
                                ->label('Content Ad 2 After Paragraph #')
                                ->numeric()
                                ->default(4),
                        ]),
                    
                    Tab::make('Social Links')
                        ->icon(Heroicon::OutlinedShare)
                        ->schema([
                            TextInput::make('social.social_facebook')
                                ->label('Facebook URL')
                                ->url(),
                            
                            TextInput::make('social.social_instagram')
                                ->label('Instagram URL')
                                ->url(),
                            
                            TextInput::make('social.social_twitter')
                                ->label('Twitter/X URL')
                                ->url(),
                            
                            TextInput::make('social.social_youtube')
                                ->label('YouTube URL')
                                ->url(),
                        ]),
                    
                    Tab::make('Scripts')
                        ->icon(Heroicon::OutlinedCodeBracket)
                        ->schema([
                            Textarea::make('scripts.header_scripts')
                                ->label('Header Scripts')
                                ->rows(5),
                            
                            Textarea::make('scripts.footer_scripts')
                                ->label('Footer Scripts')
                                ->rows(5),
                            
                            TextInput::make('scripts.google_verification')
                                ->label('Google Site Verification'),
                            
                            TextInput::make('scripts.bing_verification')
                                ->label('Bing Site Verification'),
                        ]),
                    
                    Tab::make('Sticky Ads')
                        ->icon(Heroicon::OutlinedCurrencyDollar)
                        ->schema([
                            Select::make('ads.sticky_ad_enabled')
                                ->label('Sticky Footer Ad')
                                ->options([
                                    'true' => 'Enabled',
                                    'false' => 'Disabled',
                                ])
                                ->default('true')
                                ->helperText('Shows at bottom of all pages with close button'),
                            
                            Textarea::make('ads.sticky_ad_code')
                                ->label('Sticky Ad Code (HTML/AdSense)')
                                ->rows(4)
                                ->helperText('Paste your AdSense or custom ad HTML code here'),
                            
                            TextInput::make('ads.sticky_banner_text')
                                ->label('Default Banner Text')
                                ->helperText('Shown when no ad code is configured'),
                        ]),
                    
                    Tab::make('Ad Slots')
                        ->icon(Heroicon::OutlinedSquares2x2)
                        ->schema([
                            Section::make('Ad Slot 1 - Top of Page (Before Image)')
                                ->schema([
                                    Select::make('ads.ad_slot_1_enabled')
                                        ->label('Enable Slot 1')
                                        ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                                        ->default('true'),
                                    Textarea::make('ads.ad_slot_1_code')
                                        ->label('Ad Code')
                                        ->rows(3),
                                ])->columns(1),
                            
                            Section::make('Ad Slot 2 - After Featured Image')
                                ->schema([
                                    Select::make('ads.ad_slot_2_enabled')
                                        ->label('Enable Slot 2')
                                        ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                                        ->default('true'),
                                    Textarea::make('ads.ad_slot_2_code')
                                        ->label('Ad Code')
                                        ->rows(3),
                                ])->columns(1),
                            
                            Section::make('Ad Slot 3 - Before Video')
                                ->schema([
                                    Select::make('ads.ad_slot_3_enabled')
                                        ->label('Enable Slot 3')
                                        ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                                        ->default('true'),
                                    Textarea::make('ads.ad_slot_3_code')
                                        ->label('Ad Code')
                                        ->rows(3),
                                ])->columns(1),
                            
                            Section::make('Ad Slot 4 - After Video/Next Button')
                                ->schema([
                                    Select::make('ads.ad_slot_4_enabled')
                                        ->label('Enable Slot 4')
                                        ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                                        ->default('true'),
                                    Textarea::make('ads.ad_slot_4_code')
                                        ->label('Ad Code')
                                        ->rows(3),
                                ])->columns(1),
                            
                            Section::make('Content Ad 1 - Inside Article (Pink)')
                                ->description('Appears after paragraph #' . Setting::get('ad_paragraph_1', '2'))
                                ->schema([
                                    Select::make('ads.ad_content_1_enabled')
                                        ->label('Enable Content Ad 1')
                                        ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                                        ->default('true'),
                                    Textarea::make('ads.ad_content_1_code')
                                        ->label('Ad Code')
                                        ->rows(3),
                                ])->columns(1),
                            
                            Section::make('Content Ad 2 - Inside Article (Blue)')
                                ->description('Appears after paragraph #' . Setting::get('ad_paragraph_2', '4'))
                                ->schema([
                                    Select::make('ads.ad_content_2_enabled')
                                        ->label('Enable Content Ad 2')
                                        ->options(['true' => 'Enabled', 'false' => 'Disabled'])
                                        ->default('true'),
                                    Textarea::make('ads.ad_content_2_code')
                                        ->label('Ad Code')
                                        ->rows(3),
                                ])->columns(1),
                        ]),
                ]),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->action('save')
                ->icon(Heroicon::OutlinedCheck),
        ];
    }
}
