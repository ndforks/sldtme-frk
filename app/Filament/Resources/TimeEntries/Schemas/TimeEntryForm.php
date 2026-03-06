<?php

namespace App\Filament\Resources\TimeEntries\Schemas;

use App\Models\Member;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class TimeEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id')
                    ->label('ID')
                    ->readOnly()
                    ->disabled(),
                TextInput::make('description')
                    ->label('Description')
                    ->required()
                    ->maxLength(255),
                Toggle::make('billable')
                    ->label('Is Billable?')
                    ->required(),
                DateTimePicker::make('start')
                    ->label('Start')
                    ->required(),
                DateTimePicker::make('end')
                    ->label('End')
                    ->nullable()
                    ->rules([
                        'after_or_equal:start',
                    ]),
                Select::make('member_id')
                    ->relationship(
                        name: 'member',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn (Builder $query) => $query->with(['user', 'organization'])
                    )
                    ->getOptionLabelFromRecordUsing(fn (Member $record): string => $record->user->email . ' (' . $record->organization->name . ')')
                    ->searchable()
                    ->required(),
                Select::make('project_id')
                    ->relationship(name: 'project', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->nullable(),
                Select::make('task_id')
                    ->relationship(name: 'task', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->nullable(),
            ]);
    }
}
