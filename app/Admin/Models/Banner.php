<?php

namespace App\Admin\Models;

use App\Admin\Fields\File;
use App\Admin\Fields\Input;

class Banner extends Model
{
    public function __construct()
    {
        parent::__construct(new \App\Models\Banner());
    }

    public function initFields(): array
    {
        $this->addField((new Input('title'))->setMaxLength(100)->setPlaceHolder('Başlık')->setLabel('Başlık')->setShowOnList(true));
        $this->addField((new Input('sub_title'))->setMaxLength(100)->setPlaceHolder('Alt Başlık')->setLabel('Alt Başlık')->setShowOnList(true));
        $this->addField((new File('image', 'banner', ['png', 'jpg']))->setLabel('Görsel'));

        return $this->fields;
    }
}
