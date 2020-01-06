<?php

namespace szana8\Laraflow\Listeners;

use szana8\Laraflow\LaraflowCallbackInterface;
use szana8\Laraflow\Events\LaraflowTransitionEvents;

class LaraflowHistoryManager implements LaraflowCallbackInterface
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
            'transition' => $event->getTransition(),
            'to' => $sm->getActualStep()
        ]);
    }
}
