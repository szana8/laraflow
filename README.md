# Laraflow Workflow Package
Laraflow is a standard workflow package for Laravel Eloquent objects. You can define your steps, 
the transition between the them, callbacks, and validators.  

[![StyleCI](https://github.styleci.io/repos/141295529/shield?branch=master)](https://github.styleci.io/repos/141295529)
### Installation (via composer)
You can install the package via composer. The package require Laravel 5.5 or higher
```php
composer require szana8/Laraflow
```
You need to crate the necessary table for the historical data:
```php
php artisan migrate
```
After Laravel 5.5 you don't need to manually add the service provider to the config/app.php.   

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
This configuration contains a sample workflow. Every step has a text which you can use to display them. 
All of the other necessary attributes has to be add to the extra array.  
The *property_path* contains the column name in the table which stores the actual step of the record.

## Usage

##### Step 1
First you need to add a new column to your Eloquent model table for example called: last_step/status or whatever you want.
```php
 $table->string('last_state');
 ```
In your config file *property_path* attribute has to be the same value than the column name. 
##### Step 2
You have to add the *Flowable* trait to your Eloquent model to use the workflow.  
```php
use szana8\Laraflow\Traits\Flowable;

class SampleClass extends Model {

    use Flowable;
    
 ```

##### Step 3
Than you have to add a function to your eloquent model called *getLaraflowStates()* .   
This function has to return the array of the configuration!  

##### Step 4
If you want to change the status of the Eloquent object you can use the 
```php
$object->transiton($new_status);
$object->save();
 ```
method which comes from the *Flowable* trait. The *$new_status* parameter is the value of 
the *key* attribute which comes from the *getPossibleTransitions()* function.  

## Events
You can listen to the 'global' events which fires in every status changes. 
```php
LaraflowEvents::PRE_TRANSITION
LaraflowEvents::POST_TRANSITION
LaraflowEvents::CAN_TRANSITION
 ```
The *PRE_TRANSITION* fires before the status change, the *POST_TRANSITION* fires after. 
The *CAN_TRANSITION* fires when the package checks the transition is possible from the 
actual step.   You can define callback(s) which will be call from the specified transition. 

## Validators
The package comes with a default validator class, which use the Laravel Validator class. 
You can add validation rules to the transitions, so the package can checks the Eloquent 
object attributes with the given rules before the transition. If the validation fails
throws a LaraflowValidatorException exception with the error message(s) array.

You can define your own validator if you create a class which implements the 
*LaraflowValidatorInterface*.

#### Credits
This library has been highly inspired by https://github.com/winzou/state-machine.

#### License

The package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).