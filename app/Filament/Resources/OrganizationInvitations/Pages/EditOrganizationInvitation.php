<?php

namespace App\Filament\Resources\OrganizationInvitations\Pages;

use App\Filament\Resources\OrganizationInvitations\OrganizationInvitationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationInvitation extends EditRecord
{
    protected static string $resource = OrganizationInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
