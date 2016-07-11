<?php

namespace App\Entities;

use Finite\Loader\ArrayLoader;

trait StateMachineTrait
{
    /** @var ArrayLoader $loader  */
    private $loader;

    /** @var string $state */
    public $state;

    /**
     * Gets the object state.
     *
     * @return string
     */
    public function getFiniteState()
    {
        return $this->state;
    }

    /**
     * Sets the object state.
     *
     * @param string $state
     */
    public function setFiniteState($state)
    {
        $this->state = $state;
    }
}