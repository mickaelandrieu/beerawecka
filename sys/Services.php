<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Beerawecka;

/**
 * Services
 * 
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
class Services
{

    /**
     * @var $this
     */
    private static $instance;

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Services* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        
    }

    // -------------------------------------------------------------------------

    /**
     *  Instance of Services
     * 
     * @return $this
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    // -------------------------------------------------------------------------

    /**
     * Private clone method to prevent cloning
     * of the instance of the *Services* instance.
     */
    private function __clone()
    {
        
    }

    // -------------------------------------------------------------------------

    /**
     * Private unserialize method to prevent unserializing
     * of the *Services* instance.
     */
    private function __wakeup()
    {
        
    }

    // -------------------------------------------------------------------------
}

/* End of file */