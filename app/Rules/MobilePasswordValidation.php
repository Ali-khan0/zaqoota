<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MobilePasswordValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strlen($value) < 8) {
            $fail(translate('The password must be at least 8 characters long.'));
            return;
        }

        // Check if password has at least one capital letter OR one special character
        $hasCapital = preg_match('/[A-Z]/', $value);
        $hasSpecial = preg_match('/[!@#$%^&*(),.?":{}|<>\[\]\\\/_+\-=~`]/', $value);

        if (!$hasCapital && !$hasSpecial) {
            $fail(translate('The password must contain at least one capital letter or one special character.'));
        }
    }
}
