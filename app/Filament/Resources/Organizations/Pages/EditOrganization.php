<?php

declare(strict_types=1);

namespace App\Filament\Resources\Organizations\Pages;

use App\Filament\Resources\Organizations\Actions\DeleteOrganization;
use App\Filament\Resources\Organizations\OrganizationResource;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteOrganization::make(),
        ];
    }
}
