<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace App\Controllers;

/**
 * Welcome
 *
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
class Welcome extends \App\Core\Controller
{

    /**
     * Default
     * 
     * http://website.tld/
     */
    public function index()
    {
        header("Content-Type: text/plain");
        echo __METHOD__ . PHP_EOL;
        print_r(func_get_args());
    }

    // -------------------------------------------------------------------------

    /**
     * Custom 404
     * 
     * http://website.tld/dfnkkdfn
     */
    public function not_found()
    {
        header("Content-Type: text/plain");
        echo __METHOD__ . PHP_EOL;
        print_r(func_get_args());
    }

    // -------------------------------------------------------------------------

    /**
     * Auto routing
     * 
     * http://website.tld/welcome/hello
     */
    public function hello()
    {
        header("Content-Type: text/plain");
        echo __METHOD__ . PHP_EOL;
        print_r(func_get_args());
    }

    // -------------------------------------------------------------------------

    /**
     * Method invisible from the router. Returns 404.
     * 
     * http://website.tld/welcome/_invisible
     */
    public function _invisible()
    {
        header("Content-Type: text/plain");
        echo __METHOD__ . PHP_EOL;
        print_r(func_get_args());
    }

    // -------------------------------------------------------------------------

    /**
     * Static route
     * 
     * http://website.tld/alias
     */
    public function alias()
    {
        header("Content-Type: text/plain");
        echo __METHOD__ . PHP_EOL;
        print_r(func_get_args());
    }

    // -------------------------------------------------------------------------

    /**
     * Dynamic route
     * 
     * http://website.tld/something
     */
    public function regex()
    {
        header("Content-Type: text/plain");
        echo __METHOD__ . PHP_EOL;
        print_r(func_get_args());
    }

    // -------------------------------------------------------------------------
}

/* End of file */