<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextareaField extends Component
{
    public string $name;
    public string $label;
    public ?string $value;

    /**
     * Create a new component instance.
     */
    public function __construct(string $name, string $label = '', string $value = null)
    {
        $this->name = $name;
        $this->label = $label ?: ucfirst(str_replace('_', ' ', $name));
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea-field');
    }
}
