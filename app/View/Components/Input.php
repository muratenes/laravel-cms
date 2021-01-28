<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    /**
     * name of input
     *
     * @var string
     */
    public string $name;

    /**
     * html input element type
     *
     * @var string
     */
    public string $type;

    /**
     * html input max length
     *
     * @var string
     */
    public string $maxLength;

    /**
     * html input classses
     *
     * @var string
     */
    public string $class;

    /**
     * html input min length
     *
     * @var string
     */
    public string $minLength;

    /**
     * input container with
     *
     * @var string
     */
    public string $width;

    /**
     * label of input
     *
     * @var string
     */
    public string $label;

    /**
     * input default value
     *
     * @var string
     */
    public string $value;

    /**
     * input placeholder
     *
     * @var string
     */
    public string $placeholder;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $type
     * @param string $maxLength
     * @param string $minLength
     * @param string $class
     * @param string $width
     * @param string $label
     * @param string $value
     * @param string $placeholder
     */
    public function __construct(string $name, $type = 'text', $maxLength = '255', $minLength = '0', $class = 'form-control', $width = '3',$label = '',$value = '',$placeholder = '')
    {
        $this->type = $type;
        $this->maxLength = $maxLength;
        $this->minLength = $minLength;
        $this->class = $class;
        $this->name = $name;
        $this->width = $width;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.input');
    }
}
