<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Sys\Core;

/**
 * Services
 * 
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Services
{
    /**
     * @var array
     */
    protected static $services = [];

    // -------------------------------------------------------------------------

    /**
     * Save an object
     * 
     * @param string $name
     * @param mixed $object
     */
    public static function add($name, $object)
    {
        self::$services[$name] = $object;
    }

    // -------------------------------------------------------------------------

    /**
     * Get a saved object
     * 
     * @return mixed
     */
    public static function get($name)
    {
        return self::$services[$name] ?? NULL;
    }
    
    // -------------------------------------------------------------------------
    
    /**
     * Get a saved object
     * 
     * @return array
     */
    public static function all()
    {
        return self::$services;
    }
    
    // -------------------------------------------------------------------------
}

/* End of file */