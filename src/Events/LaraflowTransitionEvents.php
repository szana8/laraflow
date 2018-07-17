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
    protected $configuration;

    /**
     * @var
     */
    protected $workflow;

    /**
     * @var bool
     */
    protected $rejected = false;

    /**
     * @param string $transition Name of the transition being applied
     * @param string $fromState State from which the transition is applied
     * @param array $configuration Configuration of the transition
     * @param LaraflowInterface $workflow
     */
    public function __construct($transition, $fromState, array $configuration, LaraflowInterface $workflow)
    {
        $this->transition = $transition;
        $this->fromState = $fromState;
        $this->configuration = $configuration;
        $this->workflow = $workflow;

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
     * @return LaraflowInterface
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
