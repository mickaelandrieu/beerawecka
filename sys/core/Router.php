<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Sys\Core;

/**
 * Router
 *
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Router
{

    /**
     * @var array
     */
    protected $wildcards = [
        ':all'  => '.*',
        ':any'  => '.+',
        ':num'  => '-?[0-9]+',
        ':hex'  => '[A-Fa-f0-9]+',
        ':uuid' => '[a-fA-F0-9]{8}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{4}-[a-fA-F0-9]{12}'
    ];

    /**
     * @var array 
     */
    protected $routes = [];

    // -------------------------------------------------------------------------

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    // -------------------------------------------------------------------------

    /**
     * Get the route
     * 
     * @param string $uri
     * @param boolean $on_error
     * @return boolean|array
     */
    public function route($uri, $on_error = FALSE)
    {
        $route = $this->_get_route($this->_parse_uri($uri));

        if ($route)
        {
            return $route;
        }

        if (!$on_error && isset($this->routes['not_found']))
        {
            return $this->route($this->routes['not_found'], TRUE);
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Get the route from uri
     * 
     * @param type $uri
     * @return boolean
     */
    protected function _get_route($uri)
    {
        $segments   = explode('/', $uri);
        $controller = 'App\Controllers';
        $method     = 'index';
        $params     = [];

        foreach ($segments as $key => $segment)
        {
            $controller .= '\\' . ucfirst($segment);

            if (class_exists($controller))
            {
                if (isset($segments[$key + 1]))
                {
                    $method = $segments[$key + 1];
                    $params = array_splice($segments, $key + 2);
                }

                if ($method[0] === '_' || !is_callable([$controller, $method]))
                {
                    return FALSE;
                }

                return [$controller, $method, $params];
            }
        }

        return FALSE;
    }

    // -------------------------------------------------------------------------

    /**
     * Parse uri
     * 
     * @param string $uri
     * @return string
     */
    protected function _parse_uri($uri)
    {
        // Default uri
        if (!$uri && isset($this->routes['default']))
        {
            return $this->routes['default'];
        }

        // Exact match
        if (isset($this->routes[$uri]))
        {
            return $this->routes[$uri];
        }

        // Regex match
        $wildcards = $this->wildcards;
        $search    = array_keys($wildcards);
        $replace   = array_values($wildcards);

        foreach ($this->routes as $key => $route)
        {
            $pattern = '#^' . str_replace($search, $replace, $key) . '$#';

            if (preg_match($pattern, $uri))
            {
                return $this->_back_reference($pattern, $uri, $route);
            }
        }

        return $uri;
    }

    // -------------------------------------------------------------------------

    /**
     * Back Reference
     * 
     * @param string $uri
     * @param string $route
     * @return string
     */
    protected function _back_reference($pattern, $uri, $route)
    {
        if (strpos($route, '$') !== FALSE && strpos($pattern, '(') !== FALSE)
        {
            $route = preg_replace($pattern, $route, $uri);
        }

        return $route;
    }

    // -------------------------------------------------------------------------
}

/* End of file */