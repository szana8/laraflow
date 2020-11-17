<p align="center"><img src="https://banners.beyondco.de/Laraflow.png?theme=dark&packageName=szana8%2Flaraflow&pattern=architect&style=style_2&description=Laraflow+is+a+standard+workflow+package+for+Laravel+Eloquent+objects.+You+can+define+your+steps%2C+the+transition+between+the+them%2C+callbacks%2C+and+validators.&md=1&showWatermark=0&fontSize=100px&images=https%3A%2F%2Flaravel.com%2Fimg%2Flogomark.min.svg" width="400"></p>
# Laravel Workflow Package

Laraflow is a standard workflow package for Laravel Eloquent objects. You can define your steps,
the transition between the them, callbacks, and validators.

<p align="center">
<a href="https://packagist.org/packages/szana8/laraflow"><img src="https://img.shields.io/packagist/dt/szana8/laraflow" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/szana8/laraflow"><img src="https://img.shields.io/packagist/v/szana8/laraflow" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/szana8/laraflow"><img src="https://img.shields.io/packagist/l/szana8/laraflow" alt="License"></a>
</p>

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
You can find a sample test project with this package in here: https://github.com/szana8/laravel-workflow-package

### Configuration file

After the installation you have to publish a configuration file, which contains a lot of necessary data for the package.

```
php artisan vendor:publish --provider="szana8\Laraflow\LaraflowServiceProvider"
```

#### Configuration array

You need a configuration array before you use the Laraflow workflow.

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

The configuration array, when just using 1 state machine in you model must of the form:

```php
[
    'default' => [
        //... see published configuration example in config directory.
    ]
];
```

When you have multiple statemachines in your model use the following form:

```php
[
    'statemachine_name1' => [ // might also be called 'default' !
        // ...  see published configuration example in config directory
    ],
    'statemachine_name2' => [
        // ...  see published configuration example in config directory
    ],
]
```

##### Step 4

If you want to change the status of the Eloquent object you can use the

```php
// when using only 1 or at least 'default' named state machine.
$object->transiton($new_status);
// when using only 1 not named state machine.
$statemachineName1 = 'statemachine_name1'
$object->transiton($new_status, $statemachineName1);
$statemachineName2 = 'default'
$object->transiton($new_status, $statemachineName2);
$object->save();
```

method which comes from the _Flowable_ trait. The _\$new_status_ parameter is the value of
the _key_ attribute which comes from the _getPossibleTransitions()_ function.

## History

You can query the history of the record just call the history function in your model like this:

```php
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

```php
class TestValidator extends Rule implements LaraflowValidatorInterface
{
    /**
     * Validate the attributes with the given rules.
     *
     * @param array $attributes
     * @param array $rules
     * @return mixed
     */
    public function validate(array $attributes, array $rules)
    {
        if (1 == 2) {
            return true;
        }

        throw LaraflowValidatorException::withMessages(['Validation error']);
    }
}
```

### Commands

#### Subscriber generation

You can create subscribers for the default Laraflow events with artisan command.

```properties
foo@bar: php artian laraflow:make subscriber --NameOfTheSubscriber
```

After the run you can find the new subscriber class in the App\Listener directory. To create a callback class you have to create a class which implements the _LaraflowCallbackInterface_ and add the class to the neessary event in the subscriber.

Example:

```php
class TestPreCallback implements LaraflowCallbackInterface
{
    public function handle(LaraflowTransitionEvents $event)
    {
        CallbackTest::insert(['message' => json_encode($event->convertToArray())]);
    }
}

class LaraflowEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            LaraflowEvents::PRE_TRANSITION,
            'App\TestPreCallback@handle'
        );
    }
}
```

#### Custom validator generation

To generate a validator class skeleton for the custom validation you use this command:

```properties
foo@bar: php artian laraflow:make validator --NameOfTheValidator
```

After the run you can find the new class in the App\Validators directory.

#### Credits

This library has been highly inspired by https://github.com/winzou/state-machine.

#### License

The package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
