<?php namespace CleanSoft\Modules\Core\Http\Controllers;

use CleanSoft\Modules\Core\Http\DataTables\PermissionsListDataTable;
use CleanSoft\Modules\Core\Repositories\Contracts\PermissionRepositoryContract;
use Illuminate\Http\Request;

class PermissionController extends BaseAdminController
{
    protected $module = 'webed-acl';

    /**
     * @var \CleanSoft\Modules\Core\Repositories\PermissionRepository
     */
    protected $repository;

    public function __construct(PermissionRepositoryContract $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module . '-permissions');
            $this->breadcrumbs
                ->addLink(trans($this->module . '::base.acl'))
                ->addLink(trans($this->module . '::base.permissions'), route('admin::acl-permissions.index.get'));
            return $next($request);
        });
    }

    public function getIndex(PermissionsListDataTable $permissionsListDataTable)
    {
        $this->setPageTitle(trans($this->module . '::base.permissions'));
        $this->dis['dataTable'] = $permissionsListDataTable->run();
        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_ACL_PERMISSION, 'index.get')->viewAdmin('permissions.index');
    }

    public function postListing(PermissionsListDataTable $permissionsListDataTable)
    {
        return do_filter(BASE_FILTER_CONTROLLER, $permissionsListDataTable, WEBED_ACL_PERMISSION, 'index.post', $this);
    }
}
