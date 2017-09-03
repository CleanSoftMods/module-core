<?php namespace CleanSoft\Modules\Core\Providers;

use CleanSoft\Modules\Core\Models\ViewTracker;
use CleanSoft\Modules\Core\Repositories\Contracts\ViewTrackerRepositoryContract;
use CleanSoft\Modules\Core\Repositories\ViewTrackerRepository;
use CleanSoft\Modules\Core\Repositories\ViewTrackerRepositoryCacheDecorator;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ViewTrackerRepositoryContract::class, function () {
            $repository = new ViewTrackerRepository(new ViewTracker());
            if (config('webed-caching.repository.enabled')) {
                return new ViewTrackerRepositoryCacheDecorator($repository);
            }
            return $repository;
        });
    }
}
