<?php

namespace App\Infrastructure;

class IdentityMap
{
    private static $_instance;

    private $map;

    private function __construct()
    {
        $this->map = [];
    }

    public static function getInstance()
    {
        if(!isset(self::$_instance)){

            static::$_instance = new self();
        }

        return static::$_instance;
    }

    public function getObject($className, $id)
    {
        $inst = static::getInstance();

        $key = $this->getKey($className, $id);

        if (isset($inst->map[$key])) {

            return $inst->map[$key];
        }

        return null;
    }

    public function addObject($object, $id)
    {
        $className = get_class($object);

        $key = $this->getKey($className, $id);

        static::getInstance()->map[$key] = $object;
    }
    
    private function getKey($className, $id) 
    {
        $key = $className .':' . $id;

        return $key;
    }
}
