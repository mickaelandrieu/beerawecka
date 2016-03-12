# URI Routing

## Auto routing

By default, an URI string corresponds to a controller class/method.
URI segments in an URI follow this pattern:

    example.com/index.php/class/method/param1/param2

If the class is not found in the URL, the default route is called.   
If the method is not found in the URL, the default method is *index*.

The controllers can be organized into sub directories.

    example.com/subdir/class/method

## Removing the index.php file from URL

You can rewrite your URL's without this file with some rewriting rules 
in your web server.

If you have an Apache server, the `mod_rewrite` module is required.
Edit your `.htaccess` file with this rules:
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php?$1 [L]
    </IfModule>

If you have a Nginx server:

    # Default
    location / {
            try_files $uri $uri/ /index.php?$args;
    }
    # Main controller
    location = /index.php {
            # Your fastcgi directives
            # ...
    }


Set as empty the following configuration item: `index_page`
inside `config.php`.

## Custom routing rules

Routing rules are defined in your `routes.php` configuration file.
You can write your own routing rules using regular expressions.

In a route, the array key contains the URI to be matched, while the array value
contains the destination it should be re-routed to.
The array key can be an exact URI or a regex expression.

You can use the following wildcards to build the regex expressions:

- *:all* for an optional string
- *:any* for a required string
- *:num* for a required integer greater than zero
- *:hex* for an hexadecimal number
- *:uuid* for an universal unique identifier

Examples:

    // http://example.com/hello
    $routes['alias'] = 'welcome/world';
    // http://example.com/article/1
    $routes['article/([0-9]+)'] = 'welcome/article/$1';
    // http://example.com/article/1
    $routes['article/(:num)'] = 'welcome/article/$1';

## Reserved routes

### Default route

    $routes['default'] = 'welcome';

This is the default route if the URI contains no data.

### Route not found

    $routes['not_found'] = 'welcome/not_found';

This route is used if the router did not find the route corresponding to the URI.

### Option: URI conversion

    $routes['dash_to_underscore'] = true;

This is not exactly a route.
With this option enabled, the router replaces dashes *(-)*
with underscores *(_)* in the controller and method.
