# Extending Core Class

By default, Beerawecka does not directly use the class defined in 
the `\Sys\Core` namespace, but the `App\Core` namespace. Each system classes are
extended from the `\Sys\Core` namespace to the `App\Core` namespace.

You can customize all core functionalities in the `App\Core` classes.

You can update the framework replacing the `sys` folder without overiding your
customizations.