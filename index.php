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

  include_once dirname( __FILE__ ) . '/install.php';
  register_activation_hook( __FILE__, array( 'MyPlugin', 'install' ) );

?>