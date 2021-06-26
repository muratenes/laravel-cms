<?php

namespace App\Listeners;

use Illuminate\Log\Events\MessageLogged;

class LoggingListener
{
    /**
     * @var \Illuminate\Support\Collection
     */
    public $events;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->events = collect([]);
    }

    /**
     * Handle the event.
     *
     * @param MessageLogged $event
     */
    public function handle(MessageLogged $event)
    {
        $this->events->push($event);
    }
}
