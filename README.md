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

## Documentation

1. [Installation](https://github.com/sugatasei/beerawecka/blob/master/doc/01-installation.md)
2. [Application flow](https://github.com/sugatasei/beerawecka/blob/master/doc/02-application-flow.md)
3. [URI Routing](https://github.com/sugatasei/beerawecka/blob/master/doc/03-uri-routing.md)
4. [Controller](https://github.com/sugatasei/beerawecka/blob/master/doc/04-controller.md)
5. Loading ressources
6. Input class
7. Output class
8. Services : A dependency container
9. Extending Core Class
