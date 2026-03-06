<?php

namespace App\Filament\Resources\ProjectMembers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('billable_rate')
                    ->label('Billable rate (in Cents)')
                    ->nullable()
                    ->rules([
                        'nullable',
                        'integer',
                        'gt:0',
                        'max:2147483647',
                    ])
                    ->numeric(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('member_id')
                    ->relationship('member', 'id')
                    ->required(),
            ]);
    }
}
