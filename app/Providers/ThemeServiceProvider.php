<?php

namespace App\Providers;

use Roots\Acorn\Sage\SageServiceProvider;
use App\View\Composers\Navigation;
use App\View\Composers\SingleMaterial;
use App\View\Components\Dropzone;
use App\View\Composers\Contact;

class ThemeServiceProvider extends SageServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        // Register your custom view composers
        $this->app->bind('App\\View\\Composers\\HeaderTemplateComposer', function () {
            return new \App\View\Composers\HeaderTemplateComposer();
        });

        $this->app->singleton(RoleServiceProvider::class, function ($app) {
            return new RoleServiceProvider($app);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->app->make(RoleServiceProvider::class)->boot();

        $this->app->singleton('sage.view.composers', function () {
            return [
                \App\View\Composers\App::class,
                \App\View\Composers\Post::class,
                Navigation::class,
                SingleMaterial::class,
                Contact::class, 
            ];
        });

        // Register the Dropzone component
        $this->app['blade.compiler']->component('dropzone', Dropzone::class);
    }
}