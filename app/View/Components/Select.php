<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public ?string $value;
    public ?array $options;
    public string $key;
    public string $optionValue;
    public ?string $label;

    /**
     * Create a new component instance.
     *
     * @param $name
     * @param null|string $label
     * @param null|string $value
     * @param null|array  $options
     * @param string      $key
     * @param string      $optionValue
     */
    public function __construct($name, $label = '', $value = '', $options = [], $key = 'id', $optionValue = 'title')
    {
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
        $this->key = $key;
        $this->optionValue = $optionValue;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.select');
    }
}
