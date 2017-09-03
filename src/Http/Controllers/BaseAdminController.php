<?php namespace CleanSoft\Modules\Core\Http\Controllers;

use CleanSoft\Modules\Core\Support\Breadcrumbs;
use CleanSoft\Modules\Core\Users\Repositories\Contracts\UserRepositoryContract;
use CleanSoft\Modules\Core\Users\Repositories\UserRepository;
use Illuminate\Http\Request;

abstract class BaseAdminController extends BaseController
{
    /**
     * @var Breadcrumbs
     */
    public $breadcrumbs;

    /**
     * @var \CleanSoft\Modules\Core\Users\Models\User
     */
    protected $loggedInUser;

    /**
     * @var \CleanSoft\Modules\Core\AssetsManagement\Assets
     */
    public $assets;

    /**
     * Use to check role
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function (Request $request, $next) {
            $this->breadcrumbs = breadcrumbs()->setBreadcrumbClass('breadcrumb')
                ->setContainerTag('ol')
                ->addLink(config('app.name') ?: 'WebEd', route('admin::dashboard.index.get'), '<i class="icon-home mr5"></i>');
            $this->loggedInUser = get_current_logged_user();
            view()->share([
                'loggedInUser' => $this->loggedInUser
            ]);
            return $next($request);
        });
        $this->assets = assets_management()->getAssetsFrom('admin');
        $this->userRepository = app(UserRepositoryContract::class);
    }

    /**
     * @param null $activeId
     */
    protected function getDashboardMenu($activeId = null)
    {
        dashboard_menu()->setActiveItem($activeId);
    }
}
