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
     *
     * @var \App\Core\Services 
     */
    protected $get;

    // -------------------------------------------------------------------------

    public function __construct()
    {
        $this->get = Services::getInstance();
    }

    // -------------------------------------------------------------------------
}

/* End of file */
