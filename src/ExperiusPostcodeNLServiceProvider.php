<?php

namespace Rapidez\ExperiusPostcodeNL;

use Illuminate\Support\ServiceProvider;

class ExperiusPostcodeNLServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'experius-postcode-nl');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/experius-postcode-nl'),
        ], 'views');
    }
}
