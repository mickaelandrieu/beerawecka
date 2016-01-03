<?php

/*
 * This work is licensed under
 * the Creative Commons Attribution 4.0 International License.
 * To view a copy of this license, visit
 * http://creativecommons.org/licenses/by/4.0/.
 */

$routes = [];

$routes['default']   = 'welcome';
$routes['not_found'] = 'welcome/not_found';

$routes['alias']     = 'welcome/alias';
$routes['regex(/:any)'] = 'welcome/regex$1';

return $routes;

/* End of file */