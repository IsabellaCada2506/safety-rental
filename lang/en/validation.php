<?php

/**
 * Author: Isabella Cadavid
 * Date: 06/09/2026
 * Description: Custom error messages for form validation.
 */

return [
    'required' => 'The :attribute field is required.',
    'email' => 'The :attribute must be a valid email address.',
    'string' => 'The :attribute must be text.',
    'integer' => 'The :attribute must be an integer.',
    'date' => 'The :attribute must be a valid date.',
    'confirmed' => 'The :attribute confirmation does not match.',
    'exists' => 'The selected :attribute is invalid.',
    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
        'string' => 'The :attribute must be at least :min characters.',
    ],
    'max' => [
        'string' => 'The :attribute may not be greater than :max characters.',
    ],
    'password' => [
        'letters' => 'The :attribute must contain at least one letter.',
        'numbers' => 'The :attribute must contain at least one number.',
    ],
];
