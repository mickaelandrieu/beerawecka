<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace App\Core;

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
     * @var \App\Core\Config 
     */
    protected $config;

    /**
     * @var \App\Core\Input 
     */
    protected $input;

    /**
     * @var \App\Core\Output 
     */
    protected $output;

    /**
     * @var array
     */
    protected $route;

    // -------------------------------------------------------------------------

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Services* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        $this->config = new Config();
        $this->input  = new Input($this->config->get('config'));
        $this->output = new Output($this->config->get('mimes'));
        $router       = new Router($this->config->get('routes'));
        $this->route  = $router->route($this->input->uri());
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
     * @return \App\Core\Config 
     */
    function config(): Config
    {
        return $this->config;
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Input 
     */
    function input(): Input
    {
        return $this->input;
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Output 
     */
    function output(): Output
    {
        return $this->output;
    }

    // -------------------------------------------------------------------------

    /**
     * @return array
     */
    function route(): array
    {
        return $this->route;
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