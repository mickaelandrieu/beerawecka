# Service container

The `Services` class can store and retrieve objects.
All methods are static.

This class is used by the system to send objects already initialized
to the controller without using parameters in the controller constructor.

## add($name, $object)

Adds an object and names it.

    $w00t = new MySuperClass();
    Services::add('w00t', $w00t);

## get($name)

Gets an object by `$name`. Returns `NULL` if the object is not found.

    $w00t = Services::get('w00t);

## all($name)

Returns all objects in an array.