<?php


namespace szana8\Laraflow\Validator;


interface LaraflowValidatorInterface
{
    /**
     * Validate the attributes with the given rules.
     *
     * @param array $attributes
     * @param array $rules
     * @return mixed
     */
    public function validate(array $attributes, array $rules);
}