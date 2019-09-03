<?php

namespace szana8\Laraflow\Traits;

use szana8\Laraflow\Laraflow;
use szana8\Laraflow\LaraflowHistory;

trait Flowable
{
    /**
     * StateMachine.
     */
    protected $laraflowInstance;

    /**
     * Create a singleton StateMachine instance form the specified config.
     *
     * @return Laraflow
     * @throws \Exception
     */
    public function laraflowInstance()
    {
        if (! $this->laraflowInstance) {
            $this->laraflowInstance = new Laraflow($this, $this->getLaraflowStates());
        }

        return $this->laraflowInstance;
    }

    /**
     * Return the actual state of
     * the object.
     *
     * @return mixed
     * @throws \Exception
     */
    public function flowStepIs()
    {
        return $this->laraflowInstance()->getActualStep();
    }

    /**
     * Apply the specified transition.
     *
     * @param $transition
     * @return mixed
     * @throws \Exception
     */
    public function transition($transition)
    {
        return $this->laraflowInstance()->apply($transition);
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
        if (! isset($this->laraflowInstance()->getConfiguration()['steps'][$state]['text'])) {
            return $state;
        }

        return $this->laraflowInstance()->getConfiguration()['steps'][$state]['text'];
    }

    /**
     * Return the actual step name.
     *
     * @return mixed
     */
    public function getActualStepName()
    {
        return $this->laraflowInstance()->getConfiguration()['steps'][$this->laraflowInstance()->getActualStep()]['text'];
    }

    /**
     * Check the transition is possible or not.
     *
     * @param $transition
     * @return mixed
     * @throws \Exception
     */
    public function transitionAllowed($transition)
    {
        return $this->laraflowInstance()->can($transition);
    }

    /**
     * Return the transition history of the model.
     *
     * @return mixed
     */
    public function history()
    {
        return $this->hasMany(LaraflowHistory::class, 'model_id', 'id');
    }

    /**
     * Add a history line to the table with the model name and record id.
     *
     * @param array $transitionData
     * @return mixed
     */
    public function addHistoryLine(array $transitionData)
    {
        $transitionData['user_id'] = auth()->id();
        $transitionData['model_name'] = get_class();

        return $this->history()->create($transitionData);
    }
}
