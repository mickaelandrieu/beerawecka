<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Sys\Core;

/**
 * Input
 *
 * 
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2015, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Input
{

    /**
     * HTTP vars
     * 
     * @var array
     */
    protected $params = [];

    /**
     * HTTP method
     * 
     * @var string
     */
    protected $method = NULL;

    /**
     * Is Ajax HTTP Request
     * 
     * @var boolean 
     */
    protected $is_ajax = NULL;

    /**
     * Is Client Request
     * 
     * @var boolean
     */
    protected $is_client = NULL;

    /**
     * Client IP
     * 
     * @var string
     */
    protected $ip = NULL;
    
    /**
     * Default IP
     * 
     * @var string
     */
    protected $default_ip = '';

    /**
     * The script was queried through the HTTPS protocol
     * 
     * @var boolean
     */
    protected $https = NULL;

    /**
     * Input URI string
     * 
     * @var string
     */
    protected $uri = NULL;

    /**
     * Preferences
     * 
     * @var array
     */
    protected $config = [
        'base_url'  => '',
        'uri_chars' => 'a-z 0-9~%.:_\-',
        'proxy_ips' => []
    ];

    /**
     * Request timestamp
     * 
     * @var int
     */
    protected $time = NULL;

    // -------------------------------------------------------------------------
    // Initialise
    // -------------------------------------------------------------------------

    public function __construct(array $config = [])
    {
        $this->init($config);
    }

    // -------------------------------------------------------------------------

    protected function init(array $config)
    {
        // Default config
        foreach ($config as $k => $v)
        {
            $this->config[$k] = $v;
        }

        // Client
        $this->is_client = (php_sapi_name() === 'cli' OR defined('STDIN'));

        if ($this->is_client)
        {
            return;
        }

        // Http methods
        $this->method = $this->server('REQUEST_METHOD');

        // Http params
        if ($this->method == 'GET')
        {
            $this->params = $_GET;
        }
        elseif ($this->method == 'POST')
        {
            $this->params = $_POST + $_GET;
        }
        elseif ($this->method == "PUT" || $this->method == 'DELETE')
        {
            parse_str(file_get_contents('php://input'), $this->params);
        }
    }

    // -------------------------------------------------------------------------
    // Server
    // -------------------------------------------------------------------------

    /**
     * Fetch an item from the SERVER array
     * 
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public function server($key = NULL, $default = NULL)
    {
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the HTTP method
     * 
     * @return type
     */
    public function method()
    {
        return $this->method;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses GET
     * 
     * @return bool
     */
    public function is_get()
    {
        return $this->method === 'GET';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses POST
     * 
     * @return bool
     */
    public function is_post()
    {
        return $this->method === 'POST';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses PUT
     * 
     * @return bool
     */
    public function is_put()
    {
        return $this->method === 'PUT';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses DELETE
     * 
     * @return bool
     */
    public function is_delete()
    {
        return $this->method === 'DELETE';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the request was made from an ajax query
     * 
     * @return type
     */
    public function is_ajax()
    {
        if ($this->is_ajax === NULL)
        {
            $this->is_ajax = $this->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
        }

        return $this->is_ajax;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the request was made from the command line
     * 
     * @return type
     */
    public function is_client()
    {
        return $this->is_client;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the script was queried through the HTTPS protocol
     * 
     * @return bool
     */
    public function is_secure()
    {
        // First call
        if ($this->https == NULL)
        {
            $https       = $this->server('HTTPS', '');
            $this->https = !empty($https) && $https !== 'off';
        }

        return $this->https;
    }

    // -------------------------------------------------------------------------

    /**
     * Fetch the IP Address
     * 
     * @return string
     */
    public function ip()
    {
        // First call
        if ($this->ip === NULL)
        {
            // Any proxy is defined
            if (empty($this->config['proxy_ips']))
            {
                $this->ip = $this->server('REMOTE_ADDR');
            }
            // The server is behind a reverse proxy
            else
            {
                $this->ip = $this->_ip_from_proxy();
            }

            // Set a default value if the IP is not valid
            if (!$this->_is_valid_ip($this->ip))
            {
                $this->ip = $this->default_ip;
            }
        }

        return $this->ip;
    }

    // -------------------------------------------------------------------------

    /**
     * Request timestamp
     * 
     * @return int
     */
    public function time()
    {
        if ($this->time === NULL)
        {
            $this->time = $this->server('REQUEST_TIME', time());
        }

        return $this->time;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if an ip is valid
     * 
     * @param string $ip
     * @param string $which ipv4 or ipv6
     * @return bool
     */
    protected function _is_valid_ip($ip)
    {
        return (bool) filter_var($ip, FILTER_VALIDATE_IP);
    }

    // -------------------------------------------------------------------------

    /**
     * Returns IP client through a reverse proxy
     * 
     * @return string|null
     */
    protected function _ip_from_proxy()
    {
        // List of header which is possible to find the client ip
        $headers = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_CLIENT_IP',
            'HTTP_X_CLIENT_IP',
            'HTTP_X_CLUSTER_CLIENT_IP'
        ];

        // Test each possibilities
        foreach ($headers as $header)
        {
            $ipPossible = $this->server($header);

            // An IP possible is found
            if ($ipPossible !== NULL)
            {
                // An array of IP
                if (strpos($ipPossible, ',') !== FALSE)
                {
                    $ipList = explode(',', $ipPossible);
                    foreach ($ipList as $ip)
                    {
                        $ip = str_replace(' ', '', $ip);
                        if ($this->_proxy_not_valid($ip))
                        {
                            return $ip;
                        }
                    }
                }
                // A single IP
                elseif ($this->_proxy_not_valid($ipPossible))
                {
                    return $ipPossible;
                }
            }
        }

        return $this->default_ip;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if an IP is valid and is not in the proxy IP array
     * 
     * @param string $ip
     * @return bool
     */
    protected function _proxy_not_valid($ip)
    {
        return !in_array($ip, $this->config['proxy_ips']) && $this->_is_valid_ip($ip);
    }

    // -------------------------------------------------------------------------
    // URL
    // -------------------------------------------------------------------------

    /**
     * Returns the HTTP protocole
     * 
     * @return string
     */
    public function protocole()
    {
        return $this->is_secure() ? 'https://' : 'http://';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the request URI
     * 
     * @return string
     */
    public function uri()
    {
        // First call
        if ($this->uri === NULL)
        {
            // Parse uri
            $this->uri = $this->is_client ? $this->_parse_argv() : $this->_parse_uri();

            // Remove invisible characters
            $uri = $this->_remove_invisible($this->uri);

            // Removes leading and trailing slash
            $this->uri = trim($this->uri, '/');

            // Filter URI for malicious characters
            $this->uri = $this->_filter_uri($this->uri);
        }

        return $this->uri;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the url of the application
     * 
     * @param string $uri
     * @return string
     */
    public function url($uri = '')
    {
        // First call
        if (!$this->config['base_url'])
        {
            $protocole                = $this->protocole();
            $host                     = $this->server('HTTP_HOST', '');
            $this->config['base_url'] = $protocole . $host;
        }

        return $this->config['base_url'] . '/' . ($uri ? ltrim($uri, '/') : '');
    }

    // -------------------------------------------------------------------------

    /**
     * Get current url
     *
     * @return string
     */
    public function current_url()
    {
        return $this->url($this->uri());
    }

    // -------------------------------------------------------------------------

    /**
     * Parse argv
     * 
     * @return string
     */
    protected function _parse_argv()
    {
        $args = array_slice($_SERVER['argv'], 1);
        return $args ? implode('/', $args) : '';
    }

    // -------------------------------------------------------------------------

    /**
     * Parse REQUEST_URI
     *
     * Will parse REQUEST_URI and automatically detect the URI from it,
     * while fixing the query string if necessary.
     *
     * @return	string
     */
    protected function _parse_uri()
    {
        // Gets request uri without query string
        $url = parse_url('http://dummy' . $_SERVER['REQUEST_URI']);
        $uri = isset($url['path']) ? $url['path'] : '';

        // Remove script name
        if (isset($_SERVER['SCRIPT_NAME'][0]))
        {
            if (strpos($uri, $_SERVER['SCRIPT_NAME']) === 0)
            {
                $uri = (string) substr($uri, strlen($_SERVER['SCRIPT_NAME']));
            }
            elseif (strpos($uri, dirname($_SERVER['SCRIPT_NAME'])) === 0)
            {
                $uri = (string) substr($uri, strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }
        }

        if ($uri === '/' OR $uri === '')
        {
            return '/';
        }

        return $this->_remove_relative_directory($uri);
    }

    // -------------------------------------------------------------------------

    /**
     * Remove relative directory (../) and multi slashes (///)
     *
     * Do some final cleaning of the URI and return it, currently only used in self::_parse_request_uri()
     *
     * @param	string	$uri
     * @return	string
     */
    protected function _remove_relative_directory($uri)
    {
        $uris = array();
        $tok  = strtok($uri, '/');
        while ($tok !== FALSE)
        {
            if ((!empty($tok) OR $tok === '0') && $tok !== '..')
            {
                $uris[] = $tok;
            }
            $tok = strtok('/');
        }

        return implode('/', $uris);
    }

    // -------------------------------------------------------------------------

    /**
     * Remove Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param	string
     * @param	bool
     * @return	string
     */
    protected function _remove_invisible($str)
    {
        $count  = 1;
        $remove = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';

        while ($count)
        {
            $str = preg_replace($remove, '', $str, -1, $count);
        }

        return $str;
    }

    // -------------------------------------------------------------------------

    /**
     * Remove not allowed characters
     * 
     * @param type $uri
     * @return type
     */
    protected function _filter_uri($uri)
    {
        // Nothing to do
        if (!$uri || !$this->config['uri_chars'])
        {
            return $uri;
        }

        return preg_replace("#[^{$this->config['uri_chars']}]+$#iu", "", $uri);
    }

    // -------------------------------------------------------------------------
    // Parameters
    // -------------------------------------------------------------------------

    /**
     * Check if a param exists
     *
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->params[$name]);
    }

    // -------------------------------------------------------------------------

    /**
     * Returns param
     *
     * @param string $name
     * @param string $default
     * @return mixed
     */
    public function & get($name, $default = NULL)
    {
        if (isset($this->params[$name]))
        {
            return $this->params[$name];
        }

        return $default;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns all params
     *
     * @return array
     */
    public function & all()
    {
        return $this->params;
    }

    // -------------------------------------------------------------------------

    /**
     * Set param
     *
     * @param string $name
     * @param string $value
     * @return \Bredala\Http\Input
     */
    public function set($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Delete a param
     *
     * @param string $name
     * @return \Bredala\Http\Input
     */
    public function delete($name)
    {
        if (isset($this->params[$name]))
        {
            unset($this->params[$name]);
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Count the number of params
     * 
     * @return int
     */
    public function count()
    {
        return count($this->params);
    }

    // -------------------------------------------------------------------------
}

/* End of file */