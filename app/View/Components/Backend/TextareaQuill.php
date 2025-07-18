<?php

namespace App\View\Components\Backend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class TextareaQuill extends Component
{
    public mixed $lang;
    public mixed $width;
    public array|object $data;
    public mixed $label;
    public mixed $column;
    public mixed $placeHolder;
    public mixed $helpText;
    public mixed $successText;
    public mixed $required;
    public mixed $disabled;
    public mixed $columnName;
    public mixed $columnId;
    public mixed $title;
    public mixed $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $lang = false,
        $width = 12,
        $data = [],
        $label = 'Title',
        $column = 'title',
        $placeHolder = '',
        $helpText = '',
        $successText = '',
        $required = false,
        $disabled = false
    ) {
        $this->lang = $lang;
        $this->width = $width;
        $this->data = !empty($data) ? (object) $data : [];
        $this->label = $label;
        $this->column = $column;
        $this->placeHolder = $placeHolder;
        $this->helpText = $helpText;
        $this->successText = $successText;
        $this->required = $required;
        $this->disabled = $disabled;
        $langCode = isset($lang) && $lang->code ? '[' . $lang->code . ']' : ($lang->code ?? '');

        $this->columnName = $column;
        $this->columnId = $lang ? $column . $langCode  : $column;
        $this->title = $lang ? $column . $langCode   : $column;

        if ($this->data && $this->lang && method_exists($this->data, 'getTranslations')) {
            $translation = $this->data->getTranslations($this->column);
            if (Arr::has($translation, $this->lang->code)) {
                $this->value = old($this->title, Arr::get($translation, $this->lang->code));
            } else {
                $this->value = "";
            }
        } elseif ($this->data && !$this->lang) {
            $this->value = $this->data->{$this->column};
        } else {
            $this->value = old($this->title, '');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.textareaQuill');
    }
}
