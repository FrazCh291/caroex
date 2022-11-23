<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Email;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Webklex\PHPIMAP\Facades\Client;

class JunkEmailController extends Controller
{
    public function index()
    {
        // TODO: Implement __invoke() method.
        set_time_limit(500);
        /** @var \Webklex\PHPIMAP\Client $client */
        $client = Client::account('default');
        $client->connect();
        $junkFolder = $client->getFolder('Junk');
        $emailFatchs = $junkFolder->messages()->all()->limit(500)->get();
        foreach ($emailFatchs as $message) {
            $email = Email::firstOrCreate(
                ['email_id' => $message->getUid()],
                [
                    'email_id' => $message->getUid() ? $message->getUid() : null,
                    'subject' => $message->getsubject() ? $message->getSubject() : null,
                    'company_id' => 1,
                    'body' => $message->getBodies() ? $message->getHTMLBody() : null,
                    'from_email' => $message->getFrom() ? $message->getFrom()[0]->mail : null,
                    'from_name' => $message->getFrom() ? $message->getFrom()[0]->personal : null,
                    'to_email' => $message->getTo() ? $message->getTo()[0]->mail : null,
                    'to_name' => $message->getTo() ? $message->getTo()[0]->personal : null,
                    'masked_as_read' => $message->getFlags()->get('seen') == 'seen' ? true : false,
                    'folder' => 'Junk',
                    'date' => $message->getDate()
                ]);
//            if ($email->wasRecentlyCreated) {
            $attachments = $message->getAttachments();;
            foreach ($attachments as $attachment) {
                $file = $attachment;
                //save format
                $format = $attachment->getExtension();
                //save full adress of image
                $path = storage_path('app/public/images/');
                $attachment->save($path, $attachment->getName());
                Attachment::create([
                    'email_id' => $email->id,
                    'name' => $attachment->getName(),
                    'url' => $path,
                    'is_inline' => $attachment->getAttributes()['disposition'] ? $attachment->getAttributes()['disposition']->get()[0] == 'inline' : false,
                    'content_type' => $format,
                    'content_id' => $attachment->id,
                    'size' => $attachment->size,
                ]);
            }
        }
//        }
        $emails = Email::with('attachments', 'inlineAttachments')->where('folder', 'Junk')
            ->orderBy('email_id', 'DESC')->paginate(10);
        $inboxCount = Email::where('folder', 'INBOX')->count();
        $trashCount = Email::where('folder', 'Trash')->count();
        $junkCount = Email::where('folder', 'Junk')->count();
        $sentCount = Email::where('folder', 'Sent')->count();
        return Inertia::render('EmailFetch/Index', [
            'emails' => $emails,
            'inboxCount' => $inboxCount,
            'trashCount' => $trashCount,
            'junkCount' => $junkCount,
            'sentCount' => $sentCount
        ]);
    }
}
