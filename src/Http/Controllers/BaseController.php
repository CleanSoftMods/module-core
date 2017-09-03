<?php namespace WebEd\Base\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    /**
     * @var Request
     */
    public $request;
    /**
     * @var string
     */
    public $adminRoute;
    /**
     * Specify all variables will be passed to view
     * @var array
     */
    public $dis = [];
    /**
     * @var \WebEd\Base\Core\Repositories\EloquentBaseRepository
     */
    protected $repository;

    public function __construct()
    {
        $this->request = request();
        $this->adminRoute = config('webed.admin_route');
    }

    /**
     * Set css class for body
     * @param string $class
     */
    public function setBodyClass($class)
    {
        view()->share([
            'bodyClass' => $class,
        ]);
    }

    /**
     * Set page title
     * @param $title
     * @param null $subTitle
     */
    public function setPageTitle($title, $subTitle = null)
    {
        view()->share([
            'pageTitle' => $title,
            'subPageTitle' => $subTitle,
        ]);
    }

    /**
     * @param $viewName
     * @param null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($viewName, $data = null)
    {
        if ($data === null) {
            $data = $this->dis;
        }
        if (property_exists($this, 'module')) {
            return view($this->module . '::' . $viewName, $data);
        }
        return view($viewName, $data);
    }
}
