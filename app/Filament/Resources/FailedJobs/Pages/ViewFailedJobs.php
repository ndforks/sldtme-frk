<?php

declare(strict_types=1);

namespace App\Filament\Resources\FailedJobs\Pages;

use App\Filament\Resources\FailedJobs\FailedJobResource;
use Filament\Resources\Pages\ViewRecord;

class ViewFailedJobs extends ViewRecord
{
    protected static string $resource = FailedJobResource::class;
}
