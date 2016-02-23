<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * Class YtMtv - the core plugin class.
 *
 * Setting up admin-specific hooks and front-end site hooks.
 *
 * Also maintains the id and version of the plugin.
 *
 * @author     Thomas Parys <ww@epoczta.pl>
 */
class YtMtv
{
    /**
     * WordPress API handler. Maintains registering hooks, etc.
     *
     * @var      YtMtv_Handler $handler
     */
    protected $handler;

    /**
     * The unique identifier of this plugin.
     *
     * @var      string
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @var      string
     */
    protected $version;

    /**
     * The frontend part of the plugin. Rendering shortcode HTML, etc.
     *
     * @var YtMtv_FrontEndCore
     */
    private $plugin_frontend;

    /**
     * The options of the plugin.
     *
     * @var YtMtv_Options
     */
    private $options;

    /**
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies and set the hooks for the admin area and the front-end of the plugin.
     */
    public function __construct()
    {

        $this->plugin_name = 'ytmtv';
        $this->version     = '1.0.0';
        $this->options     = new YtMtv_Options(); // no need to pass as dependency

        $this->load_dependencies();
        $this->setup_admin_hooks();
        $this->setup_frontend_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     */
    private function load_dependencies()
    {

        /**
         * The class responsible for communicating with the WP API 
         * in setting up the actions and filters of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'inc/handler.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/core.php';

        /**
         * The class responsible for defining all actions that occur in the frontend area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'frontend/core.php';

        /**
         * The class responsible for primitive statistics.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'inc/stats.php';
        
        /**
         * Autoloading vendor libraries.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'vendor/autoload.php';
        
        /**
         * The class responsible for accessing external services, like YouTube.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'youtube/service.php';

        /**
         * Additional data processor for YouTube.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'youtube/processor.php';

        $this->handler = new YtMtv_Handler();

    }


    /**
     * Registering all admin hooks.
     **/
    private function setup_admin_hooks()
    {
        $plugin_admin = new YtMtv_AdminCore($this->get_plugin_name(), $this->get_version());
        
        $this->handler->add_action('admin_menu', $plugin_admin, 'admin_menu');
    }

    /**
     * Registering all frontend site hooks.
     */
    private function setup_frontend_hooks()
    {

        $this->plugin_frontend = new YtMtv_FrontEndCore(
            $this->get_plugin_name(),
            $this->get_version(),
            $this->get_options() // injecting options
        );
        /**
         * Register the frontend javascript file.
         */
        $this->handler->add_action('wp_enqueue_scripts', $this->plugin_frontend, 'enqueue_scripts');
        /**
         * Add the shortcode handling for the plugin
         */
        $this->handler->add_shortcode('ytmtv', $this->plugin_frontend, 'shortcode');
        /**
         * Register an AJAX call, used by the JavaScripts.
         */
        $this->handler->add_action('wp_ajax_nopriv_get_video', $this->plugin_frontend, 'ajax_get_video');
        $this->handler->add_action('wp_ajax_get_video', $this->plugin_frontend, 'ajax_get_video');
    }


    /**
     * Run the handler to register all of the hooks with WordPress.
     *
     */
    public function run()
    {
        $this->handler->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    YtMtv_Handler    Orchestrates the hooks of the plugin.
     */
    public function get_handler()
    {
        return $this->handler;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Getter of the options.
     *
     * @return YtMtv_Options
     */
    public function get_options()
    {
        return $this->options;
    }
}