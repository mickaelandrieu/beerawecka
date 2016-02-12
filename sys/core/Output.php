<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

namespace Sys\Core;

/**
 * Output
 *
 * @author Mathieu Froehly <mathieu.froehly@gmail.com>
 * @copyright Copyright (c) 2015, Mathieu Froehly <mathieu.froehly@gmail.com>
 */
abstract class Output
{

    /**
     * @var array 
     */
    protected $status_code = [
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        422 => 'Unprocessable Entity',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    ];

    /**
     * @var array 
     */
    protected $mimes = [];

    /**
     * @var array 
     */
    protected $status = [];

    /**
     * @var array 
     */
    protected $headers = [];

    /**
     * Is headers sent
     * 
     * @var boolean 
     */
    protected $headers_sent = FALSE;

    /**
     * @var string 
     */
    protected $output = '';

    // -------------------------------------------------------------------------

    /**
     * Class constructor
     * 
     * @param array $mimes
     */
    public function __construct(array $mimes = [])
    {
        $this->mimes = $mimes;
        $this->status(200);
    }

    // -------------------------------------------------------------------------

    /**
     * Set the server status
     * 
     * @param int $code
     * @param string $text
     * @return \Bredala\Http\Output
     */
    public function status($code, $text = ''): self
    {
        is_int($code) OR $code = (int) $code;

        if (isset($this->status_code[$code]))
        {
            $text = $this->status_code[$code];
        }

        $this->status = [$code, $text];

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Set a server header
     * 
     * @param type $header
     * @param type $replace
     * @return \Bredala\Http\Output
     */
    public function header($header, $replace = TRUE): self
    {
        $this->headers[] = [$header, $replace];

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Set the content type
     * 
     * @param string $mime
     * @param string $charset
     * @return \Bredala\Http\Output
     */
    public function content_type($mime, $charset = NULL): self
    {
        $header = "Content-Type: ";
        $header .= $this->mimes[$mime][0] ?? $mime;
        $header .= $charset ? "; charset=" . $charset : "";

        $this->header($header, TRUE);

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Set the output string
     * 
     * @param string $output
     * @return \Bredala\Http\Output
     */
    public function set($output): self
    {
        $this->output = $output;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Append data ont the output string
     * 
     * @param string $output
     * @return \Bredala\Http\Output
     */
    public function add($output): self
    {
        $this->output .= $output;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Get the output string
     * 
     * @return string
     */
    public function get(): string
    {
        return $this->output;
    }

    // -------------------------------------------------------------------------

    /**
     * Processes and sends finalized output data
     * 
     * @return void
     */
    public function display()
    {
        if (!$this->get())
        {
            return;
        }

        if (!$this->headers_sent && !headers_sent())
        {
            $this->headers_sent = TRUE;

            header("Status: " . $this->status[0] . " " . $this->status[1], TRUE);
            foreach ($this->headers as $header)
            {
                header($header[0], $header[1]);
            }
        }

        echo $this->get();
    }

    // -------------------------------------------------------------------------
}

/* End of file */