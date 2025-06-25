<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait EscapeUniCodeJson
{
    /**
     * Encode the given value as JSON.
     *
     * @param  mixed  $value
     * @return string
     */
    protected function asJson($value, $flags = 0): string
    {
        return json_encode($value, $flags | JSON_UNESCAPED_UNICODE);
    }
}
