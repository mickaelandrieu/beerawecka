<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Beerawecka;

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
    protected $method = null;

    /**
     * Is Ajax HTTP Request
     * 
     * @var boolean 
     */
    protected $is_ajax = null;

    /**
     * Client IP
     * 
     * @var string
     */
    protected $ip = null;

    /**
     * The script was queried through the HTTPS protocol
     * 
     * @var boolean
     */
    protected $https = null;

    /**
     * Input URI string
     * 
     * @var string
     */
    protected $uri = null;

    /**
     * Preferences
     * 
     * @var array
     */
    protected $config = [
        'base_url'   => '',
        'index_page' => 'index.php',
        'url_suffix' => '',
        'uri_chars'  => 'a-z 0-9~%.:_\-/',
        'utf8'       => true,
        'proxy_ips'  => [],
        'default_ip' => []
    ];

    /**
     * Request timestamp
     * 
     * @var int
     */
    protected $time = null;

    // -------------------------------------------------------------------------
    // Initialise
    // -------------------------------------------------------------------------

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->init($config);
    }

    // -------------------------------------------------------------------------

    /**
     * Init
     * 
     * @param array $config
     * @return void
     */
    protected function init(array $config)
    {
        // Default config
        foreach ($config as $k => $v)
        {
            $this->config[$k] = $v;
        }

        // Client
        if (php_sapi_name() === 'cli' OR defined('STDIN'))
        {
            $this->method = 'CLI';
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
        elseif ($this->method == "PUT" || $this->method == 'DELETE' || $this->method == 'PATCH')
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
     * @param string|null $name
     * @param mixed $default
     * @return mixed
     */
    public function server($name = null, $default = null)
    {
        if ($name)
        {
            return $_SERVER[$name] ?? $default;
        }
        return $_SERVER;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the HTTP method
     * 
     * @param bool $upper
     * @return string
     */
    public function method($upper = true): string
    {
        return $upper ? $this->method : strtolower($this->method);
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses GET
     * 
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses POST
     * 
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses PUT
     * 
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->method === 'PUT';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses DELETE
     * 
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->method === 'DELETE';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the HTTP request use uses DELETE
     * 
     * @return bool
     */
    public function isPatch(): bool
    {
        return $this->patch === 'DELETE';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the request was made from an ajax query
     * 
     * @return bool
     */
    public function isAjax(): bool
    {
        if ($this->is_ajax === null)
        {
            $this->is_ajax = $this->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
        }

        return $this->is_ajax;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the request was made from the command line
     * 
     * @return bool
     */
    public function isClient(): bool
    {
        return $this->method === 'CLI';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if the script was queried through the HTTPS protocol
     * 
     * @return bool
     */
    public function isSecure(): bool
    {
        // First call
        if ($this->https == null)
        {
            $https       = $this->server('HTTPS', '');
            $this->https = !empty($https) && $https !== 'off';
        }

        return $this->https;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the user agent
     * 
     * @return string
     */
    public function userAgent(): string
    {
        return $this->server('HTTP_USER_AGENT', '');
    }

    // -------------------------------------------------------------------------

    /**
     * Fetch the IP Address
     * 
     * @return string
     */
    public function ip(): string
    {
        // First call
        if ($this->ip === null)
        {
            // Any proxy is defined
            if (empty($this->config['proxy_ips']))
            {
                $this->ip = $this->server('REMOTE_ADDR');
            }
            // The server is behind a reverse proxy
            else
            {
                $this->ip = $this->ipFromProxy();
            }

            // Set a default value if the IP is not valid
            if (!$this->isValidIP($this->ip))
            {
                $this->ip = $this->config['default_ip'];
            }
        }

        return $this->ip;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns if an ip is valid
     * 
     * @param string $ip
     * @param string $which ipv4 or ipv6
     * @return bool
     */
    public function isValidIP($ip)
    {
        return (bool) filter_var($ip, FILTER_VALIDATE_IP);
    }

    // -------------------------------------------------------------------------

    /**
     * Request timestamp
     * 
     * @return int
     */
    public function time(): int
    {
        if ($this->time === null)
        {
            $this->time = $this->server('REQUEST_TIME', time());
        }

        return $this->time;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns IP client through a reverse proxy
     * 
     * @return string|null
     */
    protected function ipFromProxy()
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
            if ($ipPossible !== null)
            {
                // An array of IP
                if (strpos($ipPossible, ',') !== false)
                {
                    $ipList = explode(',', $ipPossible);
                    foreach ($ipList as $ip)
                    {
                        $ip = str_replace(' ', '', $ip);
                        if ($this->proxyNotValid($ip))
                        {
                            return $ip;
                        }
                    }
                }
                // A single IP
                elseif ($this->proxyNotValid($ipPossible))
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
    protected function proxyNotValid($ip): bool
    {
        return !in_array($ip, $this->config['proxy_ips']) && $this->isValidIP($ip);
    }

    // -------------------------------------------------------------------------
    // URL
    // -------------------------------------------------------------------------

    /**
     * Returns the HTTP protocole
     * 
     * @return string
     */
    public function protocole(): string
    {
        return $this->isSecure() ? 'https://' : 'http://';
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the request URI
     * 
     * @return string
     */
    public function uri(): string
    {
        // First call
        if ($this->uri === null)
        {
            // Parse uri
            $this->uri = $this->isClient() ? $this->parseArgv() : $this->parseUri();

            // Remove invisible characters
            $this->uri = $this->removeInvisible($this->uri);

            // Removes leading and trailing slash
            $this->uri = trim($this->uri, '/');

            // Filter URI for malicious characters
            $this->uri = $this->filterUri($this->uri);

            if ($this->config['url_suffix'])
            {
                $suffix    = preg_quote($this->config['url_suffix']);
                $this->uri = preg_replace("#{$suffix}$#", "", $this->uri);
            }
        }

        return $this->uri;
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the site base URL without the index_page and url_suffix
     * 
     * @return string
     */
    public function baseUrl($uri = ''): string
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
     * Returns the site URL including the index_page and url_suffix
     * 
     * @param string $uri
     * @return string
     */
    public function siteUrl($uri = ''): string
    {
        if ($uri)
        {
            $uri = '/' . $uri . $this->config['url_suffix'];
        }
        return $this->baseUrl($this->config['index_page'] . $uri);
    }

    // -------------------------------------------------------------------------

    /**
     * Returns the full URL of the page being currently viewed
     *
     * @return string
     */
    public function currentUrl(): string
    {
        return $this->siteUrl($this->uri());
    }

    // -------------------------------------------------------------------------

    /**
     * Parse argv
     * 
     * @return string
     */
    protected function parseArgv(): string
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
    protected function parseUri(): string
    {
        // Gets request uri without query string
        $url = parse_url('http://dummy' . $_SERVER['REQUEST_URI']);
        $uri = $url['path'] ?? '';

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

        return $this->removeRelativeDir($uri);
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
    protected function removeRelativeDir($uri): string
    {
        $uris = array();
        $tok  = strtok($uri, '/');
        while ($tok !== false)
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
     * Removes Invisible Characters
     *
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     *
     * @param	string
     * @param	bool
     * @return	string
     */
    public function removeInvisible($str): string
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
     * @param string $uri
     * @return string
     */
    protected function filterUri($uri): string
    {
        // Nothing to do
        if (!$uri || !$this->config['uri_chars'])
        {
            return $uri;
        }

        $regex = "#[^{$this->config['uri_chars']}]#i";

        if ($this->config['utf8'])
        {
            $regex .= 'u';
        }

        return preg_replace($regex, "", $uri);
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
    public function has($name): bool
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
    public function & get($name, $default = null)
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
    public function & all(): array
    {
        return $this->params;
    }

    // -------------------------------------------------------------------------

    /**
     * Set param
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function set($name, $value): self
    {
        $this->params[$name] = $value;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Delete a param
     *
     * @param string $name
     * @return $this
     */
    public function delete($name): self
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
    public function count(): int
    {
        return count($this->params);
    }

    // -------------------------------------------------------------------------
}

/* End of file */