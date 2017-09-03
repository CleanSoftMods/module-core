<?php namespace WebEd\Base\Core\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
{
    protected $module = 'WebEd\Base\Core';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    private function booted()
    {
        acl_permission()
            ->registerPermission('Access to dashboard', 'access-dashboard', $this->module)
            ->registerPermission('System commands', 'use-system-commands', $this->module);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
