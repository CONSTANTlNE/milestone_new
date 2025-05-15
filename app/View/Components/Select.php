<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\View\Component;

class Select extends Component
{
    public mixed $lang;
    public mixed $width;
    public array|object $data;
    public mixed $dataSingle;
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
    public mixed $staticData;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $lang = false,
        $width = 12,
        $data = [],
        $dataSingle = '',
        $label = 'Title',
        $column = 'title',
        $placeHolder = '',
        $helpText = '',
        $successText = '',
        $required = false,
        $staticData = false,
        $disabled = false
    ) {
        $this->lang = $lang;
        $this->staticData = $staticData;
        $this->width = $width;
        $this->data = !empty($data) ? (object) $data : array();
        $this->dataSingle = $dataSingle;
        $this->label = $label;
        $this->column = $column;
        $this->placeHolder = $placeHolder;
        $this->helpText = $helpText;
        $this->successText = $successText;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->columnName = $column;
        $this->columnId = $lang ? $column . '_' . $lang->code : $column;
        $this->title = $lang ? $column . '_' . $lang->code : $column;
        if ($this->data && $this->lang && method_exists($this->data, 'getTranslations')) {
            $translation = $this->data->getTranslations($this->column);
            if (Arr::has($translation, $this->lang->code)) {
                $this->value = old($this->title, Arr::get($translation, $this->lang->code));
            } else {
                $this->value = "";
            }
        } elseif (count($this->data) > 1 && !$this->lang ) {
            $this->value = $this->data;
        } elseif (count($this->data) == 1 && !$this->lang) {
            $this->value = $this->data->{$this->column};
        }  else {
            $this->value = old($this->title, '');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('backend.components.select');
    }
}
