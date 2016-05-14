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
class Services extends \Beerawecka\Services
{

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
        parent::__construct();
        $this->config = new Config();
        $this->input  = new Input($this->config->get('config'));
        $this->output = new Output($this->config->get('mimes'));
        $router       = new Router($this->config->get('routes'));
        $this->route  = $router->route($this->input->uri());
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Config 
     */
    public function config(): Config
    {
        return $this->config;
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Input 
     */
    public function input(): Input
    {
        return $this->input;
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Output 
     */
    public function output(): Output
    {
        return $this->output;
    }

    // -------------------------------------------------------------------------

    /**
     * @return array
     */
    public function route(): array
    {
        return $this->route;
    }

    // -------------------------------------------------------------------------
}

/* End of file */