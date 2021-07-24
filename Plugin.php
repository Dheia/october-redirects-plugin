<?php 

namespace Synder\Redirects;

use Cms\Classes\CmsController;
use System\Classes\PluginBase;

use Synder\Redirects\FormWidgets\HttpsTest;
use Synder\Redirects\Middleware\RedirectsMiddleware;
use Synder\Redirects\Models\Settings;


class Plugin extends PluginBase
{
    /**
     * Plugin dependencies
     * 
     * @var array
     */
    public $require = [];

    /**
     * Plugin Details
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'synder.redirects::lang.plugin.name',
            'description' => 'synder.redirects::lang.plugin.description',
            'author'      => 'Synder <october@synder.dev>',
            'homepage'    => 'https://octobercms.com/plugin/synder-redirects'
        ];
    }

    /**
     * Register Form Widgets
     *
     * @return void
     */
    public function registerFormWidgets()
    {
        return [
            HttpsTest::class => 'synder-httpstest'
        ];
    }
    
    /**
     * Register Plugin Settings
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'synder.redirects::lang.menu.name',
                'description' => 'synder.redirects::lang.menu.description',
                'category'    => 'system::lang.system.categories.misc',
                'icon'        => 'icon-globe',
                'class'       => Settings::class,
                'order'       => 500,
                'keywords'    => 'redirect redirection forward https www non-www location routing'
            ]
        ];
    }

    /**
     * Boot Plugin
     *
     * @return void
     */
    public function boot()
    {
        CmsController::extend(function($controller) {
            $controller->middleware(RedirectsMiddleware::class);
        });
    }
}
