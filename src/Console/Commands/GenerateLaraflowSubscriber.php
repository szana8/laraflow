<?php

namespace szana8\Laraflow\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GenerateLaraflowSubscriber extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laraflow:make {subsciber} --{name : Create a subscriber file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Laraflow Subscriber command';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Listeners';
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
            'DummySubscriber',
            class_basename($name),
            parent::buildClass($name)
        );

        return str_replace(
            'DummySubscriber',
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
        return  __DIR__ . '../../../Stubs/DummySubscriber.stub';
    }
}
