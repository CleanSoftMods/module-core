<?php
/**
 * Global config for WebEd
 * @author Tedozi Manson <duyphan.developer@gmail.com>
 */
return [
    /**
     * Admin route slug
     */
    'admin_route' => env('WEBED_ADMIN_ROUTE', 'admincp'),
    'api_route' => env('WEBED_API_ROUTE', 'api'),
    'languages' => [
        'vi' => 'Vietnamese',
        'en' => 'English'
    ],
    'external_core' => [
        CleanSoft\Modules\Core\Elfinder\Providers\ModuleProvider::class,
        CleanSoft\Modules\Core\Pages\Providers\ModuleProvider::class,
        CleanSoft\Modules\Core\CustomFields\Providers\ModuleProvider::class,
        CleanSoft\Modules\Core\StaticBlocks\Providers\ModuleProvider::class,
    ],
];
