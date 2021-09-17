<?php namespace Hounddd\MallForWinter;

use Backend;
use Event;
use System\Classes\PluginBase;
use System\Classes\PluginManager;

/**
 * MallForWinter Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'MallForWinter',
            'description' => 'Improve Offline.mall compatibility with WinterCMS.',
            'author'      => 'Hounddd',
            'icon'        => 'icon-shop'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        if (PluginManager::instance()->exists('Winter.User')) {
            // Maybe a try to remove Rainlab.User if it was installed by composer update.
            
            // Update CustomerGroups controller relations definitions
            Event::listen('system.extendConfigFile', function ($publicFile, $config) {
                if ($publicFile === '/plugins/offline/mall/controllers/customergroups/config_relation.yaml') {
                    $config['users']['manage']['form'] = '$/winter/user/models/user/fields.yaml';
                    $config['users']['manage']['list'] = '$/winter/user/models/user/columns.yaml';
                    $config['users']['view']['list'] = '$/winter/user/models/user/columns.yaml';
                }
                return $config;
            });
        }
    }
}
