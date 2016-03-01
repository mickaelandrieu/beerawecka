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
define('APPSPACE', 'App');

/**
 * -----------------------------------------------------------------------------
 * BOOTSTRAP
 * -----------------------------------------------------------------------------
 */
require_once APPPATH . 'config/constants.php';
require_once LIBPATH . 'autoload.php';
App\Core\Beerawecka::run();

/* End of file */