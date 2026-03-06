<?php

namespace App\Filament\Resources\Users\Tables;

use App\Exceptions\Api\ApiException;
use App\Models\User;
use App\Service\DeletionService;
use Exception;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_real_user')
                    ->getStateUsing(fn (User $record): bool => ! $record->is_placeholder)
                    ->label('Real user?')
                    ->boolean(),
                IconColumn::make('email_verified')
                    ->getStateUsing(fn (User $record): bool => $record->email_verified_at !== null)
                    ->label('Email verified?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('real_user')
                    ->queries(
                        true: function (Builder $query): Builder {
                            /* @var Builder<User> $query */
                            return $query->where('is_placeholder', '=', false);
                        },
                        false: function (Builder $query): Builder {
                            /* @var Builder<User> $query */
                            return $query->where('is_placeholder', '=', true);
                        },
                        blank: function (Builder $query): Builder {
                            /* @var Builder<User> $query */
                            return $query;
                        },
                    )
                    ->label('Real User?'),
                TernaryFilter::make('email_verified')
                    ->label('Email Verified?')
                    ->attribute('email_verified_at')
                    ->nullable(),
            ])
            ->recordActions([
                ActionGroup::make([
                    Impersonate::make()->before(function (User $record): void {
                        if ($record->currentTeam === null) {
                            $organization = $record->organizations()->where('personal_team', '=', true)->first();
                            if ($organization === null) {
                                $organization = $record->organizations()->first();
                            }
                            if ($organization === null) {
                                throw new Exception('User has no organization');
                            }
                            $record->currentTeam()->associate($organization);
                            $record->save();
                        }
                    }),
                    EditAction::make(),
                    DeleteAction::make()
                        ->hidden(fn (User $record) => $record->is(Auth::user()))
                        ->using(function (User $record): void {
                            try {
                                app(DeletionService::class)->deleteUser($record);
                            } catch (ApiException $exception) {
                                Notification::make()
                                    ->danger()
                                    ->title('Delete failed')
                                    ->body($exception->getTranslatedMessage())
                                    ->persistent()
                                    ->send();
                            }
                        }),
                ]),
            ])
            ->toolbarActions([
                BulkAction::make('Resend verification email')
                    ->icon('heroicon-o-paper-airplane')
                    ->action(function (Collection $records): void {
                        foreach ($records as $user) {
                            /* @var User $user */
                            $user->sendEmailVerificationNotification();
                        }
                    }),
            ]);
    }
}
