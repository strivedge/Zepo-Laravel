<?php

namespace Custom\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * HelloWorld service provider
 */
class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__ . '/../Http/routes.php';
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'blog');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'blog');

        Event::listen('bagisto.admin.layout.head', function($viewRenderEventManager) 
        {
            $viewRenderEventManager->addTemplate('blog::layouts.style');
        });

        $this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
       );
    }
}