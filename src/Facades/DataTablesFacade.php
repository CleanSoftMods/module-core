<?php namespace CleanSoft\Modules\Core\Facades;

use CleanSoft\Modules\Core\Support\DataTable\DataTables;
use Illuminate\Support\Facades\Facade;

class DataTablesFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return DataTables::class;
    }
}
