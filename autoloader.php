<?php

/**
 * A simple autoloader function, PSR4 compliant.
 *
 * Namespace components are converted into sub-directories, all characters
 * are converted to lowercase.
 */

spl_autoload_register('Autoloader::class_loader');
include_once 'vendor/autoload.php';

class AutoLoader
{
    public static function class_loader(string $class) : void
    {
        // Adapt the path to your class directory
        // The prefix is different for cli invocations, so we check this first.
        if (php_sapi_name() == 'cli') {
            $prefix = getenv('PWD') . '/class';
        } else {
            $prefix = $_SERVER['DOCUMENT_ROOT'] . 'exercise/class';
        }

        $fullPath =
            $prefix .
            DIRECTORY_SEPARATOR .
            strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class)) . '.class.php';
        if (file_exists($fullPath)) {
            include "$fullPath";
        } else {
            die("Class $class not found in $fullPath" . PHP_EOL);
        }
    }
}

// vim:set expandtab tabstop=4 shiftwidth=4 softtabstop=4:
