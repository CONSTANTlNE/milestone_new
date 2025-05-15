<?php
namespace App\Rules;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NonEmptyTitleArray implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = array_filter($value, function ($item) {
            return $item !== null;
        });


        if (count($value) === 0) {
            $fail(__('strings.Error Title'));
        }

        // Check if the array has at least one element
        foreach ($value as $lang => $title) {
            if (is_null($title)) {
                $fail(__('strings.Error Title'));
            }
        }
    }

    public function message(): string
    {
        return __('strings.Error Title');
    }
}
