<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Beerawecka;

/**
 * Loader
 * 
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2016, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Loader
{

    /**
     * @var array 
     */
    protected $config = [];

    /**
     * @var array 
     */
    protected $files = [];

    // -------------------------------------------------------------------------

    /**
     * Get config
     * 
     * @param string $name
     * @return array
     */
    public function config($name, $key = null)
    {
        if (!isset($this->config[$name]))
        {
            $path = APPPATH . 'config/';
            $file = $name . '.php';

            $app = $this->getConfig($path . $file);
            $env = $this->getConfig($path . ENV . '/' . $file);

            $this->config[$name] = $env + $app;
        }

        if ($key)
        {
            return $this->config[$key] ?? null;
        }

        return $this->config[$name];
    }

    // -------------------------------------------------------------------------

    /**
     * Load file
     * 
     * @param type $name
     * @return boolean
     */
    public function file($name)
    {
        if (!isset($this->files[$name]))
        {
            $file = $name . '.php';

            if (($this->files[$name] = is_file($file)))
            {
                require_once $file;
            }
        }

        return $this->files[$name];
    }

    // -------------------------------------------------------------------------

    /**
     * Get an array from a config file
     * 
     * @param string $file
     * @return array
     */
    protected function getConfig($file)
    {
        if (is_file($file))
        {
            $data = require $file;
            return is_array($data) ? $data : [];
        }

        return [];
    }

    // -------------------------------------------------------------------------
}

/* End of file */