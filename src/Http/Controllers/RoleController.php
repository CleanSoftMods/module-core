<?php namespace WebEd\Base\ACL\Http\Controllers;

use Illuminate\Http\Request;
use WebEd\Base\ACL\Actions\CreateRoleAction;
use WebEd\Base\ACL\Actions\DeleteRoleAction;
use WebEd\Base\ACL\Actions\UpdateRoleAction;
use WebEd\Base\ACL\Http\DataTables\RolesListDataTable;
use WebEd\Base\ACL\Http\Requests\CreateRoleRequest;
use WebEd\Base\ACL\Http\Requests\UpdateRoleRequest;
use WebEd\Base\Http\Controllers\BaseAdminController;
use WebEd\Base\ACL\Repositories\Contracts\RoleRepositoryContract;
use WebEd\Base\ACL\Repositories\Contracts\PermissionRepositoryContract;
use Yajra\Datatables\Engines\BaseEngine;

class RoleController extends BaseAdminController
{
    protected $module = 'webed-acl';

    /**
     * @var \WebEd\Base\ACL\Repositories\RoleRepository
     */
    protected $repository;

    public function __construct(RoleRepositoryContract $roleRepository)
    {
        parent::__construct();

        $this->repository = $roleRepository;

        $this->middleware(function (Request $request, $next) {
            $this->getDashboardMenu($this->module . '-roles');

            $this->breadcrumbs
                ->addLink(trans($this->module . '::base.acl'))
                ->addLink(trans($this->module . '::base.roles'), route('admin::acl-roles.index.get'));

            return $next($request);
        });
    }

    /**
     * Get index page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(RolesListDataTable $rolesListDataTable)
    {
        $this->setPageTitle(trans($this->module . '::base.roles'));

        $this->dis['dataTable'] = $rolesListDataTable->run();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_ACL_ROLE, 'index.get', $rolesListDataTable)->viewAdmin('roles.index');
    }

    /**
     * Get all roles
     * @param RolesListDataTable|BaseEngine $rolesListDataTable
     * @return \Illuminate\Http\JsonResponse
     */
    public function postListing(RolesListDataTable $rolesListDataTable)
    {
        $data = $rolesListDataTable->with($this->groupAction());

        return do_filter(BASE_FILTER_CONTROLLER, $data, WEBED_ACL_ROLE, 'index.post', $this);
    }

    /**
     * Handle group actions
     * @return array
     */
    protected function groupAction()
    {
        $data = [];
        if ($this->request->get('customActionType', null) == 'group_action') {
            if(!$this->userRepository->hasPermission($this->loggedInUser, ['delete-roles'])) {
                return [
                    'customActionMessage' => trans($this->module . '::base.do_not_have_permission'),
                    'customActionStatus' => 'danger',
                ];
            }

            $ids = (array)$this->request->get('id', []);

            $action = app(DeleteRoleAction::class);
            foreach ($ids as $id) {
                $this->deleteDelete($action, $id);
            }

            $data['customActionMessage'] = trans($this->module . '::base.delete_role_success');
            $data['customActionStatus'] = 'success';
        }
        return $data;
    }

    /**
     * @param \WebEd\Base\ACL\Repositories\PermissionRepository $permissionRepository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getCreate(PermissionRepositoryContract $permissionRepository)
    {
        do_action(BASE_ACTION_BEFORE_CREATE, WEBED_ACL_ROLE, 'create.get');

        $this->setPageTitle(trans($this->module . '::base.create_role'));
        $this->breadcrumbs->addLink(trans($this->module . '::base.create_role'));

        $this->dis['permissions'] = $permissionRepository->get();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_ACL_ROLE, 'create.get')->viewAdmin('roles.create');
    }

    public function postCreate(CreateRoleRequest $request, CreateRoleAction $action)
    {
        $data = [
            'name' => $request->get('name'),
            'slug' => $request->get('slug'),
            'created_by' => $this->loggedInUser->id,
        ];
        $permissions = ($request->exists('permissions') ? $request->get('permissions') : []);

        $result = $action->run($data, $permissions);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error']) {
            return redirect()->back()->withInput();
        }

        if ($this->request->has('_continue_edit')) {
            return redirect()->to(route('admin::acl-roles.edit.get', ['id' => $result['data']['id']]));
        }

        return redirect()->to(route('admin::acl-roles.index.get'));
    }

    /**
     * @param \WebEd\Base\ACL\Repositories\PermissionRepository $permissionRepository
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getEdit(PermissionRepositoryContract $permissionRepository, $id)
    {
        $this->dis['superAdminRole'] = false;

        $item = $this->repository->find($id);

        if (!$item) {
            flash_messages()
                ->addMessages(trans($this->module . '::base.role_not_exists'), 'danger')
                ->showMessagesOnSession();

            return redirect()->to(route('admin::acl-roles.index.get'));
        }

        $this->setPageTitle(trans($this->module . '::base.edit_role'), '#' . $id . ' ' . $item->name);
        $this->breadcrumbs->addLink(trans($this->module . '::base.edit_role'));

        $this->dis['object'] = $item;

        $this->dis['checkedPermissions'] = $this->repository->getRelatedPermissions($item);

        if ($item->slug == 'super-admin') {
            $this->dis['superAdminRole'] = true;
        }

        $this->dis['permissions'] = $permissionRepository->get();

        return do_filter(BASE_FILTER_CONTROLLER, $this, WEBED_ACL_ROLE, 'edit.get', $id)->viewAdmin('roles.edit');
    }

    /**
     * @param UpdateRoleRequest $request
     * @param UpdateRoleAction $action
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(UpdateRoleRequest $request, UpdateRoleAction $action, $id)
    {
        $data = [
            'name' => $request->get('name'),
            'updated_by' => $this->loggedInUser->id,
        ];

        $permissions = ($request->exists('permissions') ? $request->get('permissions') : []);

        $result = $action->run($id, $data, $permissions);

        $msgType = $result['error'] ? 'danger' : 'success';

        flash_messages()
            ->addMessages($result['messages'], $msgType)
            ->showMessagesOnSession();

        if ($result['error'] || $this->request->has('_continue_edit')) {
            return redirect()->back();
        }

        return redirect()->to(route('admin::acl-roles.index.get'));
    }

    /**
     * @param DeleteRoleAction $action
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDelete(DeleteRoleAction $action, $id)
    {
        $result = $action->run($id);

        return response()->json($result, $result['response_code']);
    }
}
