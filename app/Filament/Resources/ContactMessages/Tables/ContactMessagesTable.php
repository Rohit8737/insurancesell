<?php

namespace App\Filament\Resources\ContactMessages\Tables;

use App\Models\ContactMessage;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ContactMessagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon(Heroicon::OutlinedEnvelope)
                    ->copyable()
                    ->copyMessage('Email copied!'),

                TextColumn::make('subject')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->subject),

                IconColumn::make('is_read')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedEnvelope)
                    ->trueColor('success')
                    ->falseColor('warning'),

                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_read')
                    ->label('Status')
                    ->options([
                        '0' => 'Unread',
                        '1' => 'Read',
                    ]),
            ])
            ->recordActions([
                // View Action with message content
                Action::make('view')
                    ->icon(Heroicon::OutlinedEye)
                    ->color('gray')
                    ->modalHeading(fn ($record) => "Message from {$record->name}")
                    ->modalContent(fn ($record) => view('filament.contact-message-view', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),

                // Mark as Read Action
                Action::make('markAsRead')
                    ->icon(Heroicon::OutlinedCheck)
                    ->color('success')
                    ->visible(fn ($record) => !$record->is_read)
                    ->action(function ($record) {
                        $record->update(['is_read' => true]);
                        Notification::make()
                            ->title('Marked as read')
                            ->success()
                            ->send();
                    }),

                // Reply via Email
                Action::make('reply')
                    ->icon(Heroicon::OutlinedEnvelopeOpen)
                    ->color('primary')
                    ->url(fn ($record) => "mailto:{$record->email}?subject=Re: {$record->subject}")
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // Bulk Mark as Read
                    BulkAction::make('markAsRead')
                        ->label('Mark as Read')
                        ->icon(Heroicon::OutlinedCheckCircle)
                        ->action(function (Collection $records) {
                            $records->each->update(['is_read' => true]);
                            Notification::make()
                                ->title("{$records->count()} messages marked as read")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    // Bulk Mark as Unread
                    BulkAction::make('markAsUnread')
                        ->label('Mark as Unread')
                        ->icon(Heroicon::OutlinedEnvelope)
                        ->action(function (Collection $records) {
                            $records->each->update(['is_read' => false]);
                            Notification::make()
                                ->title("{$records->count()} messages marked as unread")
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),

                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
