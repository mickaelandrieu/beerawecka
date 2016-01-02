<?php

/**
 * -----------------------------------------------------------------------------
 * CONFIGURATION
 * -----------------------------------------------------------------------------
 */
define('ENV', 'development');
define('FCPATH', dirname(__FILE__) . '/');
define('APPPATH', realpath(FCPATH . '../app') . '/');

/**
 * -----------------------------------------------------------------------------
 * BOOTSTRAP
 * -----------------------------------------------------------------------------
 */
require_once APPPATH . 'config/constants.php';
require_once LIBPATH . 'autoload.php';
App\Core\Beerawecka::run();

/* End of file */