# Output class

The `Output` class provides some helpers to send the finalized output
to the browser.

This class is initialized automatically by the system
so there is no need to do it manually. All functionnalities are directly 
accessible within the controller:

    $this->output->method_name();

## Configuration

The class constructor has two parameters:

- The first is an associative array of HTTP status code.
The key is the code and the value its message.
- The second is an associative array of mimes types.
The key is a file type and the value is the corresponding mime types.

By default, Beerawecka use the configuration files `status.php` and
`mimes.php`.

## Headers

### status($code, $msg = '')

Set the HTTP status code.
The default status code is `200`.

You can use a custom message in the second optional parameter.

### contentType($mime, $charset = NULL)

Set the content type.

You have the choice:

1. Give the mime types: `$this->input->contentType('text/css')`
2. Give a file type: `$this->input->contentType('css')`.
In this example `css` is directly refering to `text/css` defined in the mime types
configuration file.

The second optional parameter is to set the charset.

### header(header, $replace = TRUE)

Set a server header.

The optional `replace` parameter indicates whether
the header should replace a previous similar header,
or add a second header of the same type.

## Output string

### set($output)

Set the output string.

### add($output)

Append data to the output string.

### get()

Get the output string.

### display($send_headers = TRUE)

This function is called automatically by the system after
the controller method execution.

This method does not send headers if they are already sent.
By default headers are not sent from the command-line-interface.

This method empties the output string at the end. So you are free
to use this method before the default call without disagreement.