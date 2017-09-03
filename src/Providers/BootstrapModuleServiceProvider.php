<?php namespace CleanSoft\Modules\Core\Providers;

use CleanSoft\Modules\Core\Events\SessionStarted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Event::listen(SessionStarted::class, function () {
            $this->onSessionStarted();
        });
    }

    /**
     * Register dashboard menus, translations, cms settings
     */
    protected function onSessionStarted()
    {
        /**
         * Register to dashboard menu
         */
        dashboard_menu()->registerItem([
            'id' => 'webed-acl-roles',
            'priority' => 3.1,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-acl::base.roles'),
            'font_icon' => 'icon-lock',
            'link' => route('admin::acl-roles.index.get'),
            'css_class' => null,
            'permissions' => ['view-roles'],
        ])->registerItem([
            'id' => 'webed-acl-permissions',
            'priority' => 3.2,
            'parent_id' => null,
            'heading' => null,
            'title' => trans('webed-acl::base.permissions'),
            'font_icon' => 'icon-shield',
            'link' => route('admin::acl-permissions.index.get'),
            'css_class' => null,
            'permissions' => ['view-permissions'],
        ]);
        dashboard_menu()->registerItem([
            'id' => 'webed-dashboard',
            'priority' => -999,
            'parent_id' => null,
            'heading' => trans('webed-core::base.admin_menu.dashboard.heading'),
            'title' => trans('webed-core::base.admin_menu.dashboard.title'),
            'font_icon' => 'icon-pie-chart',
            'link' => route('admin::dashboard.index.get'),
            'css_class' => null,
        ]);
        dashboard_menu()->registerItem([
            'id' => 'webed-configuration',
            'priority' => 999,
            'parent_id' => null,
            'heading' => trans('webed-core::base.admin_menu.configuration.heading'),
            'title' => trans('webed-core::base.admin_menu.configuration.title'),
            'font_icon' => 'icon-settings',
            'link' => route('admin::settings.index.get'),
            'css_class' => null,
        ]);


        admin_quick_link()->register('role', [
            'title' => trans('webed-acl::base.role'),
            'url' => route('admin::acl-roles.create.get'),
            'icon' => 'icon-lock',
        ]);


        cms_settings()
            ->addSettingField('site_title', [
                'group' => 'basic',
                'type' => 'text',
                'priority' => 5,
                'label' => trans('webed-core::base.settings.site_title.label'),
                'helper' => trans('webed-core::base.settings.site_title.helper')
            ], function () {
                return [
                    'site_title',
                    get_setting('site_title'),
                    ['class' => 'form-control']
                ];
            })
            ->addSettingField('site_logo', [
                'group' => 'basic',
                'type' => 'selectImageBox',
                'priority' => 5,
                'label' => trans('webed-core::base.settings.site_logo.label'),
                'helper' => trans('webed-core::base.settings.site_logo.helper')
            ], function () {
                return [
                    'site_logo',
                    get_setting('site_logo'),
                    null,
                    trans('webed-core::base.form.choose_image'),
                ];
            })
            ->addSettingField('favicon', [
                'group' => 'basic',
                'type' => 'selectImageBox',
                'priority' => 5,
                'label' => trans('webed-core::base.settings.favicon.label'),
                'helper' => trans('webed-core::base.settings.favicon.helper'),
            ], function () {
                return [
                    'favicon',
                    get_setting('favicon'),
                    null,
                    trans('webed-core::base.form.choose_image'),
                ];
            })
            ->addSettingField('construction_mode', [
                'group' => 'advanced',
                'type' => 'customCheckbox',
                'priority' => 5,
                'label' => null,
                'helper' => trans('webed-core::base.settings.construction_mode.helper'),
            ], function () {
                return [
                    [['construction_mode', '1', trans('webed-core::base.settings.construction_mode.label'), get_setting('construction_mode'),]],
                ];
            })
            ->addSettingField('show_admin_bar', [
                'group' => 'advanced',
                'type' => 'customCheckbox',
                'priority' => 5,
                'label' => null,
                'helper' => trans('webed-core::base.settings.show_admin_bar.helper')
            ], function () {
                return [
                    [['show_admin_bar', '1', trans('webed-core::base.settings.show_admin_bar.label'), get_setting('show_admin_bar')]],
                ];
            });
        cms_settings()->addGroup('socials', trans('webed-core::base.setting_group.socials'));
        $socials = [
            'facebook' => [
                'label' => trans('webed-core::base.settings.socials.facebook'),
            ],
            'youtube' => [
                'label' => trans('webed-core::base.settings.socials.youtube'),
            ],
            'twitter' => [
                'label' => trans('webed-core::base.settings.socials.twitter'),
            ],
            'google_plus' => [
                'label' => trans('webed-core::base.settings.socials.google_plus'),
            ],
            'instagram' => [
                'label' => trans('webed-core::base.settings.socials.instagram'),
            ],
            'linkedin' => [
                'label' => trans('webed-core::base.settings.socials.linkedin'),
            ],
            'flickr' => [
                'label' => trans('webed-core::base.settings.socials.flickr'),
            ],
        ];
        foreach ($socials as $key => $row) {
            cms_settings()->addSettingField($key, [
                'group' => 'socials',
                'type' => 'text',
                'priority' => 1,
                'label' => $row['label'],
                'helper' => null
            ], function () use ($key) {
                return [
                    $key,
                    get_setting($key),
                    [
                        'class' => 'form-control',
                        'placeholder' => 'https://',
                        'autocomplete' => 'off'
                    ]
                ];
            });
        }
    }
}
