<?php

namespace App\Providers;

use App\Theory\FretboardComponent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Streams\Ui\Support\Facades\UI;

/**
 * Class AppServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Additional service providers.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * Register any application services.
     */
    public function register()
    {
        /**
         * Register additional service
         * providers if they exist.
         */
        foreach ($this->providers as $provider) {
            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        UI::register('fretboard', FretboardComponent::class);
    }
}
