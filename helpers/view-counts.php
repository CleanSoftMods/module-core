<?php
if (!function_exists('view_count')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\ViewCount
     */
    function view_count()
    {
        return \CleanSoft\Modules\Core\Facades\ViewCountFacade::getFacadeRoot();
    }
}
if (!function_exists('increase_view_count')) {
    /**
     * @param $entity
     * @param $entityId
     * @return int
     */
    function increase_view_count($entity, $entityId)
    {
        return view_count()->increase($entity, $entityId);
    }
}
