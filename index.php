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
  if(!defined('vedo_bundles'))
	define('vedo_bundles', plugin_dir_url( __FILE__ ));
if(!defined('vedo_bundles'))
  define('vedo_bundles', plugin_dir_path( __FILE__ ));
  include_once dirname( __FILE__ ) . '/classes/databasefunctions.php';
  class vedoBundles 
  {
    var $pluginDb;
    public function __construct()
    {
     
      register_activation_hook( __FILE__, array('vedoBundles','activePlugin'));
 // Admin page calls:
 add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
 //add_action( 'wp_ajax_store_admin_data', array( $this, 'storeAdminData' ) );
 //add_action( 'admin_enqueue_scripts', array( $this, 'addAdminScripts' ) );
    }


    function addAdminMenu(){

    }

    static function activePlugin(){
      $pluginDb = new databasefunctions();
      $pluginDb->createTable();
      file_put_contents(dirname(__file__).'/error_activation.log', ob_get_contents());
    }

  }
  new vedoBundles(); ?>