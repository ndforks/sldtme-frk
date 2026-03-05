<?php

declare(strict_types=1);

namespace App\Filament\Resources\OrganizationInvitations\Pages;

use App\Filament\Resources\OrganizationInvitations\OrganizationInvitationResource;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationInvitations extends ListRecords
{
    protected static string $resource = OrganizationInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
