<?php

namespace szana8\Laraflow\Traits;

use szana8\Laraflow\Events\LaraflowEvents;
use szana8\Laraflow\Listeners\LaraflowHistoryManager;

trait EventMap
{
    /**
     * All of the Laraflow event / listener mappings.
     *
     * @var array
     */
    protected $events = [
        LaraflowEvents::POST_TRANSITION => [
            LaraflowHistoryManager::class,
        ],

        LaraflowEvents::PRE_TRANSITION => [
            //
        ],

        LaraflowEvents::CAN_TRANSITION => [
            //
        ]
    ];
}
