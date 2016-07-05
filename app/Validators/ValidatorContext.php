<?php

namespace App\Validators;

use Exception;

/**
 * DTO-object for transfer data to command
 * Can read public attributes, but cannot mutate it
 */
class ValidatorContext
{
    public function __get($key)
    {
        if (property_exists($this, $key)) {
            return $this->{$key};
        }
        else {
            throw new Exception('Can\'t read property ' . $key . ' in ' . ValidatorContext::class);
        }
    }

    public function __set($key, $value)
    {
        return; // or throw an exception
    }
}
