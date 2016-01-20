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
     * http://exemple.com/
     */
    public function index()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
    }

    // -------------------------------------------------------------------------

    /**
     * Custom 404
     * 
     * http://exemple.com/file_not_found
     */
    public function not_found()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
    }

    // -------------------------------------------------------------------------

    /**
     * Auto routing
     * 
     * http://exemple.com/welcome/hello
     */
    public function hello()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
    }

    // -------------------------------------------------------------------------

    /**
     * Method invisible from the router. Returns 404.
     * 
     * http://exemple.com/welcome/_invisible
     */
    public function _invisible()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
    }

    // -------------------------------------------------------------------------

    /**
     * Static route
     * 
     * http://exemple.com/alias
     */
    public function alias()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
    }

    // -------------------------------------------------------------------------

    /**
     * Dynamic route
     * 
     * http://exemple.com/regex/something
     */
    public function regex()
    {
        $this->output->add(__METHOD__ . PHP_EOL);
        $this->output->add("Parameters: " . join(', ', func_get_args()));
    }

    // -------------------------------------------------------------------------
}

/* End of file */