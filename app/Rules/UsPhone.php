<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates a US phone number (NANP) and allows flexible input formats.
 *
 * Accepted inputs examples:
 *  - 2025550123
 *  - (202) 555-0123
 *  - 1 202 555 0123
 *  - +1 202-555-0123
 *
 * Rules:
 *  - After stripping non-digits, optionally remove a leading '1'.
 *  - Must have exactly 10 digits.
 *  - Area code NXX and central office NXX where N = [2-9], X = [0-9].
 */
class UsPhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) && !is_numeric($value)) {
            $fail('The :attribute must be a valid US phone number.');
            return;
        }

        $digits = preg_replace('/\D+/', '', (string)$value);
        if ($digits === null) { // preg_replace can return null on error
            $fail('The :attribute must be a valid US phone number.');
            return;
        }

        // Remove leading country code '1' if present (e.g., 1XXXXXXXXXX)
        if (strlen($digits) === 11 && str_starts_with($digits, '1')) {
            $digits = substr($digits, 1);
        }

        // Must be exactly 10 digits now
        if (strlen($digits) !== 10) {
            $fail('The :attribute must be a valid US phone number.');
            return;
        }

        // NANP: Area code [2-9]XX and central office [2-9]XX
        if (!preg_match('/^[2-9][0-9]{2}[2-9][0-9]{2}[0-9]{4}$/', $digits)) {
            $fail('The :attribute must be a valid US phone number.');
            return;
        }
    }
}
