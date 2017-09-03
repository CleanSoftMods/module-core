<?php namespace CleanSoft\Modules\Core\Repositories;

use CleanSoft\Modules\Core\Repositories\Contracts\ViewTrackerRepositoryContract;
use CleanSoft\Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class ViewTrackerRepository extends EloquentBaseRepository implements ViewTrackerRepositoryContract
{
    /**
     * @param string $entityName
     * @param string $entityId
     * @return int
     */
    public function increase($entityName, $entityId)
    {
        $viewTracker = $this->findWhereOrCreate([
            'entity' => $entityName,
            'entity_id' => $entityId,
        ]);
        $this->update($viewTracker, [
            'count' => $viewTracker->count + 1
        ]);
        return $viewTracker->count + 1;
    }
}
