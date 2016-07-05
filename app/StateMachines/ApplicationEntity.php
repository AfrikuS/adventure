<?php

namespace App\StateMachines;

use App\Exceptions\SetPropertyToDomainEntityException;
use App\StateMachines\Exception\NotPropertyException;
use Finite\Loader\ArrayLoader;
use Finite\StatefulInterface;
use Finite\StateMachine\StateMachine;
use Illuminate\Database\Eloquent\Model;

abstract class ApplicationEntity implements StatefulInterface
{
    /** @var Model */
    protected $model;
    
    /** @var ArrayLoader $loader  */
    protected $loader;

    /** @var string $state */
    public $state;

    /** @var StateMachine */
    public $stateMachine;

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

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->state = $this->model->status;
        
        $this->stateMachine = new StateMachine;
        
        $this->loader     = new ArrayLoader(
            [
                'class'       => $this->getModelClass(),
                'states'      => $this->getStates(),
                'transitions' => $this->getTransitions(),
            ]
        );

        $this->loader->load($this->stateMachine);
        $this->stateMachine->setObject($this);
        $this->stateMachine->initialize();
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->model->getAttributes()))
        {
            return $this->model->{$key};
        }
        elseif ($this->model->relationLoaded($key)) 
        {
            return $this->model->getRelation($key);
        }
        else 
        {
            throw new NotPropertyException('Can\'t read property \'' . $key . '\' in ' . $this->getModelClass());
        }
    }

    public function __set($key, $value)
    {
        throw new SetPropertyToDomainEntityException('Can\'t write property value' . $key . ' in ' . $this->getModelClass());
    }
    
    protected abstract function getModelClass(): string;
    protected abstract function getStates(): array;
    protected abstract function getTransitions(): array;
}
