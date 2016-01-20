# Beerawecka

Beerawecka is a PHP micro-framework that helps you to start powerful
web application with a very small footprint.

Beerawecka invokes an appropriate **controller method** from an HTTP request
and returns an HTTP response.

You don't always need an overkill solution like Symphony or other great projets.
Beerawecka only provides a minimal set of functionnalities to help you to write
fast web developpement.

You are free to use your favourite libraries to create your models and views, 
connecting your application to database, sending emails, etc.

You can have a look to our other project called
[Bredala](https://github.com/sugatasei/bredala) which offers you some of
those functionnalities.

## Features

- Powerful, light weight and easily customisable
- URL based routing
- Calling application via the URL or via the command-line-interface (CLI)
- Namespaced and PSR-4 compliant
- Autoloading class with composer

## Requirements

- PHP 5.6 with mbstring module
- [Composer](https://getcomposer.org/)

## Installation

### Download

To get Beerawecka you can :

- Clone this repo `git clone https://github.com/sugatasei/beerawecka.git`
- [Download the last release](https://github.com/sugatasei/beerawecka/archive/master.zip) and unzip the package.

### Install the autoloader with composer.

Navigate to your project on a terminal prompt, then run `composer install`.

*__Tip__: You can use the option `-o` while installing/updating composer to get a faster autoloader.*    
*This command converts PSR-0/4 autoloading to classmap. This is recommended especially for production.*

### Configure your webserver 

By default, an application has the following structure :

    test/
        app/
            config/
            controllers/
            core/
        sys/
            core/
        public/
            index.php
        vendor/

You should set your document root to the `public/` folder and your default index to `index.php`.

For the best security, all folders, except the `public/` folder,
should be placed above web root so that they are not directly accessible via a browser.

If you change this structure, edit the constants includes in the `public/index.php` file.

### Configure your application

Open the `app/config/config.php` file with your favourite editor and follow
the instructions inside that file.

In production environnements, change the `ENV` constant defined
in the `public/index.php` file to hide errors to the user and to report
the running errors only.

### Test your installation

Simply call your website with your favourite browser.

## Documentation

### URI Routing

By default, an URL string corresponds to a controller class/method.
The segments in an URI and follow this pattern :

    exemple.com/index.php/class/method/param1/param2

If the class is not present in the url, the default route is called.    
If the method is not present in the url, the default method is *index*

#### Removing the index.php file from URL

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

#### Custom routing rules

Routing rules are defined in your `app/config/routes.php` file.
You can write your own routing rules using regular expressions.

In a route, the array key contains the URI to be matched, while the array value
contains the destination it should be re-routed to.
The array key can be an exact uri or a regex expression.

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

#### Reserved routes

    $routes['default']   = 'welcome';

This is the default route if th URI contains no data.

    $routes['not_found'] = 'welcome/not_found';

This route is used if the router requested controller is not found.

### Controller

### Loading ressources

### Input class

### Output class

### Services : A dependency container

### Extending Core Class

