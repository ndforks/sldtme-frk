<?php

use Nwidart\Modules\LaravelModulesServiceProvider;

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Providers\RouteServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    // Warning: Do not add TelescopeServiceProvider here since it is already conditionally registered in AppServiceProvider
    LaravelModulesServiceProvider::class,
];
