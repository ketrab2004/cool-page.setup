<?php

spl_autoload_register( function($className) {

    $found = false;

	if ( strpos($className, 'Controller') !== false )
    {
		$found = includeIfExists($className, "./php/classes/controllers/");
	}
    elseif ( strpos($className, 'Service') !== false )
    {
		$found = includeIfExists($className, "./php/classes/services/");
	}
    else 
    {
        $found = includeIfExists($className, "./libraries/");
    }

    if (!$found) // try to find class in miscellaneous
    {
        $found = includeIfExists($className, "./php/classes/misc/");
    }

	if (!$found) // did not find and didn't find in misc so error
    {
        throw new Exception("Could not find class $className", 404);
    }
} );

function includeIfExists(string $class, string $path): bool
{
    $exists = file_exists("$path$class.php");
    if ($exists)
    {
        include("$path$class.php");
    }
    return $exists;
}