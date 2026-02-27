<?php

namespace Uspdev\SenhaUnicaPixelfed;

use Illuminate\Support\ServiceProvider;

class SenhaUnicaPixelfedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'senhaunicapixelfed');
    }

    public function register()
    {
        //
    }
}
