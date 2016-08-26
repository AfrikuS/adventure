<?php

namespace App\Modules\Core\Lib;

class IdentityMap
{
    private static $_instance;

    private $map;

    private function __construct()
    {
        $this->map = [];
    }

    public static function getInstance(): IdentityMap
    {
        if(!isset(self::$_instance)){

            static::$_instance = new self();
        }

        return static::$_instance;
    }

    public function get($className, $id)
    {
        $key = $this->getKey($className, $id);

        if (isset($this->map[$key])) {

            return $this->map[$key];
        }

        return null;
    }

    public function add($object, $id)
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
