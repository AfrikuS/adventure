<?php

namespace App\Modules\Core\Lib;

class CatalogsIdentityMap
{
    private static $_instance;

    private $map;

    private function __construct()
    {
        $this->map = [];
    }

    public static function getInstance(): CatalogsIdentityMap
    {
        if (! isset(self::$_instance)){

            static::$_instance = new self();
        }

        return static::$_instance;
    }

    public function getCatalog($className)
    {
        $key = $className;

        if (isset($this->map[$key])) {

            return $this->map[$key];
        }

        return null;
    }

    public function addCatalog($catalog)
    {
        $className = class_basename($catalog);

        $key = $className;

        static::getInstance()->map[$key] = $catalog;
    }
}
