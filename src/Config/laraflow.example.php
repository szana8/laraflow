<?php

return [
    /*
    |--------------------------------------------------------------------------
    | State machine configuration
    |--------------------------------------------------------------------------
    |
    | This array is the default state machine configuration. The value is used
    | when the Eloquent object which responsible for the state machine try
    | to save the required configuration, but the user didn't add that.
    |
    | In most cicumstances one will define Class Constants in the model describing
    | the state and transitions and return the configuration array from the method
    | MyModel->getLaraflowStates() using those Class Constants.
    |
    */

    /*
    | Take the following class constant in you model for named access to workflow
    | elements. Change names and values as required. Leave space to add items in
    | between.
    |
    | // First worflow status values.
    | const Open = 1110;
    | const InProgress = 1120;
    | const Reopen = 1130;
    | const Resolved = 1140;
    | const Closed = 1150;
    |
    | // First work transitions
    | const Start = 1510;
    | const Stop = 1520;
    | const ResolveIssue = 1530;
    | const ReopenIssue = 1540;
    | const ResolveReopened = 1550;
    | const CloseIssue = 1560;
    | const CloseReopened = 1570;
    |
    | // Second workflow status values
    | const ToAssign = 2110
    | const Assigned = 2120
    | const WIP = 2130
    | const AwaitStatusResolve = 2140
    | const Finish = 2150
    | const ClosedPreparation = 2160
    |
    | // Second workflow transitions
    | const AssignPreparation = 2510
    | const SetWIP = 2520
    | const Wait = 2530
    | const FinishPreparation = 2540
    | const ClosePrepartion = 2550
    */

    'configuration' => [
        'default' => [
            'property_path' => 'status',
            'text' => 'Model status Workflow',
            'steps' => [
                1110 => [
                    'text' => 'Open',
                    'extra' => []
                ],
                1120 => [
                    'text' => 'In Progress',
                    'extra' => []
                ],
                1130 => [
                    'text' => 'Resolved',
                    'extra' => []
                ],
                1140 => [
                    'text' => 'Reopen',
                    'extra' => []
                ],
                1150 => [
                    'text' => 'Closed',
                    'extra' => []
                ],
            ],
            'transitions' => [
                1510 => [
                    'from' => 1110,
                    'to' => 1120,
                    'text' => 'Start Progress',
                    'extra' => [],
                    'callbacks' => [
                    /*  'pre' => [
                        'App\\TestPreCallback'
                    ],
                    'post' => [
                        'App\\TestPostCallback'
                    ] */],
                    'validators' => [
                    /*  [
                        'title' => 'numeric',
                        'assignee_id' => 'required'
                    ] */]
                ],
                1520 => [
                    'from' => 1120,
                    'to' => 1110,
                    'text' => 'Stop Progress',
                    'extra' => [],
                    'callbacks' => [
                        'pre' => [],
                        'post' => []
                    ],
                    'validators' => []
                ],
                1530 => [
                    'from' => 1120,
                    'to' => 1130,
                    'text' => 'Resolve Issue',
                    'extra' => [],
                    'callbacks' => [
                        'pre' => [],
                        'post' => []
                    ],
                    'validators' => []
                ],
                1540 => [
                    'from' => 1130,
                    'to' => 1140,
                    'text' => 'Reopen Issue',
                    'extra' => [],
                    'callbacks' => [
                        'pre' => [],
                        'post' => []
                    ],
                    'validators' => []
                ],
                1550 => [
                    'from' => 1140,
                    'to' => 1130,
                    'text' => 'Resolve Issue',
                    'extra' => [
                        'fromPort' => 'R',
                        'toPort' => 'R',
                        'points' => []
                    ],
                    'callbacks' => [
                        'pre' => [],
                        'post' => []
                    ],
                    'validators' => []
                ],
                1560 => [
                    'from' => 1120,
                    'to' => 1150,
                    'text' => 'Close Issue',
                    'extra' => [],
                    'callbacks' => [
                        'pre' => [],
                        'post' => []
                    ],
                    'validators' => []
                ],
                1570 => [
                    'from' => 1140,
                    'to' => 1150,
                    'text' => 'Close Issue',
                    'extra' => [],
                    'callbacks' => [
                        'pre' => [],
                        'post' => []
                    ],
                    'validators' => []
                ],
            ],
        ],
        'preperation' => [
            'property_path' => 'preperation_status',
            'text' => 'Preperation Status Workflow',
            'steps' => [
                // ...
            ],
            'transitions' => [
                // ...
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Laraflow validators
    |--------------------------------------------------------------------------
    |
    | This array is the list of the default validators. You can add these
    | to your state machine if you want to check one/more attribute(s)
    | before the status change. You can use ony Laravel validators.
    |
    */
    'validators' => [
        // 'required' => [
        //     'name' => 'Field required',
        //     'description' => 'The field under validation must be present in the input data and not empty.',
        //     'validator' => 'required',
        // ],

        // 'string' => [
        //     'name' => 'Field must be string',
        //     'description' => 'The field under validation must be a string. If you would like to allow the field to also be null, you should assign the nullable rule to the field.',
        //     'validator' => 'string',
        // ],

        // 'numeric' => [
        //     'name' => 'Field must be a number',
        //     'description' => 'The field under validation must be numeric.',
        //     'validator' => 'numeric',
        // ],

        // 'timezone' => [
        //     'name' => 'Field must be a valid timezone',
        //     'description' => 'The field under validation must be a valid timezone identifier according to the  timezone_identifiers_list PHP function.',
        //     'validator' => 'timezone',
        // ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Laraflow callbacks
    |--------------------------------------------------------------------------
    |
    | This array is the list of the post and pre function which can be assigned
    | to the transitions. Every callback has to be an array and each one of
    | them has three manadatory attributes. Name, description, class.
    |
    */
    'callbacks' => [
        // [
        //     'name' => 'Notify Users',
        //     'description' => 'Send an update email about the issue, when a user changed the status',
        //     'class' => 'App\\LaraflowCallbacks\\NotifyUsers'
        // ],
        // [
        //     'name' => 'Assign to Current User',
        //     'description' => 'Assign the issue to the current user',
        //     'class' => 'App\\LaraflowCallbacks\\AssignToCurrentUser'
        // ]
    ]
];
