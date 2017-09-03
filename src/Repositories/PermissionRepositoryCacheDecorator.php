<?php namespace CleanSoft\Modules\Core\Repositories;

use CleanSoft\Modules\Core\Repositories\Contracts\PermissionRepositoryContract;
use CleanSoft\Modules\Core\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;

class PermissionRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements PermissionRepositoryContract
{
    /**
     * @param string $name
     * @param string $alias
     * @param string $module
     * @return $this
     */
    public function registerPermission($name, $alias, $module)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param string|array $alias
     * @return $this
     */
    public function unsetPermission($alias, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param string|array $module
     * @param bool $force
     * @return $this
     */
    public function unsetPermissionByModule($module, $force = false)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }
}
