<?php

/**
 * Class Autoloader
 */
class Autoloader
{
    /**
     * Loads the classes as called.
     *
     * @param $class
     * @return bool
     */
    public static function loader($class)
    {
        $file = __DIR__ . '/../app/' . str_replace('\\', '/', $class) . '.php';

        if (file_exists($file)) {
            include $file;

            if (class_exists($class)) {
                return true;
            }
        }

        return false;
    }
}

/**
 * Registers the autoloader for the application.
 */
spl_autoload_register('Autoloader::loader');