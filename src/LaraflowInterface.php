<?php

namespace szana8\Laraflow;

interface LaraflowInterface
{
    /**
     * Can the transition be applied on the underlying object.
     *
     * @param string $transition
     *
     * @return bool
     */
    public function can($transition);

    /**
     * Applies the transition on the underlying object.
     *
     * @param string $transition Transition to apply
     *
     * @return bool If the transition has been applied or not (in case of soft apply or rejected pre transition event)
     */
    public function apply($transition);

    /**
     * Returns the current state.
     *
     * @return string
     */
    public function getActualStep();

    /**
     * Returns the underlying object.
     *
     * @return object
     */
    public function getObject();

    /**
     * Return the current configuration object.
     *
     * @return mixed
     */
    public function getConfiguration();

    /**
     * Returns the possible transitions.
     *
     * @return array
     */
    public function getPossibleTransitions();

    /**
     * Return the fieldname of the model this statemachine operates on.
     *
     * @return string
     */
    public function getStateField();
}
