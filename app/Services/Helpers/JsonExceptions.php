<?php

use Illuminate\Validation\ValidationException;

if (!function_exists('validationException')) {
    function validationException($key, $message)
    {
        $error = ValidationException::withMessages([
            $key => [$message]
        ]);
        throw $error;
    }
}