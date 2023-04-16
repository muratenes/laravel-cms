<?php

namespace App\Admin\Fields;

class File extends Field
{
    public function __construct(string $name, protected string $path, protected array $allowedTypes)
    {
        parent::__construct($name);
        $this->type = 'file';
    }
}
