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
    | This configuration array uses string based keys for the transistions. This 
    | allows for calling transistions like MyModel->transition('Start'). In the 
    | workflow history table the transition and to properties are also more
    | descriptive. Finally inserting steps and tranisitions does not invalidate 
    | the history table.
    |
    | In most cicumstances one will define Class Constants in the model describing
    | the state and transitions and return the configuration array from the method
    | MyModel->getLaraflowStates() using those Class Constants.
    |
    */

    'configuration' => [
        'property_path' => 'status',
        'steps' => [
            "Open" => [
                'text' => 'Open',
                'extra' => []
            ],
            "InProgress" => [
                'text' => 'In Progress',
                'extra' => []
            ],
            "Resolved" => [
                'text' => 'Resolved',
                'extra' => []
            ],
            "Reopen" => [
                'text' => 'Reopen',
                'extra' => []
            ],
            "Closed" => [
                'text' => 'Closed',
                'extra' => []
            ],
        ],
        'transitions' => [
            "Start" => [
                'from' => 0,
                'to' => 1,
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
            "Stop" => [
                'from' => 1,
                'to' => 0,
                'text' => 'Stop Progress',
                'extra' => [],
                'callbacks' => [
                    'pre' => [],
                    'post' => []
                ],
                'validators' => []
            ],
            "ResolveIssue" => [
                'from' => 1,
                'to' => 2,
                'text' => 'Resolve Issue',
                'extra' => [],
                'callbacks' => [
                    'pre' => [],
                    'post' => []
                ],
                'validators' => []
            ],
            "Reopen" => [
                'from' => 2,
                'to' => 3,
                'text' => 'Reopen Issue',
                'extra' => [],
                'callbacks' => [
                    'pre' => [],
                    'post' => []
                ],
                'validators' => []
            ],
            "ResolveReopened" => [
                'from' => 3,
                'to' => 2,
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
            "Close" => [
                'from' => 1,
                'to' => 4,
                'text' => 'Close Issue',
                'extra' => [],
                'callbacks' => [
                    'pre' => [],
                    'post' => []
                ],
                'validators' => []
            ],
            "CloseReopened" => [
                'from' => 3,
                'to' => 4,
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
