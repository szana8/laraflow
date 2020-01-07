<?php

namespace szana8\Laraflow\Listeners;

use szana8\Laraflow\Events\LaraflowTransitionEvents;

class LaraflowHistoryManager
{
    /**
     * Handle the event.
     *
     * @param LaraflowTransitionEvents $event
     * @return void
     */
    public function handle(LaraflowTransitionEvents $event)
    {
        $sm = $event->getStateMachine();
        $model = $sm->getObject();

        $model->addHistoryLine([
            'field' => $sm->getStateField(),
            'transition' => $event->getTransition(),
            'to' => $sm->getActualStep()
        ]);
    }
}
