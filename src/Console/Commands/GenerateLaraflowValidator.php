<?php

namespace szana8\Laraflow\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class GenerateLaraflowValidator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraflow:make {validator} --{name : Create a validator file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Laraflow Validator command';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Validators';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = str_replace(
            'DummValidator',
            class_basename($name),
            parent::buildClass($name)
        );

        return str_replace(
            'DummValidator',
            $name,
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    public function getStub()
    {
        return  __DIR__.'../../../Stubs/DummValidator.stub';
    }
}
