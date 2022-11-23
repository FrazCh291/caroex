<?php

namespace App\Services;

use App\Services\Irfan;
use Carbon\Carbon;
use App\Models\Cases;
use App\Models\Email;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportEmail
{
    public function importEmail($folders = [], $emailSetting)
    {
        $data = [];
        $totalEmails = 0;
        $emailsToPull = [];
        $attachmentData = [];
        $maxEmailsToFetch = 5;
        $emailsInMailboxWithId = [];
        $emailsInMailboxWithoutId = [];
        $emailsMailbox = [];

        $emailsInMailbox = [];
        $emailsInDatabase = [];
        $emailsWithIdCount = 0;
        $emailsWithoutIdCount = 0;
        $foldersDetails = [];
        $timeStart = microtime(true);
        $folderCount = 0;
        $messageArr = [];
        $paginator = [];

        foreach ($folders as $folder) {
            $paginator[] = $folder->query()->all()->paginate($per_page = 5, $page = null, $page_name = 'imap_page');
            //$messages = $folder->query()->setFetchBody(false)->all()->get();
//            foreach ($messages as $message) {
//                $messageArr[$folder->name][] = $message->getUid();
//                $totalEmails++;
//                if ($totalEmails >= 100) {
//                    break;
//                }
//            }
//            if ($totalEmails >= 100) {
//                break;
//            }
//            $folderCount++;
        }
        $timeEnd = microtime(true);
        $executionTime = $timeEnd - $timeStart;
        dd([$paginator, $messageArr, $executionTime]);

            //$emailKeys = array_keys($overviews);
            //dd($emailKeys);
            foreach ($overviews as $key => $value) {
                var_dump($key);
                //$messageArr[] = $folder->query()->getMessageByUid($key);
            }
//
//
//dd([$overviews, $messageArr]);
//            $emailCount = 0;
//            $info = $folder->examine();
//            if($folder->name=='INBOX'){
//
//              $folder->query()->all()->chunked(function($messages, $chunk){
//                    dd($chunk);
//                    $messages->each(function($message){
//                        dump($message->uid);
//                    });
//                }, $chunk_size = 10, $start_chunk = 1);
//                //$messages=$folder->query()->all()->setFetchBody(false)->get();
//
//                while ($emailCount < $info['exists']) {
//                    $messages = $folder->query()->all()->setFetchBody(false)->limit($limit = 3)->get();
//                    foreach ($messages as $message) {
//                        $emailsMailbox[$message->getUid()] = $folder->name;
//                    }
//                    $emailCount += 3;
//                }
//                $messages = $folder->query()->all()->setFetchBody(false)->limit($limit = 3)->get();
//            }
//            $messages = $folder->query()->setFetchBody(false)->all()->chunked(function($messages, $chunk){
//                dump("chunk #$chunk");
//                $messages->each(function($message){
//                    dump($message->uid);
//                });
//            }, $chunk_size = 10, $start_chunk = 1);
//
//        }
//        dd($emailsMailbox);

            $lastTime = Email::where('email_account_id', $emailSetting->email_account_id)->where('folder', $folderName)->orderBy('date', 'desc')->first();
            $emailFetchs = null;
            $emailFetchs = $folder->query()->since($lastTime ? $lastTime->date : Carbon::now()->subHours(2))->get();
            if (!$emailFetchs->isEmpty() && count($emailFetchs) > 0) {
                foreach ($emailFetchs as $message) {
                    if ($message->getUid()) {
                        $token = $message->getUid() . '/' . $folderName . '/' . $message->getDate();
                        $parts = explode('/', $token);
                        $check = $message->getUid($parts[0]);
                        $check1 = $message->getDate($parts[2]);
//                        dd($check1);
//                        $msg = $message->hasHTMLBody() ? $message->getHTMLBody() : preg_replace('/\r\n/', '<br>', $message->getTextBody());
//                        $emailBody = str_replace("cid:", "/storage/images/", $msg);
                        $msg = $message->getHTMLBody();


                        // dd($msg);
                        $emailBody = str_replace("cid:", "/storage/images/", $msg);
                        $isOld = Email::where('email_id', $check)->first();
                        if (!$isOld) {
                            $case = Cases::whereHas('order', function ($query) use ($message) {
                                $query->where('shipping_email', $message->getFrom() ? $message->getFrom()[0]->mail : null)
                                    ->orWhere('shipping_email', $message->getTo() ? $message->getTo()[0]->mail : null);
                            })->where('status', '!=', 'closed')->first();

                        }
//
//
//
//
//
//            $folderName = $this->getFolderName($folder);
//
//
//            $info = $folder->examine();
//            //$foldersDetails[] = $info;
//            echo $folder->name . "<br>\r\n";
//            print_r($info);
//            echo "<br>\r\n<br>\r\n";
//
//            dd([$info['exists'], count($messages)]);
//            $totalEmails += $info['exists'];
//            $overviews = $folder->overview($sequence = "1:*");
//            foreach ($overviews as $overview) {
//                $emailCount++;
//                if(isset($overview['message_id'])) {
//                    $emailsInMailboxWithId[] = $overview['message_id'];
//                    $emailsWithIdCount++;
//                } else {
//                    $emailsInMailboxWithoutId[] = $overview;
//                    $emailsWithoutIdCount++;
//                }
//            }
//        }
//        dd();
//        dd([$foldersDetails, $totalEmails, $emailsWithIdCount, $emailsWithoutIdCount, $emailsInMailboxWithId, $emailsInMailboxWithoutId]);





//            $lastTime = Email::where('email_account_id', $emailSetting->email_account_id)->where('folder', $folderName)->orderBy('date', 'desc')->first();
//            $emailFetchs = null;
//            $emailFetchs = $folder->query()->since($lastTime ? $lastTime->date : Carbon::now()->subDay())->setFetchOrder("desc")->get();
//
//            if (!$emailFetchs->isEmpty() && count($emailFetchs) > 0) {
//                foreach ($emailFetchs as $message) {
//
//                    if ($message->uid) {
//
//                        $token = $message->getUid() . '/' . $folderName . '/' . $message->getDate();
//                        $parts = explode('/', $token);
//                        $check = $message->getUid($parts[0]);
//                        $check1 = $message->getDate($parts[2]);
////                        dd($check1);
////                        $msg = $message->hasHTMLBody() ? $message->getHTMLBody() : preg_replace('/\r\n/', '<br>', $message->getTextBody());
////                        $emailBody = str_replace("cid:", "/storage/images/", $msg);
//                        $msg = $message->getHTMLBody();
//                        if (Str::contains($msg, 'div {border:0 !important;display: block !important;outline: none !important;}')) {
//                            $msg = Str::replace('div {border:0 !important;display: block !important;outline: none !important;}', 'div{}', $msg);
//                        }
////                        dd($message->getTo(), $message->to->first()->mail, $message->from->first()->mail);
//                        if ($message->getsubject() == 'Tgh') {
//                            dd($message);
//                        }
//                        if ($message->getUid()) {
//
//
//                            $token = $message->getUid() . '/' . $folderName . '/' . $message->getDate();
//                            $parts = explode('/', $token);
//                            $check = $message->getUid($parts[0]);
//                            $check1 = $message->getDate($parts[2]);
////                        dd($check1);
////                        $msg = $message->hasHTMLBody() ? $message->getHTMLBody() : preg_replace('/\r\n/', '<br>', $message->getTextBody());
////                        $emailBody = str_replace("cid:", "/storage/images/", $msg);
//
//
//                            $body = explode('</html>', $message->getHTMLBody());
//                            $msg = $body[0] . '</html>';
//
//                            if ($msg) {
//                                $msg = str_replace("img", "div", $msg);
//                            }
////                            dd($msg, $body);
//
//
////                            dd(explode('</html>', $msg)[0] . '</html>');
//
//
////                            $emailBody = str_replace("cid:", "/storage/images/", $msg);
//                            $isOld = Email::where('email_id', $check)->first();
//
//
//                            if (!$isOld) {
//                                $case = Cases::whereHas('order', function ($query) use ($message) {
//                                    $query->where('shipping_email', $message->getFrom() ? $message->from->first()->mail : null)
//                                        ->orWhere('shipping_email', $message->getTo() ? $message->to->first()->mail : null);
//                                })->where('status', '!=', 'closed')->first();
//
////
//                                $data[] =
//                                    [
//                                        'email_id' => $check ? $check : null,
//                                        'email_account_id' => $emailSetting ? $emailSetting->email_account_id : null,
//                                        'company_id' => 1,
//                                        'case_id' => $case ? $case->id : null,
//                                        'subject' => $message->getsubject() ? utf8_encode(Str::limit($message->getSubject(), 180)) : null,
//                                        'body' => utf8_encode($msg),
//                                        'from_email' => $message->getFrom() ? utf8_encode($message->from->first()->mail) : null,
//                                        'from_name' => $message->getFrom() ? utf8_encode($message->from->first()->personal) : null,
//                                        'to_email' => $message->getTo() ? utf8_encode($message->to->first()->mail) : null,
//                                        'to_name' => $message->getTo() ? utf8_encode($message->to->first()->personal) : null,
//                                        'marked_as_read' => $message->getFlags()->get('seen') == 'seen' ? true : false,
//                                        'folder' => $folderName ? $folderName : '',
//                                        'previous_folder' => $folder->name ? $folder->name : '',
//                                        'date' => $check1 ? $check1 : null
//                                    ];
//                                if (count($body) > 1) {
//                                    $images = explode('Content-Transfer-Encoding: base64', $body[1]);
//                                    for ($i = 0; $i < count($images); $i++) {
//                                        if ($i == 0)
//                                            continue;
//                                        $image = explode("--", trim($images[$i]))[0];
//                                        $imageName = Str::random(10) . '.' . 'png';
//                                        Storage::put('images/' . $imageName, base64_decode($image));
//
//                                        $attachmentData[] =
//                                            [
//                                                'attachment_id' => null,
//                                                'email_id' => $check,
//                                                'name' => $imageName ? $imageName : null,
//                                                'url' => null,
//                                                'content_type' => 'png',
//                                                'is_inline' => 1,
//                                                'content_id' => $imageName,
//                                                'size' => 123,
//                                            ];
//                                    }
//                                }
//
//                                if (!$message->getAttachments()->isEmpty()) {
//
////                                    dd($message->getAttachments());
//
//                                    foreach ($message->getAttachments() as $attachment) {
//
//                                        $content = $attachment->content ? $attachment->content : '';
//                                        $file = $attachment;
//                                        $format = $attachment->getExtension();
//                                        $path = storage_path('app/public/images/');
//
////                                    if (($attachment->getAttributes()['id'] && $attachment->getAttributes()['disposition']->get()[0] == 'inline') {
////                                        $attachment->save($path, $attachment->getAttributes()['id']);
////                                    } else {
//                                        $attachment->save($path, $attachment->content_id ? $attachment->content_id : $attachment->getName());
//
//
//                                        $attachmentData[] =
//                                            [
//                                                'attachment_id' => $attachment->getAttributes()['id'] ? $attachment->getAttributes()['id'] : null,
//                                                'email_id' => $check,
//                                                'name' => $attachment->content_id ? $attachment->content_id : null,
//                                                'url' => '/storage/images/' . $attachment->content_id ? $attachment->content_id : null,
//                                                'content_type' => $format,
//                                                'is_inline' => $attachment->getAttributes()['disposition'] && $attachment->getAttributes()['disposition']->get()[0] == 'inline',
//                                                'content_id' => $attachment->content_id ? $attachment->content_id : $attachment->getName(),
//                                                'size' => $attachment->size,
//                                            ];
//                                    }
//                                }
//
//                            }
//
//                        }
//                    }
//                }
//            }
//
//            $emailFetchs = null;
 //       }
                            $data[] =
                                [
                                    'email_id' => $check ? $check : null,
                                    'email_account_id' => $emailSetting ? $emailSetting->email_account_id : null,
                                    'company_id' => 1,
                                    'case_id' => $case ? $case->id : null,
                                    'subject' => $message->getsubject() ? utf8_encode(Str::limit($message->getSubject(), 180)) : null,
                                    'body' => utf8_encode($message->getStructure()->raw),
                                    'from_email' => $message->getFrom() ? utf8_encode($message->getFrom()[0]->mail) : null,
                                    'from_name' => $message->getFrom() ? utf8_encode($message->getFrom()[0]->personal) : null,
                                    'to_email' => $message->getTo() ? utf8_encode($message->getTo()[0]->mail) : null,
                                    'to_name' => $message->getTo() ? utf8_encode($message->getTo()[0]->personal) : null,
                                    'marked_as_read' => $message->getFlags()->get('seen') == 'seen' ? true : false,
                                    'folder' => $folderName ? $folderName : '',
                                    'previous_folder' => $folder->name ? $folder->name : '',
                                    'date' => $check1 ? $check1 : null
                                ];

                            if ($message->getAttachments()) {
                                foreach ($message->getAttachments() as $attachment) {
                                    $content = $attachment->content ? $attachment->content : '';
                                    $file = $attachment;
                                    $format = $attachment->getExtension();
                                    $path = storage_path('app/public/images/');

                                    if ($attachment->getAttributes()['id'] && $attachment->getAttributes()['disposition']) {
                                        $attachment->save($path, $attachment->getAttributes()['id']);
                                    } else {
                                        $attachment->save($path, $attachment->content_id);
                                    }

                                    $attachmentData[] =
                                        [
                                            'attachment_id' => $attachment->getAttributes()['id'] ? $attachment->getAttributes()['id'] : null,
                                            'email_id' => $check,
                                            'name' => $attachment->content_id ? $attachment->content_id : null,
                                            'url' => '/storage/images/' . $attachment->content_id ? $attachment->content_id : null,
                                            'content_type' => $format,
                                            'is_inline' => $attachment->getAttributes()['disposition'] && $attachment->getAttributes()['disposition']->get()[0] == 'inline',
                                            'content_id' => $attachment->getName(),
                                            'size' => $attachment->size,
                                        ];
                                }
                            }
                        }
                    }
                }


        return ['data' => $data, 'attachmentData' => $attachmentData];
    }

    private function getFolderName($folder)
    {
        $folderNames = [
            'Archive' => 'archive',
            'Drafts' => 'drafts',
            'INBOX' => 'inbox',
            'inbox' => 'inbox',
            'Inbox' => 'inbox',
            'Junk' => 'junk',
            'Junk Email' => 'junk',
            'Sent' => 'sent',
            'Sent Items' => 'sent',
            'Sent Messages' => 'sent',
            'Trash' => 'trash',
        ];
        return $folderNames[$folder->name] ?? 'inbox';
    }
}
