<?php

namespace App\Admin\Fields;

class Input extends Field
{
    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->type = 'text';
    }
}
