# Loading ressources

All classes are namespaced. If your installation is complete, composer 
autoloads all your classes.

The `Loader` class is used to load configuration files
or files not written in an object oriented format.

This class is initialized automatically by the system
so there is no need to do it manually. All functionnalities are directly 
accessible within the controller:

    $this->load->method_name();

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

    $this->load->config('filename');

*Do not use the `.php` extension in the filename.*   
This function returns an empty array if the file is not found.

To retrieve an item from the configuration file:

    $this->load->config('filename', 'item');

This function returns `NULL` if the item is not found.

## Loading files

All files are loaded once only.
Use the following function from the controller:

    $this->load->file('filename');

*Do not use the `.php` extension in the filename.*