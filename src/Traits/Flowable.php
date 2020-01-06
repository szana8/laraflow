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
     * @param mixed $name Name of the Statemachine within the configuration.
     * @return Laraflow
     * @throws \Exception
     */
    public function laraflowInstance($wf_name = 'default')
    {
        if (!$this->laraflowInstance[$wf_name]) {
            $this->laraflowInstance = new Laraflow($this, $this->getLaraflowStates($wf_name));
        }

        return $this->laraflowInstance[$wf_name];
    }

    /**
     * Return the actual state of
     * the object.
     *
     * @return mixed
     * @throws \Exception
     */
    public function flowStepIs($wf_name = 'default')
    {
        return $this->laraflowInstance($wf_name)->getActualStep();
    }

    /**
     * Apply the specified transition.
     *
     * @param $transition
     * @return mixed
     * @throws \Exception
     */
    public function transition($transition, $wf_name = 'default')
    {
        return $this->laraflowInstance($wf_name)->apply($transition);
    }

    /**
     * Return the name of the state.
     *
     * @param $state
     * @return mixed
     * @throws \Exception
     */
    public function getStepName($state, $wf_name = 'default')
    {
        if (!isset($this->laraflowInstance($wf_name)->getConfiguration()['steps'][$state]['text'])) {
            return $state;
        }

        return $this->laraflowInstance($wf_name)->getConfiguration()['steps'][$state]['text'];
    }

    /**
     * Return the actual step name.
     *
     * @return mixed
     */
    public function getActualStepName($wf_name = 'default')
    {
        return $this->laraflowInstance($wf_name)->getConfiguration()['steps'][$this->laraflowInstance($wf_name)->getActualStep()]['text'];
    }

    /**
     * Return the name of the stateId.
     *
     * @param $state
     * @return mixed
     * @throws \Exception
     */
    public function getFromStepNameById($stateId, $wf_name = 'default')
    {
        if (!isset($this->laraflowInstance($wf_name)->getConfiguration()['steps'][$this->laraflowInstance($wf_name)->getConfiguration()['transitions'][$stateId]['from']])) {
            return $stateId;
        }

        return $this->laraflowInstance($wf_name)->getConfiguration()['steps'][$this->laraflowInstance($wf_name)->getConfiguration()['transitions'][$stateId]['from']]['text'];
    }

    /**
     * Return the name of the stateId.
     *
     * @param $state
     * @return mixed
     * @throws \Exception
     */
    public function getToStepNameById($stateId, $wf_name = 'default')
    {
        if (!isset($this->laraflowInstance($wf_name)->getConfiguration()['steps'][$stateId]['text'])) {
            return $stateId;
        }

        return $this->laraflowInstance($wf_name)->getConfiguration()['steps'][$stateId]['text'];
    }

    /**
     * Check the transition is possible or not.
     *
     * @param $transition
     * @return mixed
     * @throws \Exception
     */
    public function transitionAllowed($transition, $wf_name = 'default')
    {
        return $this->laraflowInstance($wf_name)->can($transition);
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
    public function history()
    {
        return $this->getMorphHistoryData()->get()->each(function ($item, $key) {
            $item['fromStepName'] = $this->getFromStepNameById($item['transition']);
            $item['toStepName'] = $this->getToStepNameById($item['to']);
        });
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

        return $this->getMorphHistoryData()->create($transitionData);
    }
}
