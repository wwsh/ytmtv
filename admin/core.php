<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 **
 * The admin-specific functionality of the plugin.
 *
 * Loads up default options and allows management.
 *
 * @author     Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_AdminCore
{

    /**
     * The ID of this plugin.
     *
     * @var string
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @var string
     */
    private $version;

    /**
     * Keeping all settings in one place.
     *
     * @var YtMtv_Options
     */
    private $options;

    /**
     * Initialize the class and set its properties.
     *
     * @param $plugin_name
     * @param $version
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->options     = new YtMtv_Options();
    }

    /**
     * WP action of the same name.
     *
     * Hooking into the WP "manage_options" action to perform form rendering.
     *
     * @return false|string
     */
    public function admin_menu()
    {
        $this->admin_dispatch_post($_POST);

        return add_options_page("YT MTV Options", "YT MTV",
            'manage_options', 'yt-mtv', [$this, 'admin_manage_options_callback']);
    }

    /**
     * Called directly by WP for rendering a form with settings.
     */
    public function admin_manage_options_callback()
    {
        // there are consumed by the template itself , below.
        $options = $this->options->get();
        $hints    = $this->options->getHints();

        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/tpl/ytmtv-admin.php';
    }

    /**
     * Dispatching the incoming POST data.
     *
     * Performs saving of options.
     *
     * @param $post
     */
    private function admin_dispatch_post($post)
    {
        if (empty($post) || !isset($post['action'])) {
            return;
        }

        if ('update' === $post['action']) {
            $this->options->save($post); //
        }

        return;
    }
}