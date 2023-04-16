<?php

namespace App\Admin\Fields;

class Field
{
    public int $maxLength = 100;
    public bool $isRequired = true;
    public string $class = 'form-control';
    public string $placeHolder = '';
    public string $type = 'text';
    public bool $showOnList = false;
    public string $label = '';

    public function __construct(public string $name)
    {
        $this->label = $name;
    }

    /**
     * @param int $maxLength
     *
     * @return Field
     */
    public function setMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @param bool $isRequired
     *
     * @return Field
     */
    public function setIsRequired(bool $isRequired): self
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    /**
     * @param string $class
     *
     * @return Field
     */
    public function setClass(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @param string $placeHolder
     *
     * @return Field
     */
    public function setPlaceHolder(string $placeHolder): self
    {
        $this->placeHolder = $placeHolder;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return Field
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param bool $showOnList
     *
     * @return Field
     */
    public function setShowOnList(bool $showOnList): self
    {
        $this->showOnList = $showOnList;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return Field
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
