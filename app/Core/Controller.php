<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace App\Core;

/**
 * Controller
 * 
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Controller
{

    /**
     * @var \App\Core\Services 
     */
    private $services;

    // -------------------------------------------------------------------------

    public function __construct()
    {
        $this->services = Services::getInstance();
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Services 
     */
    protected function services()
    {
        return $this->services;
    }

    // -------------------------------------------------------------------------

    /**
     * @var \App\Core\Input 
     */
    protected function input()
    {
        return $this->services->input();
    }

    // -------------------------------------------------------------------------

    /**
     * @var \App\Core\Output 
     */
    protected function output()
    {
        return $this->services->output();
    }

    // -------------------------------------------------------------------------
}

/* End of file */
