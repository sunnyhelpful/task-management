<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TitleValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        if (!preg_match('/^[A-Za-z\s]+$/', $value)) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'This title foramt is wrong.';
    }
}
