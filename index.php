<?php
/**
 * CodeIgniter 4
 */

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 */
require __DIR__ . '/vendor/autoload.php';

/*
 *---------------------------------------------------------------
 * SET APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 */
if (!isset($_SERVER['CI_ENVIRONMENT'])) {
    $_SERVER['CI_ENVIRONMENT'] = 'development';
}

/*
 *---------------------------------------------------------------
 * LOAD THE CONSTANTS FILE
 *---------------------------------------------------------------
 */
require_once SYSTEMPATH . 'Config/Boot.php';
require_once APPPATH . 'Config/Constants.php';

/*
 *---------------------------------------------------------------
 * LOAD THE FRAMEWORK AUTOMATICLOADER
 *---------------------------------------------------------------
 */
require_once APPPATH . 'Config/Autoload.php';

/*
 *---------------------------------------------------------------
 * INITIALIZE THE APPLICATION
 *---------------------------------------------------------------
 */
$codeigniter = CodeIgniter\CodeIgniter::getInstance();
$codeigniter->initialize();
$codeigniter->run();
