<?php namespace CleanSoft\Modules\Core\Repositories;

use CleanSoft\Modules\Core\Models\Contracts\ViewTrackerModelContract;
use CleanSoft\Modules\Core\Repositories\Contracts\ViewTrackerRepositoryContract;
use CleanSoft\Modules\Core\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

class ViewTrackerRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements ViewTrackerRepositoryContract
{
    /**
     * @param ViewTrackerModelContract $viewTracker
     * @return array
     */
    public function increase(ViewTrackerModelContract $viewTracker)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
