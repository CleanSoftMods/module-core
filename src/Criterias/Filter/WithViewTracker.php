<?php namespace CleanSoft\Modules\Core\Criterias\Filter;

use CleanSoft\Modules\Core\Criterias\AbstractCriteria;
use CleanSoft\Modules\Core\Models\Contracts\BaseModelContract;
use CleanSoft\Modules\Core\Models\EloquentBase;
use CleanSoft\Modules\Core\Repositories\Contracts\AbstractRepositoryContract;
use Illuminate\Database\Eloquent\Builder;

class WithViewTracker extends AbstractCriteria
{
    /**
     * @var BaseModelContract
     */
    protected $relatedModel;

    /**
     * @var string
     */
    protected $screenName;

    public function __construct(BaseModelContract $relatedModel, $screenName)
    {
        $this->relatedModel = $relatedModel;
        $this->screenName = $screenName;
    }

    /**
     * @param EloquentBase|Builder $model
     * @param AbstractRepositoryContract $repository
     * @return mixed
     */
    public function apply($model, AbstractRepositoryContract $repository)
    {
        return $model
            ->leftJoin(webed_db_prefix() . 'view_trackers', $this->relatedModel->getTable() . '.' . $this->relatedModel->getPrimaryKey(), '=', webed_db_prefix() . 'view_trackers.entity_id')
            ->where(webed_db_prefix() . 'view_trackers.entity', '=', $this->screenName);
    }
}
