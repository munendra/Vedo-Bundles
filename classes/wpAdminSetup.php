<?php
include_once dirname(__FILE__) . '/adminVedoPage.php';
class wpAdminSetup
{
    public function __construct()
    {

    }

    public function registerMenu()
    {
        add_options_page('Video List', 'Video List', 'manage_options', 'adminVedoPage', 'adminVedoPage');
    }

}
