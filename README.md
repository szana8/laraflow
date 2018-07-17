# Laraflow Workflow Package
Laraflow is a standard workflow package for Laravel Eloquent objects. You can define your steps, the transition between the them, callbacks, and validators.

### Installation (via composer)
```php
composer require szana8/Laraflow
```
You need to crate the neccessary table for the historical data:
```php
php artisan migrate
```

### Usage
#### Configuration array
You need a configuration array before you use the Laraflow workflow. 
For example:
```php
[
    'property_path' => 'last_step',
    'steps' => [
        [
            'text' => 'Open',
            'extra' => []
        ],
        [
            'text' => 'In Progress',
            'extra' => []
        ],
        [
            'text' => 'Resolved',
            'extra' => []
        ],
        [
            'text' => 'Reopen',
            'extra' => []
        ],
        [
            'text' => 'Closed',
            'extra' => []
        ],
    ],
    'transitions' => [
        [
            'from' =>  0,
            'to' => 1,
            'text' => 'Start Progress',
            'extra' => [],
            'callbacks' => [
                'pre' => [
                    'App\\TestPreCallback'
                ],
                'post' => [
                    'App\\TestPostCallback'
                ]
            ],
            'validators' => [
                [
                    'title' => 'numeric',
                    'assignee_id' => 'required'
                ]
            ]
        ],
        [
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
        [
            'from' => 1,
            'to' =>  2,
            'text' => 'Resolve Issue',
            'extra' => [],
            'callbacks' => [
                'pre' => [],
                'post' => []
            ],
            'validators' => []
        ],
        [
            'from' => 2,
            'to' =>  3,
            'text' => 'Reopen Issue',
            'extra' => [],
            'callbacks' => [
                'pre' => [],
                'post' => []
            ],
            'validators' => []
        ],
        [
            'from' => 3,
            'to' =>  2,
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
        [
            'from' => 1,
            'to' =>  4,
            'text' => 'Close Issue',
            'extra' => [],
            'callbacks' => [
                'pre' => [],
                'post' => []
            ],
            'validators' => []
        ],
        [
            'from' => 3,
            'to' =>  4,
            'text' => 'Close Issue',
            'extra' => [],
            'callbacks' => [
                'pre' => [],
                'post' => []
            ],
            'validators' => []
        ],
    ],
```
Than you have to add a function to your eloquent model called *getLaraflowStates* . 
This function has to return the array of the configuration.  

This configuration contains a sample workflow. Every step has a text which you can use to display them. 
All of the other necessary attributes has to be add to the extra array.  
The *property_path* contains the column name in the table which stores the actual step of the record.

You have to add the *Flowable* trait to your Eloquent model to use the workflow.  

You can use the getPossibleTransitions function to identify the list of the transitions which are available
from the actual step.
```php
    $model->getPossibleTransitions();
```
In your controller you can use the transition function to change your Eloquent object status.
```php
    try {
        $model->transition($step_key);
    } 
    catch (Exception $e) {
        return $e->getMessage();
    }
```
##### Credits
This library has been highly inspired by https://github.com/winzou/state-machine.
