<?php
include_once dirname(__FILE__) . '/adminVedoPage.php';
class wpAdminSetup
{
    public function __construct()
    {

    }

    public function registerMenu()
    {
        add_menu_page('Video List', 'Video List', 'manage_options', 'adminVedoPage', 'adminVedoPage');
       
    }

    function wpdocs_register_my_custom_menu_page() {
        add_menu_page(
            __( 'Custom Menu Title', 'textdomain' ),
            'custom menu',
            'manage_options',
            'myplugin/myplugin-admin.php',
            '',
            plugins_url( 'myplugin/images/icon.png' ),
            6
        );
    }

}
