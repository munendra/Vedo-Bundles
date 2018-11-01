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
      
        add_action('admin_enqueue_scripts', array($this, 'addAdminScripts'));
        add_action('wp_ajax_vedoBundles_getall', array($this, 'vedoBundles_GetAll'));
        add_action('wp_ajax_nopriv_vedoBundles_getall', array($this, 'vedoBundles_GetAll'));
        //vedoBundles_delete
        add_action('wp_ajax_vedoBundles_delete', array($this, 'vedoBundles_delete'));
        //vedoBundles_Add
        add_action('wp_ajax_vedoBundles_add', array($this, 'vedoBundles_add'));
        //vedoBundles_update
        add_action('wp_ajax_vedoBundles_update', array($this, 'vedoBundles_update'));

        add_action('wp_ajax_vedoBundles_filter', array($this, 'vedoBundles_filter'));
        add_action('wp_ajax_nopriv_vedoBundles_filter', array($this, 'vedoBundles_filter'));
        
        add_shortcode('vedoFilter', array($this, 'vedoFilter'));

        

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
        wp_enqueue_script('vedo-plugin.js', plugins_url('/assets/js/vedo-plugin.js', __FILE__));
        wp_enqueue_style('jsgrid.css', plugins_url('/assets/css/jsgrid.css', __FILE__));
        wp_enqueue_style('theme.css', plugins_url('/assets/css/theme.css', __FILE__));
        wp_enqueue_style('vedo-plugin.css', plugins_url('/assets/css/vedo-plugin.css', __FILE__));
    }

    public function vedoBundles_GetAll()
    {
        global $wpdb;
       
        $orderby = 'name';
        $order = 'asc';
        $hide_empty = false ;
        $cat_args = array(
            'orderby'    => $orderby,
            'order'      => $order,
            'hide_empty' => $hide_empty,
        );
         
        $product_categories = get_terms( 'product_cat', $cat_args );
       
      $user_fields = array( 'id', 'display_name' );
      $user_query = new WP_User_Query( array( 'role' => 'dc_vendor','orderby' => 'display_name','fields'=>$user_fields ) );
      $users = $user_query->get_results();
      $sql="SELECT * FROM {$wpdb->prefix}vedoBundles where Isactive=1";  
    
      $results = $wpdb->get_results($sql, OBJECT);
      
        $object = (object) [
            'videoList' => $results,
            'productCategories' => $product_categories,
            'vendors'=>$users
          ];
        echo json_encode($object);
        die();
    }


    public function vedoBundles_filter(){
        global $wpdb;
    $sql="SELECT * FROM {$wpdb->prefix}vedoBundles where Isactive=1 and CategoryId={$_GET['categoryId']} and vendorId={$_GET['vandorId']}";
   
    $results = $wpdb->get_results($sql, OBJECT);
    echo json_encode($results);   
    die();
    }

    public function vedoBundles_Delete()
    {
        global $wpdb;
        $results = $wpdb->query("delete from {$wpdb->prefix}vedoBundles where id=" . $_GET['id']);
        echo json_encode($results);
        die();
    }
    public function vedoBundles_Add()
    {
        global $wpdb;
        $results = $wpdb->insert("{$wpdb->prefix}vedoBundles",
            array(
                'Url' => $_POST['data']['Url'],
                'CategoryId' => $_POST['data']['ProductCategory'],
                'vendorId' => $_POST['data']['vendor'],
                'Isactive' => true,
                'UserId'=> get_current_user_id()
            ));
        echo $results;
        die();
    }
    public function vedoBundles_update()
    {
        global $wpdb;
        $isActive = 0;
        print_r($_POST['data']);
        if ($_POST['data']['Isactive']) {
            $isActive = 1;
        }
        $results = $wpdb->update("{$wpdb->prefix}vedoBundles",
            array(
                'Url' => $_POST['data']['Url'],
                'CategoryId' => $_POST['data']['ProductCategory'],
                'vendorId' => $_POST['data']['vendor'],
                'Isactive' => $_POST['data']['Isactive'],
            )
            , array('id' => $_POST['data']['id']));
        echo $results;
        die();
    }

    function vedoFilter(){
        wp_enqueue_script('page-vedo-plugin.js', plugins_url('/assets/js/main.js', __FILE__));
        wp_enqueue_style('page-vedo-plugin.css', plugins_url('/assets/css/vedo-plugin.css', __FILE__));
        global $wpdb;
            
            $orderby = 'name';
            $order = 'asc';
            $hide_empty = false ;
            $cat_args = array(
                'orderby'    => $orderby,
                'order'      => $order,
                'hide_empty' => $hide_empty,
            );
             
         $product_categories = get_terms( 'product_cat', $cat_args );
           
          $user_fields = array( 'id', 'display_name' );
          $user_query = new WP_User_Query( array( 'role' => 'dc_vendor','orderby' => 'display_name','fields'=>$user_fields ) );
          $users = $user_query->get_results();
        
        ?>
        <form>
        <div class="woof vedo-filter-wrapper">
            <div class="woof_redraw_zone">
                <div class="form-control-wrapper">
                    <label>Sort by category</label>
                    <select id="categoryId">
                        <?php foreach($product_categories as $ele) { ?>
                        <option value='<?php echo $ele->term_id ?>'><?php echo $ele->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-control-wrapper">
                    <label>Sort by Vendor</label>
                    <select id="vandorId">
                    <?php foreach($users as $user) { ?>
                        <option value='<?php echo $user->id ?>'><?php echo $user->display_name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-control-wrapper button-align">            
                    <button id="btnFilterVideo" type="button">Filter</button>
                </div>
            </div>
        </div>
        
        <div class="videos-list" id="videos-list">
        </div>
        </form>
        <div id='loading' >
          <img src="<?php echo plugins_url('/assets/images/ajax-loader.gif', __FILE__) ?>">
        </div>
        <?php
        }
}
new vedoBundles();
