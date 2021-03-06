<?php class databasefunctions
{
    public function createTable()
    {
        global $table_prefix, $wpdb;

        $tblname = 'vedoBundles';
        $wp_track_table = $table_prefix . "$tblname ";

        if ($wpdb->get_var("show tables like '$wp_track_table'") != $wp_track_table) {

            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE $wp_track_table (
id mediumint(9) NOT NULL AUTO_INCREMENT,
CreatedAt datetime  DEFAULT now(),
Title TEXT DEFAULT '' NOT NULL,
Url TEXT DEFAULT '' NOT NULL,
Description TEXT DEFAULT '' NOT NULL,
Category Text DEFAULT '',
CategoryId int,
vendorName Text DEFAULT '',
vendorId int,
PostId int,
Isactive bit Not NULL,
UserId int,
PRIMARY KEY  (id)
) $charset_collate;";
            file_put_contents(dirname(__file__) . '/log.txt', $sql);
            require_once ABSPATH . '/wp-admin/includes/upgrade.php';
            dbDelta($sql);
        }
    }
}
