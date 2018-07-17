<?php

namespace szana8\Laraflow\Events;


abstract class LaraflowEvents
{

    const PRE_TRANSITION = 'szana8.laraflow.pre_transition';

    const POST_TRANSITION = 'szana8.laraflow.post_transition';

    const CAN_TRANSITION = 'szana8.laraflow.can_transition';

}