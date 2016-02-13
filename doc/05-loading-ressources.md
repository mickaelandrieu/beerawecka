# Loading ressources

All classes are namespaced. If your installation is completed, composer will do
all the job.

The `Loader` class is used to load configuration files
or files not written in an object oriented format

This class is initialized automatically by the system
so there is no need to do it manually. All functionnalities are directly 
accessible within the controller.

## Loading configuration files

A configuration file return an array of settings.
By default, this files are located in the `app/config` directory.

You may load different configuration files depending
on the current environnement. The `ENV` constant is defined in
the `public/index.php` files.

To create an environnement specific configuration file, create or copy a
configuration file in `app/config/{ENV}/{FILNAME}.php`.

The system load a global configuration file then override properties
by the environnement configuration files.

Use the following function from controller :

    $this->load->config('filename');

*Do not use the `.php` extensions in the filename.*   
This function returns an empty array if the file is not found.

To retrieve to an item from the configuration file :

    $this->load->config('filename', 'item');

This functions returns `NULL` if the item is not found.

## Loading files

All files are loaded only once.
Use the following function from the controller :

    $this->load->file('filename');

*Do not use the `.php` extension in the filename.*