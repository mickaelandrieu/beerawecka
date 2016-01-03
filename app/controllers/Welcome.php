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

    public function __construct()
    {
        parent::__construct();
        $this->output->content_type('text', 'UTF-8');
    }

    /**
     * Default
     * 
     * http://website.tld/
     */
    public function index()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add(print_r(func_get_args(), TRUE));
    }

    // -------------------------------------------------------------------------

    /**
     * Custom 404
     * 
     * http://website.tld/dfnkkdfn
     */
    public function not_found()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add(print_r(func_get_args(), TRUE));
    }

    // -------------------------------------------------------------------------

    /**
     * Auto routing
     * 
     * http://website.tld/welcome/hello
     */
    public function hello()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add(print_r(func_get_args(), TRUE));
    }

    // -------------------------------------------------------------------------

    /**
     * Method invisible from the router. Returns 404.
     * 
     * http://website.tld/welcome/_invisible
     */
    public function _invisible()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add(print_r(func_get_args(), TRUE));
    }

    // -------------------------------------------------------------------------

    /**
     * Static route
     * 
     * http://website.tld/alias
     */
    public function alias()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add(print_r(func_get_args(), TRUE));
    }

    // -------------------------------------------------------------------------

    /**
     * Dynamic route
     * 
     * http://website.tld/something
     */
    public function regex()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add(print_r(func_get_args(), TRUE));
    }

    // -------------------------------------------------------------------------
}

/* End of file */