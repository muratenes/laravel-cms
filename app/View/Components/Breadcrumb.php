<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    /**
     * @var null
     */
    public $first;

    /**
     * @var null
     */
    public $firstRoute;

    /**
     * @var null
     */
    public $second;

    /**
     * @var null
     */
    public $secondRoute;

    /**
     * Create a new component instance.
     *
     * @param null $first
     * @param null $firstRoute
     * @param null $second
     * @param null $secondRoute
     */
    public function __construct($first = null, $firstRoute = null, $second = null, $secondRoute = null)
    {
        $this->first = $first;
        $this->firstRoute = $firstRoute;
        $this->second = $second;
        $this->secondRoute = $secondRoute;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
