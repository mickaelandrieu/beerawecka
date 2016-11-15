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
    // -------------------------------------------------------------------------

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Services* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
        parent::__construct();
        
        $config = new Config();
        
        $this->set('config', $config);
        $this->set('input', new Input($config->get('config')));
        $this->set('output', new Output($config->get('mimes')));
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Config 
     */
    public function config(): Config
    {
        return $this->get('config');
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Input 
     */
    public function input(): Input
    {
        return $this->get('input');
    }

    // -------------------------------------------------------------------------

    /**
     * @return \App\Core\Output 
     */
    public function output(): Output
    {
        return $this->get('output');
    }

    // -------------------------------------------------------------------------

    /**
     * @return array
     */
    public function route(): array
    {
        $router = new Router($this->config()->get('routes'));
        return $router->route($this->input()->uri());
    }

    // -------------------------------------------------------------------------
}

/* End of file */