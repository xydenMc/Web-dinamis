<?php
/**
 * CodeIgniter 4 Framework
 */

require __DIR__ . '/vendor/autoload.php';

$codeigniter = CodeIgniter\CodeIgniter::getInstance();
$codeigniter->initialize();
$codeigniter->run();
