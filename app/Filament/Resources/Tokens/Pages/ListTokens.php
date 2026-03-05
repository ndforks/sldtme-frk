<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tokens\Pages;

use App\Filament\Resources\Tokens\TokenResource;
use Filament\Resources\Pages\ListRecords;

class ListTokens extends ListRecords
{
    protected static string $resource = TokenResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
