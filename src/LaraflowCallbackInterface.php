<?php

namespace szana8\Laraflow;

use szana8\Laraflow\Events\LaraflowTransitionEvents;

interface LaraflowCallbackInterface
{
    public function handle(LaraflowTransitionEvents $event);
}