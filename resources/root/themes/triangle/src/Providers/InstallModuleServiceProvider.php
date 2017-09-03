<?php namespace WebEd\Themes\Triangle\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Themes\Triangle';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    protected function booted()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
