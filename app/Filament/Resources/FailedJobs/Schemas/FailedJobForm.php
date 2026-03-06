<?php

namespace App\Filament\Resources\FailedJobs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Novadaemon\FilamentPrettyJson\Form\PrettyJsonField;

class FailedJobForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')->disabled()->columnSpan(4),
                TextInput::make('failed_at')->disabled(),
                TextInput::make('id')->disabled(),
                TextInput::make('connection')->disabled(),
                TextInput::make('queue')->disabled(),

                // make text a little bit smaller because often a complete Stack Trace is shown:
                TextArea::make('exception')->disabled()->columnSpan(4)->extraInputAttributes(['style' => 'font-size: 80%;']),
                PrettyJsonField::make('payload')->disabled()->columnSpan(4),
            ])->columns(4);
    }
}
