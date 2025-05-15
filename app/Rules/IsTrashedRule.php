<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Page;

class IsTrashedRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $page = Page::withTrashed()->find($value);
        return $page && $page->trashed();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The selected page is not trashed or does not exist.';
    }
}
