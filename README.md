# Beerawecka

Beerawecka is a PHP MVC micro-framework

## Features

- Model-View-Controller based system
- Powerful, light weight and easily customisable
- Dynamic and regex based routing
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
*This command convert PSR-0/4 autoloading to classmap. This is recommended especially for production.*

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

For the best security, all folders, excepted the `public/` folder,
should be placed above web root so that they are not directly accessible via a browser.

If you change this structure edit the constants includes in the `public/index.php` file.

### Configure your application

Open the `app/config/config.php` file with your favourite editor and follow
the instructions inside that file.

In production environnements change the `ENV` constant defined
in in the `public/index.php` file to hide errors to the user and to report only
the running errors.

### Test your installation

Simply call your website with your favourite browser.