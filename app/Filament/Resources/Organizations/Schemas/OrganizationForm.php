<?php

namespace App\Filament\Resources\Organizations\Schemas;

use App\Enums\CurrencyFormat;
use App\Enums\DateFormat;
use App\Enums\IntervalFormat;
use App\Enums\NumberFormat;
use App\Enums\TimeFormat;
use Brick\Money\ISOCurrencyProvider;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OrganizationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                Toggle::make('personal_team')
                    ->label('Is personal?')
                    ->hiddenOn(['create'])
                    ->required(),
                Select::make('user_id')
                    ->label('Owner')
                    ->relationship(name: 'owner', titleAttribute: 'email')
                    ->searchable(['name', 'email'])
                    ->disabledOn(['edit'])
                    ->required(),
                Select::make('date_format')
                    ->options(DateFormat::toSelectArray())
                    ->required(),
                Select::make('currency_format')
                    ->options(CurrencyFormat::toSelectArray())
                    ->required(),
                Select::make('interval_format')
                    ->options(IntervalFormat::toSelectArray())
                    ->required(),
                Select::make('number_format')
                    ->options(NumberFormat::toSelectArray())
                    ->required(),
                Select::make('time_format')
                    ->options(TimeFormat::toSelectArray())
                    ->required(),
                Select::make('currency')
                    ->label('Currency')
                    ->options(function (): array {
                        $currencies = ISOCurrencyProvider::getInstance()->getAvailableCurrencies();
                        $select     = [];
                        foreach ($currencies as $currency) {
                            $select[$currency->getCurrencyCode()] = $currency->getName() . ' (' . $currency->getCurrencyCode() . ')';
                        }

                        return $select;
                    })
                    ->required()
                    ->searchable(),
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
                DateTimePicker::make('created_at')
                    ->label('Created At')
                    ->hiddenOn(['create'])
                    ->disabled(),
                DateTimePicker::make('updated_at')
                    ->label('Updated At')
                    ->hiddenOn(['create'])
                    ->disabled(),
            ]);
    }
}
