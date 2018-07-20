<?php

namespace szana8\Laraflow\Validator;

use Illuminate\Support\Facades\Validator;

class LaraflowValidator implements LaraflowValidatorInterface
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
        $result = Validator::make($attributes, $rules);

        if ($result->fails()) {
            return $result->errors()->getMessages();
        }

        return true;
    }
}
