<?php

/**
 * -----------------------------------------------------------------------------
 * CONFIGURATION
 * -----------------------------------------------------------------------------
 */
define('ENV', 'development');
define('FCPATH', dirname(__FILE__) . '/');
define('APPPATH', realpath(FCPATH . '../app') . '/');
define('LIBPATH', realpath(FCPATH . '../vendor') . '/');

/**
 * -----------------------------------------------------------------------------
 * BOOTSTRAP
 * -----------------------------------------------------------------------------
 */
require_once APPPATH . 'config/constants.php';
require_once LIBPATH . 'autoload.php';
App\Core\Bootstrap::run();

/* End of file */