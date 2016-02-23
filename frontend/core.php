<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House.
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * The FrontEnd functionality of the plugin.
 *
 * Replaces shortcode and renders the YT player on site.
 *
 * @package    Yt_Mtv
 * @subpackage Yt_Mtv/public
 * @author     Thomas Parys <ww@epoczta.pl>
 */
class YtMtv_FrontEndCore
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
     * @var  string
     */
    private $version;

    /**
     * @var YtMtv_Options
     */
    private $options;

    /**
     * The YouTube service definition.
     *
     * A bridge between Google's APIs, and the plugin code.
     *
     * @var YtMtv_YouTubeService
     */
    private $youtube;

    /**
     * The stats service.
     *
     * @var YtMtv_StatsCollector
     */
    private $stats;

    /**
     * Initialize the class and set its properties.
     *
     * Loads dependant services.
     *
     * @param $plugin_name
     * @param $version
     * @param $options
     */
    public function __construct($plugin_name, $version, $options)
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->options     = $options;
        /**
         * FrontEnd is querying YouTube statically (non-ajax) and dynamically (ajax).
         */
        $this->youtube = new YtMtv_YouTubeService($this->options);
        /**
         * FrontEnd is storing primitive stats of streamed movies.
         */
        $this->stats = new YtMtv_StatsCollector();
    }


    /**
     * Register the JavaScript for the plugin FrontEnd.
     *
     */
    public function enqueue_scripts()
    {
        /**
         * Make sure we are having jQuery loaded.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ytmtv.js', array('jquery'),
            $this->version, false);
    }

    /**
     * WP shortcode callback.
     *
     * Invoked upon shortcode match inside the rendered template.
     * This function replaces the shortcode with HTML and JavaScript of the YTMTV player.
     */
    public function shortcode()
    {
        $options = $this->options->get(); // consumed by the template itself

        /**
         * Query YouTube for video ID.
         */
        $ytFirstVideoId = $this->youtube->get_random_videoID();

        if ($ytFirstVideoId === null) {
            require_once plugin_dir_path(__FILE__) . 'tpl/ytmtv-error.php';

            return;
        }

        $this->stats->collect($ytFirstVideoId);

        require_once plugin_dir_path(__FILE__) . 'tpl/ytmtv.php';
    }

    /**
     * WP ajax callback.
     *
     * This function is called by the JS upon video end, querying for the next video to be played.
     *
     */
    public function ajax_get_video()
    {
        if (!defined('DOING_AJAX')) {
            return;
        }

        /**
         * Query YouTube for video ID.
         */
        $randomVideoId = $this->youtube->get_random_videoID();

        $this->stats->collect($randomVideoId);

        wp_send_json(['videoID' => $randomVideoId]);
    }

}
