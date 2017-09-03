<?php namespace CleanSoft\Modules\Core\Models\Contracts;
interface RoleModelContract
{
    /**
     * @return mixed
     */
    public function permissions();

    /**
     * @return mixed
     */
    public function users();
}
