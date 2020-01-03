# Laraflow Workflow Package

Laraflow is a standard workflow package for Laravel Eloquent objects. You can define your steps,
the transition between the them, callbacks, and validators.

[![Latest Stable Version](https://poser.pugx.org/szana8/laraflow/v/stable)](https://packagist.org/packages/szana8/laraflow)
[![StyleCI](https://github.styleci.io/repos/141295529/shield?branch=master)](https://github.styleci.io/repos/141295529)
[![Total Downloads](https://poser.pugx.org/szana8/laraflow/downloads)](https://packagist.org/packages/szana8/laraflow)
[![Monthly Downloads](https://poser.pugx.org/szana8/laraflow/d/monthly)](https://packagist.org/packages/szana8/laraflow)
[![Daily Downloads](https://poser.pugx.org/szana8/laraflow/d/daily)](https://packagist.org/packages/szana8/laraflow)
[![License](https://poser.pugx.org/szana8/laraflow/license)](https://packagist.org/packages/szana8/laraflow)

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

You need a configuration array before you use the Laraflow workflow. If you want to try the package you can generate an example configuration file with the following command.

```
php artisan vendor:publish --provider="szana8\Laraflow\LaraflowServiceProvider"
```

This configuration contains a sample workflow. Every step has a text which you can use to display them.
All of the other necessary attributes has to be add to the extra array.  
The _property_path_ contains the column name in the table which stores the actual step of the record.

## Usage

##### Step 1

First you need to add a new column to your Eloquent model table for example called: last_step/status or whatever you want.

```php
 $table->string('status');
```

In your config file _property_path_ attribute has to be the same value than the column name.

##### Step 2

You have to add the _Flowable_ trait to your Eloquent model to use the workflow.

```php
use szana8\Laraflow\Traits\Flowable;

class SampleClass extends Model {

    use Flowable;

```

##### Step 3

## Than you have to add a function to your eloquent model called _getLaraflowStates()_ .

This function has to return the array of the configuration!

##### Step 4

If you want to change the status of the Eloquent object you can use the

```php
$object->transiton($new_status);
$object->save();
```

method which comes from the _Flowable_ trait. The _\$new_status_ parameter is the value of
the _key_ attribute which comes from the _getPossibleTransitions()_ function.

## History

You can query the history of the record just call the history function in your model like this:

```
/**
     * Return historical records.
     *
     * @return string
     */
    public function getFlowHistoryAttribute()
    {
        return $this->history();
    }
```

## Events

You can listen to the 'global' events which fires in every status changes.

```php
LaraflowEvents::PRE_TRANSITION
LaraflowEvents::POST_TRANSITION
LaraflowEvents::CAN_TRANSITION
```

The _PRE_TRANSITION_ fires before the status change, the _POST_TRANSITION_ fires after.
The _CAN_TRANSITION_ fires when the package checks the transition is possible from the
actual step. You can define callback(s) which will be call from the specified transition.

## Validators

The package comes with a default validator class, which use the Laravel Validator class.
You can add validation rules to the transitions, so the package can checks the Eloquent
object attributes with the given rules before the transition. If the validation fails
throws a LaraflowValidatorException exception with the error message(s) array.

You can define your own validator if you create a class which implements the
_LaraflowValidatorInterface_.

#### Credits

This library has been highly inspired by https://github.com/winzou/state-machine.

#### License

The package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
