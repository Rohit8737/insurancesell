<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class AdSenseManager extends Page implements HasForms
{
    use InteractsWithForms;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $navigationLabel = 'AdSense Manager';

    protected static ?string $title = 'AdSense Manager';

    protected static ?int $navigationSort = 10;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected string $view = 'filament.pages.ad-sense-manager';

    public string $adsensePublisherId = '';
    public string $adsTxtContent = '';

    public function mount(): void
    {
        $this->adsensePublisherId = Setting::get('adsense_publisher_id', '');
        $this->adsTxtContent = Setting::get('ads_txt_content', 'google.com, pub-XXXXXXXXXXXXXXXX, DIRECT, f08c47fec0942fa0');
    }

    public function save(): void
    {
        Setting::set('adsense_publisher_id', $this->adsensePublisherId, 'ads');
        Setting::set('ads_txt_content', $this->adsTxtContent, 'ads');
        
        Notification::make()
            ->title('AdSense settings saved!')
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
            Section::make('Google AdSense Configuration')
                ->description('Enter your AdSense publisher ID. This auto-generates the script tag in your website\'s <head>.')
                ->schema([
                    TextInput::make('adsensePublisherId')
                        ->label('AdSense Publisher ID')
                        ->placeholder('ca-pub-1234567890123456')
                        ->helperText('Find this in your AdSense dashboard. Format: ca-pub-XXXXXXXXXXXXXXXX'),
                ]),
            
            Section::make('ads.txt Configuration')
                ->description('This content is served at /ads.txt — required for AdSense verification.')
                ->schema([
                    Textarea::make('adsTxtContent')
                        ->label('ads.txt Content')
                        ->rows(6)
                        ->helperText('Replace pub-XXXXXXXXXXXXXXXX with your actual publisher ID'),
                ]),

            Section::make('Ad Slot Management')
                ->description('📌 All ad slot codes are managed in **Site Settings → Ad Slots** tab. Go there to paste your AdSense ad unit codes for each position.')
                ->schema([]),
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
