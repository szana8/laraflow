<?php

namespace szana8\Laraflow\Traits;

use App\IssueState;
use szana8\Laraflow\Laraflow;
use szana8\Laraflow\LaraflowHistory;

trait Flowable
{
    /**
     * StateMachine
     */
    protected $flowMachine;

    /**
     * Create a singleton StateMachine instance form the specified config
     *
     * @return Laraflow
     * @throws \Exception
     */
    public function flowMachine()
    {
        if ( ! $this->flowMachine ) {
            $this->flowMachine = new Laraflow($this, $this->getLaraflowStates());
        }

        return $this->flowMachine;
    }

    /**
     * Return the actual state of
     * the object
     *
     * @return mixed
     * @throws \Exception
     */
    public function flowStepIs()
    {
        return $this->flowMachine()->getActualStep();
    }

    /**
     * Apply the specified transition
     *
     * @param $transition
     * @return mixed
     * @throws \Exception
     */
    public function transition($transition)
    {
        return $this->flowMachine()->apply($transition);
    }

    /**
     * Return the name of the state.
     *
     * @param $state
     * @return mixed
     * @throws \Exception
     */
    protected function getStepName($state)
    {
        if (!isset ($this->flowMachine()->getConfiguration()['steps'][$state]['text']))
            return $state;

        return $this->flowMachine()->getConfiguration()['steps'][$state]['text'];
    }

    /**
     * Check the transition is possible or not
     *
     * @param $transition
     * @return mixed
     * @throws \Exception
     */
    public function transitionAllowed($transition)
    {
        return $this->flowMachine()->can($transition);
    }

    /**
     * Return the transition history of the model
     *
     * @return mixed
     */
    public function history()
    {
        return $this->hasMany(LaraflowHistory::class, 'model_id', 'id');
    }

    /**
     * Add a history line to the table with the model name and record id
     *
     * @param array $transitionData
     * @return mixed
     */
    public function addHistoryLine(array $transitionData)
    {
        $this->save();

        $transitionData['user_id'] = auth()->id();
        $transitionData['model_name'] = get_class();

        return $this->history()->create($transitionData);
    }
}