<?php

namespace App\Listeners;

use App\Services\MessageMove;
use Webklex\PHPIMAP\Events\MessageMovedEvent;

class MessageMoved
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(MessageMovedEvent $event)
    {
        (new MessageMove)->messageMove($event->oldMessage, $event->new_message);
    }

}
