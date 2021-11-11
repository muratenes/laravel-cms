<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Images extends Component
{
    /**
     *  Componnent Page title.
     *
     * @var string
     */
    public string $title;

    /**
     * image folder path ex: public/categories/.
     *
     * @var string
     */
    public string $folderPath;

    /**
     * image list.
     *
     * @var null|array
     */
    public $images;

    /**
     * Create a new component instance.
     *
     * @param mixed $images
     */
    public function __construct(string $title, string $folderPath, $images)
    {
        $this->title = $title;
        $this->folderPath = $folderPath;
        $this->images = $images;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.images');
    }
}
