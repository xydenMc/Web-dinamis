<?php

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This file sets the "paths" and "environments" bootstrap
 * parameters that tell the framework where the root directory
 * is located, and which environment the application is running
 * in.
 *
 * These values are read from the .env file by the DotEnv class.
 * They are then set as constants here so they can be used
 * throughout the framework.
 *
 * The bootstrap process is handled by Boot::bootWeb().
 */

// Path to the front controller
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
chdir(FCPATH);

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// LOAD OUR PATHS CONFIG FILE
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// LOAD THE FRAMEWORK BOOTSTRAP FILE
require $paths->systemDirectory . '/Boot.php';

CodeIgniter\Boot::bootWeb($paths);
