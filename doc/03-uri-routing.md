# URI Routing

By default, an URL string corresponds to a controller class/method.
The segments in an URI and follow this pattern :

    exemple.com/index.php/class/method/param1/param2

If the class is not present in the url, the default route is called.    
If the method is not present in the url, the default method is *index*

## Removing the index.php file from URL

You can rewrite your URL's without this file with some rewriting rules 
in your web server.

If you have an Apache server, the `mod_rewrite` module is required.
Edit your `.htaccess` file with this rules :
    
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteRule ^(.*)$ index.php?$1 [L]
    </IfModule>

If you have a Nginx server :

    # Default
    location / {
            try_files $uri $uri/ /index.php?$args;
    }
    # Main controller
    location = /index.php {
            # Your fastcgi directives
            # ...
    }


*Do not forget to set empty the following configuration item : `index_page`*
*contains inside `app/config/config.php`.*

## Custom routing rules

Routing rules are defined in your `app/config/routes.php` file.
You can write your own routing rules using regular expressions.

In a route, the array key contains the URI to be matched, while the array value
contains the destination it should be re-routed to.
The array key can be an exact URI or a regex expression.

You can use the following wildcards to build the regex expressions :

- *:all* for an optional string
- *:any* for a required string
- *:num* for a required integer greater than zero
- *:hex* for an hexadecimal number
- *:uuid* for an universal unique identifier

Exemples :

    // http://exemple.com/hello
    $routes['alias'] = 'welcome/world';
    // http://exemple.com/article/1
    $routes['article/([0-9]+)'] = 'welcome/article/$1';
    // http://exemple.com/article/1
    $routes['article/(:num)'] = 'welcome/article/$1';

## Reserved routes

    $routes['default'] = 'welcome';

This is the default route if th URI contains no data.

    $routes['not_found'] = 'welcome/not_found';

This route is used if the router requested controller is not found.

    $routes['dash_to_underscore'] = TRUE;

This is not exactly a route.
With this option enabled replaces dashes *(-)* with underscores *(_)*
in the controller and method URI segments.
