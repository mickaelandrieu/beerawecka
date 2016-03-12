# Loading ressources

All classes are namespaced. If your installation is complete, composer 
autoloads all your classes.

The `Config` class is used to load configuration files.

This class is a service initialized automatically by the system 
so there is no need to do it manually. All functionnalities are directly 
accessible within the controller:

    $this->get->config();

## Loading configuration files

A configuration file return an array of settings.
By default, all settings files are located in the `app/config` directory.

You may load different configuration files depending
on the current environnement. The `ENV` constant is defined in
the `public/index.php` files.

To create an environnement specific configuration file, create or copy a
configuration file in `app/config/{ENV}/{FILNAME}.php`.

The system loads a global configuration file then overrides properties
by the environnement configuration files.

Use the following function from controller:

    $this->get->config()->get('filename');

*Do not use the `.php` extension in the filename.*   
This function returns an empty array if the file is not found.

To retrieve an item from the configuration file:

    $this->get->config()->get('filename', 'item');

This function returns `null` if the item is not found.