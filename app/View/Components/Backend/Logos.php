<?php

namespace App\View\Components\Backend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logos extends Component
{
    public mixed $wrapperClass;

    public function __construct($wrapperClass = null)
    {
        $this->wrapperClass = $wrapperClass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.logos');
    }
}
