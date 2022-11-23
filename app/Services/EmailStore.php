<?php

namespace App\Services;

use App\Models\Email;
use App\Models\EmailCc;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Facade\FlareClient\Http\Client;

class EmailStore
{
    public function store($message)
    {
        set_time_limit(500);
        /** @var \Webklex\PHPIMAP\Client $client */
        $client = Client::account('default');
        $client->connect();
        $matchingEmail = Email::where('subject', $this->cleanSubject($message->getSubject()))->where('parent_id', null)
            ->where('from_email', $message->getFrom()[0]->mail)->first();
        $msg = $message->getHTMLBody();
        $emailBody = str_replace("cid:", "/storage/images/", $msg);
        $email = Email::firstOrCreate(
            ['email_id' => $message->getUid()],
            [
                'email_id' => $message->getUid() ? $message->getUid() : null,
                'subject' => $message->getsubject() ? $message->getSubject() : null,
                'company_id' => 1,
                'body' => $emailBody,
                'from_email' => $message->getFrom() ? $message->getFrom()[0]->mail : null,
                'from_name' => $message->getFrom() ? $message->getFrom()[0]->personal : null,
                'to_email' => $message->getTo() ? $message->getTo()[0]->mail : null,
                'to_name' => $message->getTo() ? $message->getTo()[0]->personal : null,
                'masked_as_read' => $message->getFlags()->get('seen') == 'seen' ? true : false,
                'folder' => 'INBOX',
                "parent_id" => $matchingEmail ? $matchingEmail->id : null,
                'date' => $message->getDate()
            ]);

//        if ($email->wasRecentlyCreated) {
        $attachments = $message->getAttachments();
        foreach ($attachments as $attachment) {
            $file = $attachment;
            //save format
            $format = $attachment->getExtension();
            //save full adress of image
            $path = storage_path('app/public/images/');
            $attachment->save($path, $attachment->id);
            Attachment::create([
                'email_id' => $email->id,
                'name' => $attachment->getName(),
                'url' => '/storage/images/' . $attachment->getName(),
                'is_inline' => $attachment->getAttributes()['disposition']->get()[0] == 'inline' ? true : false,
                'content_type' => $format,
                'content_id' => $attachment->id,
                'size' => $attachment->size,
            ]);
        }
            $ccAddresses = $message->cc;
            foreach ($ccAddresses as $cc) {
                $mailCc = EmailCc::create(
                    [
                        'email_id' => $message->getUid() ? $message->getUid() : null,
                        'name' => $cc['personal'] ? $cc['personal'] : null,
                        'address' => $cc['mail'] ? $cc['mail'] : null,
                    ]);
            }
    }

    private function cleanSubject($subject)
    {
        if (Str::of($subject)->startsWith('RE:') || Str::of($subject)->startsWith('Re:')) {
            return Str::of($subject)->after(':')->trim();
        }
        return $subject;
    }
}
