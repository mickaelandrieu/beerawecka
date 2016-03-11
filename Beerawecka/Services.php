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
abstract class Services
{

    /**
     * @var $this
     */
    private static $instance = null;

    /**
     * @var array
     */
    protected $services = [];

    // -------------------------------------------------------------------------

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
        if (!isset(self::$instance))
        {
            self::$instance = new static();
        }

        return self::$instance;
    }

    // -------------------------------------------------------------------------

    /**
     * Save an object
     * 
     * @param string $name
     * @param mixed $object
     */
    public function set($name, $object)
    {
        $this->services[$name] = $object;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Return if a service is available
     * 
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->services[$name]);
    }

    // -------------------------------------------------------------------------

    /**
     * Return a saved object
     * 
     * @return mixed
     */
    public function get($name)
    {
        return $this->services[$name] ?? null;
    }

    // -------------------------------------------------------------------------

    /**
     * Return all saved objects
     * 
     * @return array
     */
    public function all()
    {
        return $this->services;
    }

    // -------------------------------------------------------------------------

    /**
     * Delete an item
     * 
     * @param string $name
     * @return $this
     */
    public function delete($name)
    {
        if (isset($this->services[$name]))
        {
            unset($this->services[$name]);
        }

        return $this;
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