<?php

namespace szana8\Laraflow\Events;


use szana8\Laraflow\LaraflowInterface;

class LaraflowTransitionEvents
{
    /**
     * @var string
     */
    protected $transition;

    /**
     * @var string
     */
    protected $fromState;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var StateMachineInterface
     */
    protected $workflow;

    /**
     * @var bool
     */
    protected $rejected = false;

    /**
     * @param string $transition Name of the transition being applied
     * @param string $fromState State from which the transition is applied
     * @param array $config Configuration of the transition
     * @param LaraflowInterface $workflow
     */
    public function __construct($transition, $fromState, array $config, LaraflowInterface $workflow)
    {
        $this->transition   = $transition;
        $this->fromState    = $fromState;
        $this->configuration= $config;
        $this->workflow     = $workflow;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransition()
    {
        return $this->transition;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->configuration;
    }

    /**
     * @return StateMachineInterface
     */
    public function getStateMachine()
    {
        return $this->workflow;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->fromState;
    }

    /**
     * @param bool $reject
     */
    public function setRejected($reject = true)
    {
        $this->rejected = (bool) $reject;
    }

    /**
     * @return bool
     */
    public function isRejected()
    {
        return $this->rejected;
    }

    public function convertToArray()
    {
        return [
            $this->transition,
            $this->fromState,
            $this->configuration,
            $this->workflow
        ];
    }
}