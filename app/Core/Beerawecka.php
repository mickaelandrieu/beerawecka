<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace App\Core;

/**
 * Beerawecka
 *
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
class Beerawecka
{

    /**
     * @var \App\Core\Controller 
     */
    private static $instance = NULL;

    // -------------------------------------------------------------------------

    /**
     * Run an application
     */
    public static function run()
    {
        // Error reporting
        error_reporting(-1);
        ini_set('display_errors', ENV == 'production' ? 0 : 1);

        // Loader
        $loader = new Loader();

        // Global configuration
        $config = $loader->config('config');

        // UTF-8 support
        if (isset($config['utf8']) && $config['utf8'])
        {
            mb_internal_encoding('UTF-8');
            mb_http_output('UTF-8');
        }

        // Set Locales
        if (isset($config['locale']) && $config['locale'])
        {
            setlocale(LC_ALL, $config['locale']);
            setlocale(LC_NUMERIC, 'C');
        }

        // Http request
        $input  = new Input($config);
        $output = new Output();

        // Get the route
        $router = new Router($loader->config('routes'));
        $route  = $router->route($input->uri());

        if ($route)
        {
            // Save services
            Services::add('load', $loader);
            Services::add('input', $input);
            Services::add('output', $output);

            // Call controller
            list($controller, $method, $params) = $route;
            self::$instance = new $controller();
            self::$instance->{$method}(...$params);
        }
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Controller 
     */
    public static function instance()
    {
        return self::$instance;
    }

    // -------------------------------------------------------------------------
}

/* End of file */