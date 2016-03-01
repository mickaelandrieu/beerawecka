<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Beerawecka;

/**
 * Beerawecka
 *
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Beerawecka
{
    // -------------------------------------------------------------------------

    /**
     * Run an application
     */
    public static function run()
    {
        // Error reporting
        error_reporting(ENV === 'production' ? E_ERROR | E_WARNING | E_PARSE : -1);
        ini_set('display_errors', ENV === 'production' ? 0 : 1);

        // Class names
        $inputClass    = APPSPACE . '\Core\Input';
        $loaderClass   = APPSPACE . '\Core\Loader';
        $outputClass   = APPSPACE . '\Core\Output';
        $routerClass   = APPSPACE . '\Core\Router';
        $servicesClass = APPSPACE . '\Core\Services';

        // Loader
        $loader = new $loaderClass();

        // Global configuration
        $config = $loader->config('config');

        // UTF-8 support
        if (isset($config['utf8']) && $config['utf8'])
        {
            mb_internal_encoding('UTF-8');
            mb_http_output('UTF-8');
            mb_http_input('UTF-8');
            mb_language('uni');
            mb_regex_encoding('UTF-8');
            ob_start('mb_output_handler');
        }
        else
        {
            ob_start();
        }

        // Set Locales
        if (isset($config['locale']) && $config['locale'])
        {
            setlocale(LC_ALL, $config['locale']);
            setlocale(LC_NUMERIC, 'C');
        }

        // Http request
        $input  = new $inputClass($config);
        $output = new $outputClass($loader->config('mimes'));

        // Get the route
        $router = new $routerClass($loader->config('routes'));
        $route  = $router->route($input->uri());

        if ($route)
        {
            // Save services
            $services = $servicesClass::getInstance();
            $services->set('load', $loader);
            $services->set('input', $input);
            $services->set('output', $output);

            // Call controller
            list($class, $method, $params) = $route;
            $controller = new $class();
            $controller->{$method}(...$params);
        }

        $output->display(!$input->isClient());
        ob_end_flush();
    }

    // -------------------------------------------------------------------------
}

/* End of file */