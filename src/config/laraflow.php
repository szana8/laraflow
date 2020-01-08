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
    
    'configuration' => [
        /**
         * The property path is the column/attribute name in the table/model
         * which contains the array keys of the steps also shows the
         * current status of the record.
         */
        'property_path' => 'status',

        /**
         * The list of the steps which can be used in for the engine. Every
         * step has to be an array with at least two attributes. Text and
         * extra. The text shows the name of the steps. It will be
         * returns back as a kind of name, the extra contains
         * extra information for the front end engine.
         */
        'steps' => [],

        /**
         * The transitions array contains all of the transitions from a
         * step to another what you want to use. Every transition step
         * is an array. The array has to be a text attribute which is
         * a name of the transition, the from and to attributes are
         * the array keys from the steps array, the extra array
         * works the same than the steps. The validation array
         * contains all of the validation rules grouped by
         * column name. The callback contains the pre and
         * post callback functions.
         */
        'transitions' => [],
    ],
];    
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
    'validators' => []
    
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

    
  
/**
 * example configuration for multiple workflows in 1 model.
 *         'default' => [
 *           'property_path' => 'status',
 *           'text' => 'Model status Workflow',
 *           'steps' => [
 *               self::Open => [
 *                   'text' => 'Open',
 *                   'extra' => []
 *               ],
 *               self::InProgress => [
 *                   'text' => 'In Progress',
 *                   'extra' => []
 *               ],
 *               self::Resolved => [
 *                   'text' => 'Resolved',
 *                   'extra' => []
 *               ],
 *               self::Reopen => [
 *                   'text' => 'Reopen',
 *                   'extra' => []
 *               ],
 *               self::Closed => [
 *                   'text' => 'Closed',
 *                   'extra' => []
 *               ],
 *           ],
 *           'transitions' => [
 *               self::Start => [
 *                   'from' => self::Open,
 *                   'to' => self::InProgress,
 *                   'text' => 'Start Progress',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                      ],
 *                   'validators' => [
 *                       ]
 *               ],
 *               self::Stop => [
 *                   'from' => self::InProgress,
 *                   'to' => self::Open,
 *                   'text' => 'Stop Progress',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::ResolveIssue => [
 *                   'from' => self::InProgress,
 *                   'to' => self::Resolved,
 *                   'text' => 'Resolve Issue',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::ReopenIssue => [
 *                   'from' => self::Resolved,
 *                   'to' => self::Reopen,
 *                   'text' => 'Reopen Issue',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::ResolveReopened => [
 *                   'from' => self::Reopen,
 *                   'to' => self::Resolved,
 *                   'text' => 'Resolve Issue',
 *                   'extra' => [
 *                       'fromPort' => 'R',
 *                       'toPort' => 'R',
 *                       'points' => []
 *                   ],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::CloseIssue => [
 *                   'from' => self::InProgress,
 *                   'to' => self::Closed,
 *                   'text' => 'Close Issue',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::CloseReopened => [
 *                   'from' => self::Reopen,
 *                   'to' => self::Closed,
 *                   'text' => 'Close Issue',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *           ],
 *       ],
 *       'preperation' => [
 *           'property_path' => 'preperation_status',
 *           'text' => 'Preperation Status Workflow',
 *           'steps' => [
 *               self::ToAssign => [
 *                   'text' => 'To Assign',
 *                   'extra' => []
 *               ],
 *               self::Assigned => [
 *                   'text' => 'Assigned',
 *                   'extra' => []
 *               ],
 *               self::WIP => [
 *                   'text' => 'Work In Progress',
 *                   'extra' => []
 *               ],
 *               self::AwaitStatusResolve => [
 *                   'text' => 'Await default workflow to resolve',
 *                   'extra' => []
 *               ],
 *               self::Finish => [
 *                   'text' => 'Finish Prepartion',
 *                   'extra' => []
 *               ],
 *               self::ClosedPreparation => [
 *                   'text' => 'Preperation Finished',
 *                   'extra' => []
 *               ],
 *           ],
 *           'transitions' => [
 *               self::AssignPreparation => [
 *                   'from' => self::ToAssign,
 *                   'to' => self::Assigned,
 *                   'text' => 'Assign Preparation',
 *                   'extra' => [],
 *                   'callbacks' => [],
 *                   'validators' => []
 *               ],
 *               self::SetWIP => [
 *                   'from' => self::Assigned,
 *                   'to' => self::WIP,
 *                   'text' => 'Work in progress',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::Wait => [
 *                   'from' => self::WIP,
 *                   'to' => self::AwaitStatusResolve,
 *                   'text' => 'Resolve Issue',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *               self::FinishPreparation => [
 *                   'from' => self::AwaitStatusResolve,
 *                   'to' => self::Finish,
 *                   'text' => 'Finish preparation',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => [
 *                       [
 *                           'status' => 'gte:' . self::Resolved,
 *                       ]
 *                   ]
 *               ],
 *               self::ClosePrepartion => [
 *                   'from' => self::Finish,
 *                   'to' => self::ClosedPreparation,
 *                   'text' => 'Close preparation',
 *                   'extra' => [],
 *                   'callbacks' => [
 *                       'pre' => [],
 *                       'post' => []
 *                   ],
 *                   'validators' => []
 *               ],
 *           ],
 *       ],
 */
