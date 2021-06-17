<?php

namespace Rapidez\ExperiusPostcodeNL;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ExperiusPostcodeNLServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'experius-postcode-nl');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez/experius-postcode-nl'),
        ], 'views');
    }
}
