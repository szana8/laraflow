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

    'default' => [
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

];
