<?php
class MyPlugin {

     function install() {
        file_put_contents(__DIR__.'/log.txt', 'plugin activated');
    }


   public function CreateTable(){
        global $wpdb;
        $table_name = $wpdb->prefix . "liveshoutbox"; 
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  CreatedAt datetime DEFAULT 'NOW()' NOT NULL,
  Title varchar(55) NOT NULL,
  Url varchar(MAX) NOT NULL,
  Description text DEFAULT '' NOT NULL,
  Category text,
  DealerName text,
  PRIMARY KEY  (id)
) $charset_collate;";
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
    }
}
?>