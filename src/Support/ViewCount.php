<?php namespace CleanSoft\Modules\Core\Support;

use CleanSoft\Modules\Core\Repositories\Contracts\ViewTrackerRepositoryContract;
use CleanSoft\Modules\Core\Repositories\ViewTrackerRepository;

class ViewCount
{
    /**
     * @var ViewTrackerRepositoryContract|ViewTrackerRepository
     */
    protected $repository;

    /**
     * ViewCount constructor.
     * @param ViewTrackerRepository $repository
     */
    public function __construct(ViewTrackerRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $entityName
     * @param $entityId
     * @return int
     */
    public function increase($entityName, $entityId)
    {
        return $this->repository->increase($entityName, $entityId);
    }
}
