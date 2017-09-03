<?php namespace CleanSoft\Modules\Core\Criterias;

use CleanSoft\Modules\Core\Models\Contracts\BaseModelContract;
use CleanSoft\Modules\Core\Repositories\Contracts\AbstractRepositoryContract;

abstract class AbstractCriteria
{
    /**
     * @param BaseModelContract $model
     * @param AbstractRepositoryContract $repository
     * @return mixed
     */
    abstract public function apply($model, AbstractRepositoryContract $repository);
}
