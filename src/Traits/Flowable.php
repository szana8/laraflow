<?php

namespace szana8\Laraflow\Traits;

use szana8\Laraflow\Laraflow;
use szana8\Laraflow\LaraflowHistory;

trait Flowable
{
    /**
     * StateMachine.
     */
    protected $laraflowInstance = [];

    /**
     * Create a singleton StateMachine instance form the specified config.
     *
     * @param  mixed  $name  Name of the Statemachine within the configuration.
     * @return Laraflow
     *
     * @throws \Exception
     */
    public function laraflowInstance($sm_name = 'default')
    {
        if (! isset($this->laraflowInstance[$sm_name])) {
            $this->laraflowInstance[$sm_name] = new Laraflow($this, $this->getLaraflowStates($sm_name));
        }

        return $this->laraflowInstance[$sm_name];
    }

    /**
     * Return the actual state of
     * the object.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function flowStepIs($sm_name = 'default')
    {
        return $this->laraflowInstance($sm_name)->getActualStep();
    }

    /**
     * Apply the specified transition.
     *
     * @param  $transition
     * @return mixed
     *
     * @throws \Exception
     */
    public function transition($transition, $sm_name = 'default')
    {
        return $this->laraflowInstance($sm_name)->apply($transition);
    }

    /**
     * Return the name of the state.
     *
     * @param  $state
     * @return mixed
     *
     * @throws \Exception
     */
    public function getStepName($state, $sm_name = 'default')
    {
        if (! isset($this->laraflowInstance($sm_name)->getConfiguration()['steps'][$state]['text'])) {
            return $state;
        }

        return $this->laraflowInstance($sm_name)->getConfiguration()['steps'][$state]['text'];
    }

    /**
     * Return the actual step name.
     *
     * @return mixed
     */
    public function getActualStepName($sm_name = 'default')
    {
        return $this->laraflowInstance($sm_name)->getConfiguration()['steps'][$this->laraflowInstance($sm_name)->getActualStep()]['text'];
    }

    /**
     * Return the name of the stateId.
     *
     * @param  $state
     * @return mixed
     *
     * @throws \Exception
     */
    public function getFromStepNameById($stateId, $sm_name = 'default')
    {
        if (! isset($this->laraflowInstance($sm_name)->getConfiguration()['steps'][$this->laraflowInstance($sm_name)->getConfiguration()['transitions'][$stateId]['from']])) {
            return $stateId;
        }

        return $this->laraflowInstance($sm_name)->getConfiguration()['steps'][$this->laraflowInstance($sm_name)->getConfiguration()['transitions'][$stateId]['from']]['text'];
    }

    /**
     * Return the name of the stateId.
     *
     * @param  $state
     * @return mixed
     *
     * @throws \Exception
     */
    public function getToStepNameById($stateId, $sm_name = 'default')
    {
        if (! isset($this->laraflowInstance($sm_name)->getConfiguration()['steps'][$stateId]['text'])) {
            return $stateId;
        }

        return $this->laraflowInstance($sm_name)->getConfiguration()['steps'][$stateId]['text'];
    }

    /**
     * Check the transition is possible or not.
     *
     * @param  $transition
     * @return mixed
     *
     * @throws \Exception
     */
    public function transitionAllowed($transition, $sm_name = 'default')
    {
        return $this->laraflowInstance($sm_name)->can($transition);
    }

    /**
     * Return the transition history of the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    protected function getMorphHistoryData()
    {
        return $this->morphMany(LaraflowHistory::class, 'flowable');
    }

    /**
     * Add the step name to the morphed data from the history table,
     * to make it more readable.
     *
     * @return mixed
     */
    public function history($sm_name = 'default')
    {
        $laraflowField = $this->laraflowInstance($sm_name)->getConfiguration()['property_path'];

        return $this->getMorphHistoryData()->where('field', $laraflowField)->get()->each(function ($item, $key) use ($sm_name) {
            $item['fromStepName'] = $this->getFromStepNameById($item['transition'], $sm_name);
            $item['toStepName'] = $this->getToStepNameById($item['to'], $sm_name);
        });
    }

    /**
     * Add a history line to the table with the model name and record id.
     *
     * @param  array  $transitionData
     * @return mixed
     */
    public function addHistoryLine(array $transitionData)
    {
        $transitionData['user_id'] = auth()->id();

        return $this->getMorphHistoryData()->create($transitionData);
    }
}
