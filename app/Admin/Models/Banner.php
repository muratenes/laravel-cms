<?php

namespace App\Admin\Models;

use App\Admin\Fields\Checkbox;
use App\Admin\Fields\File;
use App\Admin\Fields\Input;
use Yajra\DataTables\Html\Column;

class Banner extends Model
{
    public function __construct()
    {
        parent::__construct(new \App\Models\Banner());
    }

    public function initFields(): array
    {
        $this->addField((new Input('title'))
            ->setMaxLength(100)
            ->setPlaceHolder('Başlık')
            ->setLabel('Başlık')
            ->setShowOnList(true));

        $this->addField((new Input('sub_title'))
            ->setMaxLength(100)
            ->setPlaceHolder('Alt Başlık')
            ->setLabel('Alt Başlık')
            ->setShowOnList(true));

        $this->addField(
            (new File('image', 'banner', ['png', 'jpg']))
                ->setLabel('Görsel')
                ->setShowOnList(true)
                ->setTableColumn(
                    (new Column())->renderRaw(<<<'DELIMITER'
                            data ?
                                '<a href="/images/banner/'+data+'">'+data+'</a>' :
                                data;
                        DELIMITER)
                )
        );

        $this->addField(
            (new Checkbox('active', false))
                ->setLabel('Yayında mı ?')
                ->setShowOnList(true)
                ->setTableColumn(
                    (new Column())->renderRaw(<<<'DELIMITER'
                            data == 1 ?
                                '<i class="fa fa-check text-green"></i>' :
                                '<i class="fa fa-times text-red"></i>';
                        DELIMITER)
                )
        );

        $this->addField((new Input('lang'))
            ->setMaxLength(100)
            ->setLabel('Dil')
            ->setShowOnList(true));

        $this->addField((new Input('created_at'))
            ->setMaxLength(100)
            ->setLabel('Oluşturulma Tarihi')
            ->setShowOnList(true));

        $this->addField((new Input('updated_at'))
            ->setMaxLength(100)
            ->setLabel('Güncellenme Tarihi')
            ->setShowOnList(true));

        return $this->fields;
    }
}
