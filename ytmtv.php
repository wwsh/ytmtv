<?php
/***********************************************************
 * Copyright (c) 2016 WW Software House. 
 * All Rights Reserved. Please visit http://wwsh.io
 **********************************************************/

/**
 * The YouTube MTV plugin for continuous video streaming.
 * Have fun!
 *
 * @link              http://wwsh.io
 * @package           YtMtv
 *
 * @wordpress-plugin
 * Plugin Name:       YT MTV
 * Plugin URI:        http://wwsh.io/ytmtv
 * Description:       This plugin allows continuous displaying of YouTube videos, using provided "bonanza".
 * Version:           1.0.0
 * Author:            Thomas Parys
 * Author URI:        http://wwsh.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * The code for plugin activation.
 */
function activate_ytmtv()
{
    require_once plugin_dir_path(__FILE__) . 'inc/activator.php';
    YtMtv_Activator::activate();
}

/**
 * The code for plugin deactivation.
 */
function deactivate_yt_mtv()
{
    require_once plugin_dir_path(__FILE__) . 'inc/deactivator.php';
    YtMtv_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_ytmtv');
register_deactivation_hook(__FILE__, 'deactivate_ytmtv');

/**
 * Setting up all hooks here.
 */
require plugin_dir_path(__FILE__) . 'inc/plugin.php';

/**
 * Easy manageable options.
 */
require plugin_dir_path(__FILE__) . 'inc/options.php';

/**
 * Let's define a version.
 */
define('YTMTV_VERSION', '1.0');

/**
 * Plugin bootup.
 */
function run_yt_mtv()
{
    $plugin = new YtMtv();
    $plugin->run();
}

/**
 * Here we go! Let's MTV
 */
run_yt_mtv();
