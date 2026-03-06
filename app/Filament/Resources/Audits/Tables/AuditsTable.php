<?php

namespace App\Filament\Resources\Audits\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuditsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('event'),
                TextColumn::make('auditable_type'),
                TextColumn::make('auditable_id'),
                IconColumn::make('was_command')
                    ->getStateUsing(fn (Audit $record) => Str::startsWith($record->url, 'artisan '))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
            ])
            ->defaultSort('created_at', 'desc');
    }
}
