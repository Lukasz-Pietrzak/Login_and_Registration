<?php

class Autoloading
{
    private static $path;
    public static function autoloader($path = null)
    {
        self::$path = $path;
        spl_autoload_register(function ($className) {
            // Convert namespace separators (\) to directory separators (/)
            $classFile = str_replace('\\', '/', $className) . '.php';
            if (file_exists($classFile)) {
                require_once $classFile;
            }else {
                require self::$path . $classFile;
            }

        });
    }
}