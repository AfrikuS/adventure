<?php

namespace App\StateMachines;

use Finite\Loader\ArrayLoader;

class LoaderSingleton
{
    private static $loader = null;

    private function __constructor()
    {
        
    }
    
    public static function instance()
    {
        if (static::$loader === null) {
            static::$loader = new ArrayLoader();
        }
        
        return static::$loader;
    }
}
