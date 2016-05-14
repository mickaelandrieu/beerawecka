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
    protected $services;

    /**
     * @var \App\Core\Input 
     */
    protected $input;

    /**
     * @var \App\Core\Output 
     */
    protected $output;

    // -------------------------------------------------------------------------

    public function __construct()
    {
        $this->services = Services::getInstance();
        $this->input    = $this->services->input();
        $this->output   = $this->services->output();
    }

    // -------------------------------------------------------------------------
}

/* End of file */
