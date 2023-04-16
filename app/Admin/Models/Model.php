<?php

namespace App\Admin\Models;

use App\Admin\Fields\Field;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as DBModel;

abstract class Model
{
    protected DBModel $model;
    protected int $perPage = 20;
    protected bool $pagination = false;
    protected array $fields = [];

    public function __construct(DBModel $model)
    {
        $this->model = $model;
        $this->initFields();
    }

    public function addField(Field $field): self
    {
        $this->fields[] = $field;

        return $this;
    }

    abstract public function initFields(): array;

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getItems(): Collection
    {
        $fields = collect($this->fields)->pluck('name')->toArray();

        return $this->model->latest()->get($fields);
    }

    public function getModel(): DBModel
    {
        return $this->model;
    }
}
