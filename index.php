<?php
/*
Plugin Name: Vido-bundles
Plugin URI: https://github.com/munendra/Vedo-Bundles
description: A plugin to store video link by category
Version: 1.0
Author: Munendra Kumar
Author URI: https://github.com/munendra/
License: GPL2
 */
if (!defined('vedo_bundles')) {
    define('vedo_bundles', plugin_dir_url(__FILE__));
}

if (!defined('vedo_bundles')) {
    define('vedo_bundles', plugin_dir_path(__FILE__));
}

include_once dirname(__FILE__) . '/classes/databasefunctions.php';
include_once dirname(__FILE__) . '/classes/wpAdminSetup.php';
class vedoBundles
{
    public $pluginDb;
    public $wpAdminSetup;
    public function __construct()
    {

        register_activation_hook(__FILE__, array('vedoBundles', 'activePlugin'));
        // Admin page calls:
        add_action('admin_menu', array($this, 'addAdminMenu'));
        //add_action( 'wp_ajax_store_admin_data', array( $this, 'storeAdminData' ) );
        add_action('admin_enqueue_scripts', array($this, 'addAdminScripts'));
    }

    public function addAdminMenu()
    {
        $wpAdminSetup = new wpAdminSetup();
        $wpAdminSetup->registerMenu();
    }

    public static function activePlugin()
    {
        $pluginDb = new databasefunctions();
        $pluginDb->createTable();
        file_put_contents(dirname(__file__) . '/error_activation.log', ob_get_contents());
    }
    public function addAdminScripts()
    {
        wp_enqueue_script('jsgrid.js', plugins_url('/assets/js/jsgrid.js', __FILE__));
        wp_enqueue_script('db.js', plugins_url('/assets/js/db.js', __FILE__));
        wp_enqueue_script('vedo-plugin.js', plugins_url('/assets/js/vedo-plugin.js', __FILE__));
        wp_enqueue_style('jsgrid.css', plugins_url('/assets/css/jsgrid.css', __FILE__));
        wp_enqueue_style('theme.css', plugins_url('/assets/css/theme.css', __FILE__));
        wp_enqueue_style('vedo-plugin.css', plugins_url('/assets/css/vedo-plugin.css', __FILE__));
    }
}
new vedoBundles();
