<?php namespace WebEd\Base\Core\Models;

use WebEd\Base\Core\Models\Contracts\ViewTrackerModelContract;
use WebEd\Base\Core\Models\EloquentBase as BaseModel;

class ViewTracker extends BaseModel implements ViewTrackerModelContract
{
    public $timestamps = false;
    protected $table = 'view_trackers';
    protected $primaryKey = 'id';
    protected $fillable = ['entity', 'entity_id', 'count'];

    /**
     * Count getter
     * @param $value
     * @return int
     */
    public function getCountAttribute($value)
    {
        return (int)$value;
    }
}
