<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Sys\Core;

/**
 * Controller
 * 
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Controller
{

    /**
     * @var \App\Core\Loader 
     */
    public $load;

    /**
     * @var \App\Core\Input
     */
    public $input;
    
    /**
     * @var \App\Core\Output
     */
    public $output;

    // -------------------------------------------------------------------------

    /**
     * Save the controller instance
     * Get saved objects
     * Autoload helpers
     */
    public function __construct()
    {
        foreach (Services::all() as $name => $obj)
        {
            $this->{$name} = $obj;
        }
        $this->_autoload();
    }

    // -------------------------------------------------------------------------

    /**
     * Autoload helpers
     */
    protected function _autoload()
    {
        $autoload = $this->load->config('autoload');

        if (isset($autoload['helpers']))
        {
            foreach ($autoload['helpers'] as $file)
            {
                $this->load->helper($file);
            }
        }
    }

    // -------------------------------------------------------------------------
}

/* End of file */