<?php

namespace App\Listeners;

use App\Services\EmailStore;
use Webklex\PHPIMAP\Events\MessageNewEvent;

class StoreEmail
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
    public function handle(MessageNewEvent $event)
    {
        (new EmailStore)->store($event->message);
    }
}
