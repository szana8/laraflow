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
        if (!$this->laraflowInstance) {
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
    public function getStepName($state)
    {
        if (!isset($this->laraflowInstance()->getConfiguration()['steps'][$state]['text'])) {
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
     * Return the name of the stateId.
     *
     * @param $state
     * @return mixed
     * @throws \Exception
     */
    public function getFromStepNameById($stateId)
    {

        if (!isset($this->laraflowInstance()->getConfiguration()['steps'][$this->laraflowInstance()->getConfiguration()['transitions'][$stateId]['from']])) {
            return $stateId;
        }

        return $this->laraflowInstance()->getConfiguration()['steps'][$this->laraflowInstance()->getConfiguration()['transitions'][$stateId]['from']]['text'];
    }

    /**
     * Return the name of the stateId.
     *
     * @param $state
     * @return mixed
     * @throws \Exception
     */
    public function getToStepNameById($stateId)
    {

        if (!isset($this->laraflowInstance()->getConfiguration()['steps'][$stateId]['text'])) {
            return $stateId;
        }

        return $this->laraflowInstance()->getConfiguration()['steps'][$stateId]['text'];
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
