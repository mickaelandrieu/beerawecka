# Service container

The `Services` class can store and retrieve objects.
This class is a singleton, the `getInstance()` method gives access
to the unique instance of this class.

This class is used by the system to send objects already initialized
to the controller without using parameters in the controller constructor.

## set($name, $object)

Adds an object and names it.

    $w00t = new MySuperClass();
    Services::getInstance()->add('w00t', $w00t);

## has($name)

Returns `TRUE` if the service is found.

## get($name)

Gets an object by `$name`. Returns `NULL` if the object is not found.

    $w00t = Services::getInstance()->get('w00t);

## all($name)

Returns all objects in an array.

## delete($name)

Deletes an object.