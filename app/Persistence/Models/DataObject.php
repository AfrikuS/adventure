<?php

namespace App\Persistence\Models;

use App\Exceptions\NonPropertyException;
use App\Exceptions\Persistence\SetPropertyToDataObjectException;
use stdClass;

abstract class DataObject
{
    /** @var  stdClass */
    public $dataObject;

    public function __construct(stdClass $valueObject)
    {
        $this->dataObject = $valueObject;
    }


    public function __get($key)
    {
        if (in_array($key, $this->getAttributes()))
        {
            return $this->dataObject->{$key};
        }
//        elseif ($this->model->relationLoaded($key))
//        {
//            return $this->model->getRelation($key);
//        }
        else
        {
            throw new NonPropertyException('Can\'t read property \'' . $key . '\' in ' . self::class);
        }
    }

    public function __set($key, $value)
    {
        throw new SetPropertyToDataObjectException('Can\'t write property value' . $key . ' in ' . self::class);
    }

    abstract protected function getAttributes();

}
