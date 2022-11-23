<?php

namespace App\Services;

use App\Models\Email;
use Facade\FlareClient\Http\Client;
use Webklex\PHPIMAP\Message;

class MessageMove
{
    public function messageMove($oldMessage, $newMessage)
    {
        set_time_limit(500);
        /** @var \Webklex\PHPIMAP\Client $client */
        $client = Client::account('default');
        $client->connect();
        $oldMessage = Email::where('email_id', $oldMessage->getUid())->where('parent_id', null)->first();
        $oldMessage->getUid();
        $oldMessage = $oldMessage->getHTMLBody();

    }
}
