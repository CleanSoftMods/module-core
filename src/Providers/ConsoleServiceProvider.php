<?php namespace CleanSoft\Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \CleanSoft\Modules\Core\Console\Commands\InstallCmsCommand::class,
            \CleanSoft\Modules\Core\Console\Commands\UpdateCmsCommand::class,
        ]);
    }
}
