<?php

namespace Rapidez\PostcodeNL;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PostcodeNLServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'postcode-nl');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rapidez/postcode-nl'),
        ], 'views');
    }
}
