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
    protected $status_code = [];

    /**
     * @var array 
     */
    protected $mimes = [];

    /**
     * @var string 
     */
    protected $status = '';

    /**
     * @var string 
     */
    protected $content_type = '';

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
    public function __construct(array $status, array $mimes = [])
    {
        $this->status_code = $status;
        $this->mimes  = $mimes;
        $this->status(200);
        
        // Turn on output buffering
        ob_start();
    }

    // -------------------------------------------------------------------------

    /**
     * Set the server status
     * 
     * @param int $code
     * @param string $msg
     * @return $this
     */
    public function status($code, $msg = ''): self
    {
        if (!is_int($code))
        {
            $code = (int) $code;
        }

        if (!$code)
        {
            $this->status = '';
            return $this;
        }

        if (!$msg)
        {
            $msg = $this->status_code[$code] ?? '';
        }

        if ($msg)
        {
            $protocol     = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0';
            $this->status = $protocol . ' ' . $code . ' ' . $msg;
        }

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Set the content type
     * 
     * @param string $mime
     * @param string $charset
     * @return $this
     */
    public function contentType($mime, $charset = NULL): self
    {
        $header = "Content-Type: ";
        $header .= $this->mimes[$mime][0] ?? $mime;
        $header .= $charset ? "; charset=" . $charset : "";

        $this->content_type = $header;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Set a server header
     * 
     * @param type $header
     * @param type $replace
     * @return $this
     */
    public function header($header, $replace = TRUE): self
    {
        $this->headers[] = [$header, $replace];

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Set the output string
     * 
     * @param string $output
     * @return $this
     */
    public function set($output): self
    {
        $this->output = $output;

        return $this;
    }

    // -------------------------------------------------------------------------

    /**
     * Append data to the output string
     * 
     * @param string $output
     * @return $this
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
    public function display($send_headers = TRUE)
    {
        if (!$this->get())
        {
            return;
        }

        if ($send_headers && !$this->headers_sent && !headers_sent())
        {
            $this->headers_sent = TRUE;

            if ($this->status)
            {
                header($this->status, TRUE);
            }
            if ($this->content_type)
            {
                header($this->content_type, TRUE);
            }
            foreach ($this->headers as $header)
            {
                header($header[0], $header[1]);
            }
        }

        echo $this->get();
        $this->set('');
        
        // Flush the he output buffer and turn off output buffering
        ob_end_flush();
    }

    // -------------------------------------------------------------------------
}

/* End of file */