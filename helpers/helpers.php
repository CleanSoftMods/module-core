<?php
use CleanSoft\Modules\Core\Repositories\Contracts\PermissionRepositoryContract;

if (!function_exists('admin_bar')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\AdminBar
     */
    function admin_bar()
    {
        return \CleanSoft\Modules\Core\Facades\AdminBarFacade::getFacadeRoot();
    }
}
if (!function_exists('system_bar')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\SystemBar
     */
    function system_bar()
    {
        return \CleanSoft\Modules\Core\Facades\SystemBarFacade::getFacadeRoot();
    }
}
if (!function_exists('email_bar')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\EmailBar
     */
    function email_bar()
    {
        return \CleanSoft\Modules\Core\Facades\EmailBarFacade::getFacadeRoot();
    }
}
if (!function_exists('dashboard_menu')) {
    /**
     * @return \CleanSoft\Modules\Core\Menu\Support\DashboardMenu
     */
    function dashboard_menu()
    {
        return \CleanSoft\Modules\Core\Menu\Facades\DashboardMenuFacade::getFacadeRoot();
    }
}
if (!function_exists('load_module_helpers')) {
    /**
     * @param $dir
     */
    function load_module_helpers($dir)
    {
        \CleanSoft\Modules\Core\Support\Helper::loadModuleHelpers($dir);
    }
}
if (!function_exists('get_image')) {
    /**
     * @param $image
     * @param string $default
     * @return null|string
     */
    function get_image($image, $default = 'admin/images/no-image.png')
    {
        if (!$image || !trim($image)) {
            if (!$default) {
                return null;
            }
            return asset($default);
        }
        return asset($image);
    }
}
if (!function_exists('convert_timestamp_format')) {
    /**
     * @param $dateTime
     * @param $format
     * @return string
     */
    function convert_timestamp_format($dateTime, $format = 'Y-m-d H:i:s')
    {
        if ($dateTime == '0000-00-00 00:00:00') {
            return null;
        }
        $date = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $dateTime);
        return $date->format($format);
    }
}
if (!function_exists('convert_unix_time_format')) {
    /**
     * @param $dateTime
     * @param $format
     * @return string|null
     */
    function convert_unix_time_format($unix, $format = 'Y-m-d H:i:s')
    {
        try {
            return date($format, $unix);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
if (!function_exists('json_encode_prettify')) {
    /**
     * @param array $files
     */
    function json_encode_prettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
if (!function_exists('is_admin_panel')) {
    /**
     * @return bool
     */
    function is_admin_panel()
    {
        $segment = request()->segment(1);
        if ($segment === config('webed.admin_route', 'admincp')) {
            return true;
        }
        return false;
    }
}
if (!function_exists('custom_strip_tags')) {
    /**
     * @param array|string $data
     * @param string $allowTags
     * @return array|string
     */
    function custom_strip_tags($data, $allowTags = '<p><a><br><b><strong>')
    {
        if (!is_array($data)) {
            return strip_tags($data, $allowTags);
        }
        foreach ($data as $key => $row) {
            $data[$key] = strip_tags($row, $allowTags);
        }
        return $data;
    }
}
if (!function_exists('limit_chars')) {
    /**
     * @param $string
     * @param null $limit
     * @param string $append
     * @param bool $hardCutString
     * @return string
     */
    function limit_chars($string, $limit = null, $append = '...', $hardCutString = false)
    {
        if (!$limit) {
            return $string;
        }
        if (mb_strlen($string) <= $limit) {
            $append = '';
        }
        if (!$hardCutString) {
            if (!$limit || $limit < 0) {
                return $string;
            }
            if (mb_strlen($string) <= $limit) {
                $append = '';
            }
            $string = mb_substr($string, 0, $limit);
            if (mb_substr($string, -1, 1) != ' ') {
                $string = mb_substr($string, 0, mb_strrpos($string, ' '));
            }
            return $string . $append;
        }
        return mb_substr($string, 0, $limit) . $append;
    }
}
if (!function_exists('check_user_acl')) {
    /**
     * @return \CleanSoft\Modules\Core\Support\CheckUserACL
     */
    function check_user_acl()
    {
        return \CleanSoft\Modules\Core\Facades\CheckUserACLFacade::getFacadeRoot();
    }
}
if (!function_exists('acl_permission')) {
    /**
     * Get the PermissionRepository instance.
     *
     * @return \CleanSoft\Modules\Core\Repositories\PermissionRepository
     */
    function acl_permission()
    {
        return app(PermissionRepositoryContract::class);
    }
}
if (!function_exists('has_permissions')) {
    /**
     * @param \CleanSoft\Modules\Core\Users\Models\User $user
     * @param array $permissions
     * @return bool
     */
    function has_permissions($user, array $permissions = [])
    {
        if (!$user) {
            return false;
        }
        if (!$permissions) {
            return true;
        }
        /**
         * @var \CleanSoft\Modules\Core\Users\Repositories\UserRepository $userRepo
         */
        $userRepo = app(\CleanSoft\Modules\Core\Users\Repositories\Contracts\UserRepositoryContract::class);
        return $userRepo->hasPermission($user, $permissions);
    }
}
if (!function_exists('has_roles')) {
    /**
     * @param \CleanSoft\Modules\Core\Users\Models\User $user
     * @param array $roles
     * @return bool
     */
    function has_roles($user, array $roles = [])
    {
        if (!$user) {
            return false;
        }
        if (!$roles) {
            return true;
        }
        /**
         * @var \CleanSoft\Modules\Core\Users\Repositories\UserRepository $userRepo
         */
        $userRepo = app(\CleanSoft\Modules\Core\Users\Repositories\Contracts\UserRepositoryContract::class);
        return $userRepo->hasRole($user, $roles);
    }
}

