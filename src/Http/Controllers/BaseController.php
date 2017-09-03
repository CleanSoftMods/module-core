<?php namespace CleanSoft\Modules\Core\Http\Controllers;

use CleanSoft\Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var EloquentBaseRepository
     */
    protected $repository;

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
     * @var null|string
     */
    protected $module = null;

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
     * Set view
     * @param $view
     * @param array|null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($view, $data = null, $module = null)
    {
        if ($data === null || !is_array($data)) {
            $data = $this->dis;
        }
        if ($module === null) {
            if (property_exists($this, 'module') && $this->module) {
                return view($this->module . '::' . $view, $data);
            }
        }
        return view($view, $data);
    }

    /**
     * Set view admin
     * @param $view
     * @param array|null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function viewAdmin($view, $data = null, $module = null)
    {
        if ($data === null || !is_array($data)) {
            $data = $this->dis;
        }
        if ($module === null) {
            if (property_exists($this, 'module') && $this->module) {
                return view($this->module . '::admin.' . $view, $data);
            }
        }
        return view('admin.' . $view, $data);
    }

    /**
     * Set view front
     * @param $view
     * @param array|null $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function viewFront($view, $data = null, $module = null)
    {
        if ($data === null || !is_array($data)) {
            $data = $this->dis;
        }
        if ($module === null) {
            if (property_exists($this, 'module') && $this->module) {
                return view($this->module . '::front.' . $view, $data);
            }
        }
        return view('front.' . $view, $data);
    }
}
