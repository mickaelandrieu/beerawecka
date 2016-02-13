# Input class

The `Input` class provides some
helpers for fetching input data and processing it.

This class is initialized automatically by the system
so there is no need to do it manually. All functionnalities are directly 
accessible within the controller:

    $this->input->method_name();

## Configuration

The class constructor accepts the following options:

- `base_url`: URL to your website root (with a trailing slash). If this option
is not set, Beerawecka will try to auto detect the URL using
`$_SERVER` informations. This option should be set for security.
- `index_page`: this will be your index.php file, unless you've renamed it to
something else. If you are using URL rewriting set this variable to empty.
Default: `index.php`.
- `url_suffix`: Allows you to add a suffix to all URLs generated
- `uri_chars`: Specifies which characters are permitted within your URLs.
Default: `a-z 0-9~%.:_\-/`
- `utf8`: Defines if PHP working with Unicode data. Default: `TRUE`.
- `proxy_ips`: If your web server is behind front servers, you can list
all proxy ips in this array. This option is important to find the IP address
from which the user is viewing the current page. Default value: `empty`.
- `default_ip`: The returned value if the user IP is not found or is not valid.

By default, Beerawecka use the configuration file `config.php` to set
this options on system loading.

## HTTP request data

The `Input` class comes with helper methods for handling
GET, PUT, DELETE or PATCH items.

The source of this data depends on the current HTTP request method.

### get($name, $default = NULL)

Returns an item.

The first option is for the data name (like `$_GET('name')`). The second is
the default value returned if the data is not found.

In the case of POST requests, this function searches for the data
in the POST stream then in the GET stream.

This function can return data by reference using this syntax :

    $my_item = & $this->input->get('my_item');

## has($name)

Returns TRUE if an item exists.

### all()

Returns an array of all items.

This function can return data by reference using this syntax :

    $my_items = & $this->input->all();

### set($name, $value)

Add or update an item.

### delete($name)

Delete an item.

### count()

Returns the number of items

## Url

### protocole()

Returns the current HTTP protocole (`https://` or `http:://`).

### uri()

Returns the request URI.

### site_url($uri)

Returns the site URL base on the `base_url` defined in the configuration.

The `index_page` will be added the `base_url`.

This function add the `$uri` option to the URL, plus the
`url_suffix` as set in your configuration.

You are encouraged to use this function any time you need
to generate a local URL so that your pages become more portable
in the event your URL changes.

### base_url($uri)

Returns the site URL base on the `base_url` defined in the configuration.

This function returns the same string as `site_url` without `index_page` and
`url_suffix` options.

This is usefull to create a link to a file, such an image.

### current_url()

Returns the full URL of the page being currently viewed.

## Server data

### server($name = NULL, $default = NULL)

Returns server and execution environment informations.

If the first option is not set, returns the `$_SERVER` array.
Else returns an item of the `$_SERVER` array.

The second option is the default value returned if the data is not found. 

### is_ajax()

Returns `TRUE` if the `HTTP_X_REQUESTED_WITH` has been sent.

### is_secure()

Returns `TRUE` if the application is called through the HTTPS protocol.

### user_agent()

Returns the user agent.

### ip()

Returns the IP of the current user. Returns the `default_ip` option from the
configuration if the IP is not found or if the IP is not valid.

## is_valid_ip($ip)

Returns if an ip is valid.

### time()

Returns the request timestamp.

## HTTP request method

### method($upper = TRUE)

Returns the HTTP request method (`$_SERVER['REQUEST_METHOD']`),
with the option to set it in uppercase or lowercase.

This method returns `CLI` if the application is called from the
command-line-interface.

### is_get()

Returns `TRUE` if the HTTP request method is `GET`.

### is_post()

Returns `TRUE` if the HTTP request method is `POST`.

### is_put()

Returns `TRUE` if the HTTP request method is `PUT`.

### is_delete()

Returns `TRUE` if the HTTP request method is `DELETE`.

### is_patch()

Returns `TRUE` if the HTTP request method is `PATCH`.

### is_client()

Returns `TRUE` if the application is called from the command line interface.
