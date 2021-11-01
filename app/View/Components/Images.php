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
    private string $title;

    /**
     * image folder path ex: public/categories/.
     *
     * @var string
     */
    private string $folderPath;

    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $folderPath)
    {
        $this->title = $title;
        $this->folderPath = $folderPath;
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
