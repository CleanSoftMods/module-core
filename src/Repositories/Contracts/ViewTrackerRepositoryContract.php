<?php namespace CleanSoft\Modules\Core\Repositories\Contracts;
interface ViewTrackerRepositoryContract extends AbstractRepositoryContract
{
    /**
     * @param string $entityName
     * @param string $entityId
     * @return int
     */
    public function increase($entityName, $entityId);
}
