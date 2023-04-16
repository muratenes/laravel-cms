<?php

namespace App\Admin\Fields;

class Checkbox extends Field
{
    public function __construct(string $name, protected bool $checked)
    {
        parent::__construct($name);
        $this->type = 'checkbox';
    }
}
