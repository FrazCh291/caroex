<?php

namespace App\Http\Controllers\Admin;

use App\Services\ImapConnect;
use App\Services\ImportEmail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Swift_Mailer;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Email;
use Inertia\Response;
use App\Models\Cases;
use App\Models\EmailCc;
use Swift_SmtpTransport;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmailSetting;
use App\Models\EmailAccount;
use App\Services\Traits\Sort;
use App\Jobs\ImportEmailsJob;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Swift_Mime_SimpleHeaderSet;
use Webklex\PHPIMAP\ClientManager;

class EmailController extends Controller
{
    use Sort;
    use Filter;
    use Search;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->email) {
            if (is_array($request->email)) {
                $emailAccount = EmailAccount::where('id', $request->email['email_account_id'])->first();
            } else {
                $emailAccount = EmailAccount::where('name', $request->email)->first();
            }
        } else {
            $email = EmailSetting::Select('username', 'email_account_id')->where('status', 1)->orderBy('username')->first();
            $emailAccount = EmailAccount::where('id', $email->email_account_id)->first();
        }

        $emailSetting = '';
        if ($request->get('email') != null) {
            $emailSetting = EmailSetting::where('status', 1)->where('username', $request->get('email'))->first();
        } else {
            $emailSetting = EmailSetting::where('status', 1)->orderBy('username')->limit(1)->first();
        }

        try {
            $client = new ImapConnect();
            $client = $client->imapClientConnection($emailSetting);
            $mailboxFolders = [];
            $emailData = '';
            $messages = '';
            $folderName = $request->get('type') ?? 'INBOX';
            if ($client->isConnected()) {
                $folders = $client->getFolders($hierarchical = false);
                foreach ($folders as $index => $folder) {
                    if($request->has('query')) {
                        if ($this->getFolderName($folder->name)) {
                            $mailboxFolders[$index]['name'] = $folder->name;
                            $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                            if ($folder->name == $request->get('type')) {
                                $messages = $folder->query()->text($request->get('query'))->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->paginate($per_page = 8, $page = null , $page_name = 'imap_page');
                            }
                        }
                    }
                    else if($request->has('read')) {
                        if ($this->getFolderName($folder->name)) {
                            $mailboxFolders[$index]['name'] = $folder->name;
                            $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                            if ($folder->name == $request->get('type')) {
                                $messages = $folder->query()->seen()->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->paginate($per_page = 8, $page = null , $page_name = 'imap_page');
                            }
                        }
                    }
                    else if($request->has('unread')) {
                        if ($this->getFolderName($folder->name)) {
                            $mailboxFolders[$index]['name'] = $folder->name;
                            $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                            if ($folder->name == $request->get('type')) {
                                $messages = $folder->query()->unseen()->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->paginate($per_page = 8, $page = null , $page_name = 'imap_page');
                            }
                        }
                    }
                    else if($request->has('star')) {
                        if ($this->getFolderName($folder->name)) {
                            $mailboxFolders[$index]['name'] = $folder->name;
                            $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                            if ($folder->name == $request->get('type')) {
                                $messages = $folder->query()->where([['flagged', 'Flagged']])->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->paginate($per_page = 8, $page = null , $page_name = 'imap_page');
                            }
                        }
                    }
                    // else if($request->has('attachments')) {
                    //     if ($this->getFolderName($folder->name)) {
                    //         $mailboxFolders[$index]['name'] = $folder->name;
                    //         $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                    //         if ($folder->name == $request->get('type')) {
                    //             $messages = $folder->query()
                    //            // ->where('OR HEADER Content-Type multipart/report')
                    //             //->orWhere()
                    //             ->where('CUSTOM HEADER Content-Type multipart/mixed')
                    //             ->orWhere()->where('CUSTOM HEADER Content-Type multipart/report')
                    //             ->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->all()->paginate($per_page = 8, $page = null , $page_name = 'imap_page');
                    //             //->whereHeader('Content_Type','multipart/signed')
                    //             // dd($messages);
                    //         }
                    //     }
                    // }
                    // else if($request->has('from')) {
                    //     if ($this->getFolderName($folder->name)) {
                    //         $mailboxFolders[$index]['name'] = $folder->name;
                    //         $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                    //         if ($folder->name == $request->get('type')) {
                    //         //$stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}.$request->type", $emailSetting->username, $emailSetting->password);

                    //             $messages = $folder->query()->leaveUnread()->setFetchBody(true)->fetchOrderDesc('SORTFROM')->paginate($per_page = 4, $page = null , $page_name = 'imap_page');
                    //             dd($messages);
                    //         }
                    //     }
                    // }
                    else if($request->has('date')) {
                        if ($this->getFolderName($folder->name)) {
                            $mailboxFolders[$index]['name'] = $folder->name;
                            $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                            if ($folder->name == $request->get('type')) {
                                if($request->get('direction') === 'asc') {
                                    $messages = $folder->query()->leaveUnread()->setFetchBody(true)->fetchOrderAsc()->all()->paginate($per_page = 8, $page = null, $page_name = 'imap_page');
                                }
                                else {
                                    $messages = $folder->query()->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->all()->paginate($per_page = 8, $page = null, $page_name = 'imap_page');
                                }
                            }
                        }
                    }
                    else {
                        if ($this->getFolderName($folder->name)) {
                            $mailboxFolders[$index]['name'] = $folder->name;
                            $mailboxFolders[$index]['unseen_messages_count'] = $folder->query()->unseen()->count();
                            if ($folder->name == $folderName) {
                                // 164747 inline images in this email are not displaying well
                                //$folder->query()->getMessageByUid(164747);
                                $messages = $folder->query()->leaveUnread()->setFetchBody(true)->fetchOrderDesc()->all()->paginate($per_page = 8, $page = null, $page_name = 'imap_page');
                            }
                        }
                    }
                }
            }
            File::cleanDirectory(Storage::disk('local')->path('email-attachments'));
            $emailData = $messages->getCollection()->map(function ($message) {
                return [
                    'id' => $message->getUid(),
                    'has_text_body' => $message->hasTextBody(),
                    'message_id' => $message->getMessageId() ? $message->getMessageId()->get('values')['0'] : '',
                    'has_html_body' => $message->hasHTMLBody(),
                    'has_attachment' => $message->hasAttachments(),
                    'cc' => $message->getCc() ? collect($message->getCc()->get('values'))->map(function ($address) {
                        return $address->toArray();
                    }) : '',
                    'is_seen' => $message->getFlags()->get('seen') == 'Seen' ? true : false,
                    'is_flagged' => $message->getFlags()->has('flagged') ? true : false,
                    'date' => $message->getDate() ? $message->getDate()->get('values')[0] : '',
                    'bcc' => $message->getBcc() ? collect($message->getBcc()->get('values'))->map(function ($address) {
                        return $address->toArray();
                    }) : '',
                    'subject' => $message->getSubject() ? $message->getSubject()->get('values')[0] : '',
                    'from' => $message->getFrom() ? $message->getFrom()->get('values')[0]->toArray() : '',
                    'reply_to' => $message->getReplyTo() ? $message->getReplyTo()->get('values')[0]->toArray() : '',
                    'in_reply_to' => $message->getInReplyTo() ? collect($message->getInReplyTo()->get('values'))->map(function ($inReplyTo) {
                        return rtrim(ltrim($inReplyTo, '<'), '>');
                    }) : '',
                    'to' => $message->getTo() ? collect($message->getTo()->get('values'))->map(function ($address) {
                        return $address->toArray();
                    }) : '',
                    'attachments' => $message->hasAttachments() ? $this->getAttachments($message->getAttachments()) : '',
                    'body' => $message->hasHTMLBody() ? $this->getEmailBodyWithReplacedImages($message) : $message->getTextBody()
                ];
            });

            if($request->has('date') && $request->get('direction') === 'asc') {
                $messages = $messages->setCollection($emailData->sortBy([['date', 'asc']]));  
            }
            else {
                $messages = $messages->setCollection($emailData->sortBy([['date', 'desc']]));
            }
        } catch (\Exception $ex) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => $ex->getMessage()
            ]);
            throw $error;
        }

        $colors = [
            'default' => '#606003',
            'info@ejogga.com' => '#5BFF33',
            'info@boomtekk.com' => '#33FFDA',
            'info@xstreamgym.com' => '#FF8D33',
            'Delivery@ejogga.com' => '#C4FF33',
            'care@xstreamgym.com' => '#606003',
            'info@stockovers.co.uk' => '#876C6C',
            'care@bingbangbosh.com' => '#FF4933',
            'delivery@boomtekk.com' => '#33F0FF',
            'info@bingbangbosh.com' => '#FFCE33',
            'info@xstreamgymuk.com' => '#3393FF',
            'care@xstreamgymuk.com' => '#F597B2',
            'aron.adams@boomtekk.com' => '#524848',
            'delivery@xstreamgym.com' => '#FE2A67',
            'support@bingbangbosh.com' => '#33B8FF',
            'mo.allen@bingbangbosh.com' => '#C433FF',
            'alex.adams@xstreamgym.com' => '#DE2AFE',
            'delivery@stockovers.co.uk' => '#F59797',
            'alex.adams@bingbangbosh.com' => '#3342FF',
            'Delivery@bingbangbosh.com' => '#8333FF',
        ];

        $emailSettings = EmailSetting::where('status', 1)->orderBy('username')->get();
        // $emailSetting = $emailSettings->where('username', $emailAccount->name)->first();
        $params = $request->all();

        return Inertia::render('EmailFetch/Index', [
            'emails' => $messages->withQueryString(),
            'folders' => collect($mailboxFolders)->sortBy('name')->values()->toArray(),
            'emailSettings' => $emailSettings ?? '',
            'colors' => $colors,
            'type' => $request->get('type') ?? 'INBOX',
            'activeEmailId' => $emailSetting ? $emailSetting->id : '',
            'activeEmail' => $emailAccount ? $emailAccount->name : '',
            'params' => $params,
        ]);
    }


    public function searchEmailCases(Request $request)
    {
        $orders = Order::where('shipping_email', 'like', '%' . $request->word . '%')->with(['customer', 'orderItems'])->get();
        return response()->json([
            'orders' => $orders
        ]);
    }


    public function fetchSpecificEmail(Request $request)
    {
        $email = Str::lower($request->email);
        $emailId = $request->id;
        $emails = Email::with('attachments', 'inlineAttachments', 'childEmails.attachments', 'childEmails.emailCcs', 'emailCcs', 'case')
            ->where('to_email', $email)
            ->where('parent_id', null)
            ->where('email_account_id', $request->email_account_id)
            ->where('folder', 'inbox')
            ->orderBy('date', 'DESC');

        $emailSettings = EmailSetting::where('status', 1)->orderBy('username')->get();

        $colors = [
            'default' => '#606003',
            'info@ejogga.com' => '#5BFF33',
            'info@boomtekk.com' => '#33FFDA',
            'info@xstreamgym.com' => '#FF8D33',
            'delivery@ejogga.com' => '#C4FF33',
            'care@xstreamgym.com' => '#606003',
            'info@stockovers.co.uk' => '#876C6C',
            'care@bingbangbosh.com' => '#FF4933',
            'delivery@boomtekk.com' => '#33F0FF',
            'info@bingbangbosh.com' => '#FFCE33',
            'info@xstreamgymuk.com' => '#3393FF',
            'care@xstreamgymuk.com' => '#F597B2',
            'aron.adams@boomtekk.com' => '#524848',
            'delivery@xstreamgym.com' => '#FE2A67',
            'support@bingbangbosh.com' => '#33B8FF',
            'mo.allen@bingbangbosh.com' => '#C433FF',
            'alex.adams@xstreamgym.com' => '#DE2AFE',
            'delivery@stockovers.co.uk' => '#F59797',
            'alex.adams@bingbangbosh.com' => '#3342FF',
            'mariah.ellie@bingbangbosh.com' => '#8333FF',
        ];


//        $inboxEmails = Email::where('folder', 'inbox')->where('email_account_id', $request->email_account_id)->get();

        $folders = DB::table('emails')->where('email_account_id', $request->email_account_id)
            ->selectRaw('folder, count(*) as emailscount')
            ->groupBy('folder')
            ->get();
        $folders = json_decode($folders, true);

        $count = [];
        foreach ($folders as $folder) {
            $count[$folder['folder']] = $folder['emailscount'];
        }

        $count['inbox'] = $count['inbox'] ?? 0;
        $count['sent'] = $count['sent'] ?? 0;
        $count['trash'] = $count['trash'] ?? 0;
        $count['junk'] = $count['junk'] ?? 0;
        $count['archive'] = $count['archive'] ?? 0;
        $count['drafts'] = $count['drafts'] ?? 0;


//        $count['inbox'] = count($inboxEmails);
//        $sentEmails = Email::where('folder', 'sent')->where('email_account_id', $request->email_account_id)->get();
//        $count['sent'] = count($sentEmails);
//        $trashEmails = Email::where('folder', 'trash')->where('email_account_id', $request->email_account_id)->get();
//        $count['trash'] = count($trashEmails);
//        $count['junk'] = Email::where('folder', 'junk')->where('email_account_id', $request->email_account_id)->count();
//        $count['archive'] = Email::where('folder', 'archive')->where('email_account_id', $request->email_account_id)->count();
//        $count['drafts'] = Email::where('folder', 'drafts')->where('email_account_id', $request->email_account_id)->count();
        $params = $request->all();

        return Inertia::render('EmailFetch/Index', [
            'emails' => $emails->paginate()->withQueryString(),
            'count' => $count,
            'emailSettings' => $emailSettings,
            'colors' => $colors,
            'activeEmail' => $email,
            'activeEmailId' => $emailId,
            'type' => 'Inbox',
            'params' => $params,
        ]);
    }


    public function sortables(Request $request)
    {
        $sorts = [];
        foreach (['from_name',
                     'from_email',
                     'subject'] as $sort) {
            if ($request->get($sort)) {
                $sorts[] = $sort;
            }
        }
        return $sorts;
    }

    public function composeEmailSend(Request $request)
    {
        $data = array(
            'subject' => $request->subject,
            'body' => $request->body,
        );

        $to = array();
        $to = explode('; ', $request->to);
        if (substr($to[sizeOf($to) - 1], -1) === ';') {
            $to[sizeOf($to) - 1] = substr($to[sizeOf($to) - 1], 0, -1);
        }
        $cc = array();
        if ($request->cc !== null) {
            $cc = explode('; ', $request->cc);
            if (substr($cc[sizeOf($cc) - 1], -1) === ';') {
                $cc[sizeOf($cc) - 1] = substr($cc[sizeOf($cc) - 1], 0, -1);
            }
        }
        $bcc = array();
        if ($request->bcc !== null) {
            $bcc = explode('; ', $request->bcc);
            if (substr($bcc[sizeOf($bcc) - 1], -1) === ';') {
                $bcc[sizeOf($bcc) - 1] = substr($bcc[sizeOf($bcc) - 1], 0, -1);
            }
        }

        $emailSetting = EmailSetting::where('username', $request->from)->first();
        $backup = Mail::getSwiftMailer();
        $transport = new Swift_SmtpTransport($emailSetting->smtp_outgoing_server, $emailSetting->smtp_outgoing_port, $emailSetting->smtp_outgoing_encryption);
        $transport->setUsername($emailSetting->username);
        $transport->setPassword($emailSetting->password);
        $mailtrap = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailtrap);

        if ($request->cc !== null && $request->bcc !== null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $cc, $bcc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->subject($data['subject'])
                    ->setBody(nl2br($request->get('body')), 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        } else if ($request->cc !== null && $request->bcc === null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $cc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->cc($cc)
                    ->subject($data['subject'])
                    ->setBody(nl2br($request->get('body')), 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        } else if ($request->cc === null && $request->bcc !== null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $bcc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->bcc($bcc)
                    ->subject($data['subject'])
                    ->setBody(nl2br($request->get('body')), 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        } else {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->subject($data['subject'])
                    ->setBody(nl2br($request->get('body')), 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        }

        $savedDateTime = date_format(Carbon::now(), "r");
        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $emailSetting->username, $emailSetting->password);
        $boundary = "------=" . md5(uniqid(rand()));
        $header = "From: $emailSetting->username\r\n";

        if ($request->to !== null) {
            foreach ($to as $key => $singleTo) {
                if ($key === 0) {
                    $header .= "To: <" . trim($singleTo) . ">";
                } else {
                    $header .= ", <" . trim($singleTo) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request->cc !== null) {
            foreach ($cc as $key => $singleCc) {
                if ($key === 0) {
                    $header .= "Cc: <" . trim($singleCc) . ">";
                } else {
                    $header .= ", <" . trim($singleCc) . ">";
                }
            }
            $header .= "\r\n";
        }

        if ($request->bcc !== null) {
            foreach ($bcc as $key => $singleBcc) {
                if ($key === 0) {
                    $header .= "Bcc: <" . trim($singleBcc) . ">";
                } else {
                    $header .= ", <" . trim($singleBcc) . ">";
                }
            }
            $header .= "\r\n";
        }

        $header .= "Subject: $request->subject\r\n";
        $header .= "Date: $savedDateTime\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--$boundary\r\n";
        $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $header .= nl2br($request->body) . "\r\n\r\n";
        $header .= "--$boundary\r\n";
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $header .= "--$boundary" . "\r\n";
                $file_size = filesize($file);
                $handle = fopen($file, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $content = chunk_split(base64_encode($content));
                $header .= "Content-Type: application/octet-stream; name=\"" . $file->getClientOriginalName() . "\"\r\n"; // use different content types here
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"" . $file->getClientOriginalName() . "\"\r\n\r\n";
                $header .= $content . "\r\n\r\n";
                $header .= "--$boundary" . "\r\n";
            }
        }

        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        $client->connect();
        if ($client->getFolder('Sent')) {
            $folderName = 'Sent';
            goto b;
        }
        if ($client->getFolder('Sent Items')) {
            $folderName = 'Sent Items';
            goto b;
        }
        if ($client->getFolder('Sent Messages')) {
            $folderName = 'Sent Messages';
            goto b;
        }
        b:
        $sendEmail = imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}$folderName", $header, "\\Seen");
        imap_close($stream);
        Mail::setSwiftMailer($backup);

        if (!$sendEmail) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'Email not send due to slow internet.'
            ]);
            throw $error;
        }

        return Redirect::back()->with('success', 'Email send successfully');;
    }

    public function forwardEmailSend(Request $request)
    {
        $data = array();
        $to = array();
        $to = explode('; ', $request->to);
        if (substr($to[sizeOf($to) - 1], -1) === ';') {
            $to[sizeOf($to) - 1] = substr($to[sizeOf($to) - 1], 0, -1);
        }
        $cc = array();
        if ($request->cc !== null) {
            $cc = explode('; ', $request->cc);
            if (substr($cc[sizeOf($cc) - 1], -1) === ';') {
                $cc[sizeOf($cc) - 1] = substr($cc[sizeOf($cc) - 1], 0, -1);
            }
        }
        $bcc = array();
        if ($request->bcc !== null) {
            $bcc = explode('; ', $request->bcc);
            if (substr($bcc[sizeOf($bcc) - 1], -1) === ';') {
                $bcc[sizeOf($bcc) - 1] = substr($bcc[sizeOf($bcc) - 1], 0, -1);
            }
        }

        $emailSetting = EmailSetting::where('username', $request->from)->first();
        if ($emailSetting) {
            $data = array(
                'subject' => substr($request->subject, 0, 3) === 'FW:' ? $request->subject : 'FW: ' . $request->subject,
                'body' => $request->body
            );
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'From email not exist in this system.'
            ]);
            throw $error;
        }

        $backup = Mail::getSwiftMailer();
        $transport = new Swift_SmtpTransport($emailSetting->smtp_outgoing_server, $emailSetting->smtp_outgoing_port, $emailSetting->smtp_outgoing_encryption);
        $transport->setUsername($emailSetting->username);
        $transport->setPassword($emailSetting->password);
        $mailtrap = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailtrap);

        if ($request->cc !== null && $request->bcc !== null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $cc, $bcc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->subject($data['subject'])
                    ->setBody($request->get('body'), 'text/html');
                if ($request->hasFile('uploadAttachments')) {
                    foreach ($request->file('uploadAttachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
                if ($request->attachments !== null) {
                    foreach ($request->attachments as $file) {
                        $message->attachData(file_get_contents(public_path('storage/' . $file['path'])), $file['name']);
                    }
                }
            });
        } else if ($request->cc !== null && $request->bcc === null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $cc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->cc($cc)
                    ->subject($data['subject'])
                    ->setBody($request->get('body'), 'text/html');
                if ($request->hasFile('uploadAttachments')) {
                    foreach ($request->file('uploadAttachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
                if ($request->attachments !== null) {
                    foreach ($request->attachments as $file) {
                        $message->attachData(file_get_contents(public_path('storage/' . $file['path'])), $file['name']);
                    }
                }
            });
        } else if ($request->cc === null && $request->bcc !== null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $bcc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->bcc($bcc)
                    ->subject($data['subject'])
                    ->setBody($request->get('body'), 'text/html');
                if ($request->hasFile('uploadAttachments')) {
                    foreach ($request->file('uploadAttachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
                if ($request->attachments !== null) {
                    foreach ($request->attachments as $file) {
                        $message->attachData(file_get_contents(public_path('storage/' . $file['path'])), $file['name']);
                    }
                }
            });
        } else {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->subject($data['subject'])
                    ->setBody($request->get('body'), 'text/html');
                if ($request->hasFile('uploadAttachments')) {
                    foreach ($request->file('uploadAttachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
                if ($request->attachments !== null) {
                    foreach ($request->attachments as $file) {
                        $message->attachData(file_get_contents(public_path('storage/' . $file['path'])), $file['name']);
                    }
                }
            });
        }

        $subject = $data['subject'];
        $savedDateTime = date_format(Carbon::now(), "r");
        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $emailSetting->username, $emailSetting->password);
        $boundary = "------=" . md5(uniqid(rand()));

        if ($request->in_reply_to !== null) {
            $header = "In-Reply-To: <" . $request->in_reply_to[0] . ">\r\n";
            $header .= "References: <" . $request->in_reply_to[0] . ">\r\n";
            $header .= "From: $emailSetting->username\r\n";
        }
        else {
            $header = "From: $emailSetting->username\r\n";
        }

        if ($request->to !== null) {
            foreach ($to as $key => $singleTo) {
                if ($key === 0) {
                    $header .= "To: <" . trim($singleTo) . ">";
                } else {
                    $header .= ", <" . trim($singleTo) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request->cc !== null) {
            foreach ($cc as $key => $singleCc) {
                if ($key === 0) {
                    $header .= "Cc: <" . trim($singleCc) . ">";
                } else {
                    $header .= ", <" . trim($singleCc) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request->bcc !== null) {
            foreach ($bcc as $key => $singleBcc) {
                if ($key === 0) {
                    $header .= "Bcc: <" . trim($singleBcc) . ">";
                } else {
                    $header .= ", <" . trim($singleBcc) . ">";
                }
            }
            $header .= "\r\n";
        }

        $header .= "Subject: $subject\r\n";
        $header .= "Date: $savedDateTime\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";
        $header .= "--$boundary\r\n";
        $header .= "Content-type:text/html; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $header .= $request->body . "\r\n\r\n";
        $header .= "--$boundary\r\n";
        if ($request->hasFile('uploadAttachments')) {
            foreach ($request->file('uploadAttachments') as $file) {
                $header .= "--$boundary" . "\r\n";
                $file_size = filesize($file);
                $handle = fopen($file, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $content = chunk_split(base64_encode($content));
                $header .= "Content-Type: application/octet-stream; name=\"" . $file->getClientOriginalName() . "\"\r\n"; // use different content types here
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"" . $file->getClientOriginalName() . "\"\r\n\r\n";
                $header .= $content . "\r\n\r\n";
                $header .= "--$boundary" . "\r\n";
            }
        }
        if ($request->attachments !== null) {
            foreach ($request->attachments as $file) {
                $header .= "--$boundary" . "\r\n";
                $file_size = filesize(public_path('storage/' . $file['path']));
                $handle = fopen(public_path('storage/' . $file['path']), "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $content = chunk_split(base64_encode($content));
                $header .= "Content-Type: application/octet-stream; name=\"" . $file['name'] . "\"\r\n"; // use different content types here
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"" . $file['name'] . "\"\r\n\r\n";
                $header .= $content . "\r\n\r\n";
                $header .= "--$boundary" . "\r\n";
            }
        }
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        if ($client->getFolder('Sent')) {
            $folderName = 'Sent';
            goto b;
        }
        if ($client->getFolder('Sent Items')) {
            $folderName = 'Sent Items';
            goto b;
        }
        if ($client->getFolder('Sent Messages')) {
            $folderName = 'Sent Messages';
            goto b;
        }

        b:
        $sendEmail = imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}$folderName", $header, "\\Seen");
        imap_close($stream);
        Mail::setSwiftMailer($backup);

        if (!$sendEmail) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'Email not send due to slow internet.'
            ]);
            throw $error;
        }

        return Redirect::back()->with('success', 'Reply send successfully');
    }

    public function reply(Request $request)
    {
        $this->validate($request, [
            'email_id' => ['required'],
            'subject' => ['required'],
            'body' => ['required'],
            'to' => ['required'],
            'from' => ['required']
        ]);

        $data = array();
        $to = array();
        $to = explode('; ', $request->to);
        if (substr($to[sizeOf($to) - 1], -1) === ';') {
            $to[sizeOf($to) - 1] = substr($to[sizeOf($to) - 1], 0, -1);
        }
        $cc = array();
        if ($request->cc !== null) {
            $cc = explode('; ', $request->cc);
            if (substr($cc[sizeOf($cc) - 1], -1) === ';') {
                $cc[sizeOf($cc) - 1] = substr($cc[sizeOf($cc) - 1], 0, -1);
            }
        }
        $bcc = array();
        if ($request->bcc !== null) {
            $bcc = explode('; ', $request->bcc);
            if (substr($bcc[sizeOf($bcc) - 1], -1) === ';') {
                $bcc[sizeOf($bcc) - 1] = substr($bcc[sizeOf($bcc) - 1], 0, -1);
            }
        }

        $emailSetting = EmailSetting::where('username', $request->from)->first();
        if ($emailSetting) {
            $data = array(
                'subject' => substr($request->subject, 0, 3) === 'RE:' ? $request->subject : 'RE: ' . $request->subject,
                'body' => $request->has('replyBodyContent') ? $request->replyBodyContent : $request->body
            );
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'From email not exist in this system.'
            ]);
            throw $error;
        }

        $backup = Mail::getSwiftMailer();
        $transport = new Swift_SmtpTransport($emailSetting->smtp_outgoing_server, $emailSetting->smtp_outgoing_port, $emailSetting->smtp_outgoing_encryption);
        $transport->setUsername($emailSetting->username);
        $transport->setPassword($emailSetting->password);
        $mailtrap = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailtrap);

        if ($request->cc !== null && $request->bcc !== null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $cc, $bcc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->subject($data['subject'])
                    ->setBody($data['body'], 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        } else if ($request->cc !== null && $request->bcc === null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $cc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->cc($cc)
                    ->subject($data['subject'])
                    ->setBody($data['body'], 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        } else if ($request->cc === null && $request->bcc !== null) {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to, $bcc) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->bcc($bcc)
                    ->subject($data['subject'])
                    ->setBody($data['body'], 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        } else {
            Mail::send([], [], function ($message) use ($emailSetting, $data, $request, $to) {
                $message->from($emailSetting->username)
                    ->to($to)
                    ->subject($data['subject'])
                    ->setBody($data['body'], 'text/html');
                if ($request->hasFile('attachments')) {
                    foreach ($request->file('attachments') as $file) {
                        $message->attachData(file_get_contents($file), $file->getClientOriginalName());
                    }
                }
            });
        }

        $subject = $data['subject'];
        $savedDateTime = date_format(Carbon::now(), "r");
        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $emailSetting->username, $emailSetting->password);
        $boundary = "------=" . md5(uniqid(rand()));

        if ($request->message_id != null) {
            $header = "In-Reply-To: <" . $request->message_id . ">\r\n";
            $header .= "References: <" . $request->message_id . ">\r\n";
        }
        else {
            $randomMessageIdPart = Str::random(40);
            $header = "In-Reply-To: <" . $randomMessageIdPart . $emailSetting->username . ">\r\n";
            $header .= "References: <" . $randomMessageIdPart. $emailSetting->username . ">\r\n";
        }

        $header .= "From: $emailSetting->username\r\n";

        if ($request->to !== null) {
            foreach ($to as $key => $singleTo) {
                if ($key === 0) {
                    $header .= "To: <" . trim($singleTo) . ">";
                } else {
                    $header .= ", <" . trim($singleTo) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request->cc !== null) {
            foreach ($cc as $key => $singleCc) {
                if ($key === 0) {
                    $header .= "Cc: <" . trim($singleCc) . ">";
                } else {
                    $header .= ", <" . trim($singleCc) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request->bcc !== null) {
            foreach ($bcc as $key => $singleBcc) {
                if ($key === 0) {
                    $header .= "Bcc: <" . trim($singleBcc) . ">";
                } else {
                    $header .= ", <" . trim($singleBcc) . ">";
                }
            }
            $header .= "\r\n";
        }

        $header .= "Subject: $subject\r\n";
        $header .= "Date: $savedDateTime\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";
        $header .= "--$boundary\r\n";
        $header .= "Content-type:text/html; charset=utf-8\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $header .= $data['body'] . "\r\n\r\n";
        $header .= "--$boundary\r\n";
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $header .= "--$boundary" . "\r\n";
                $file_size = filesize($file);
                $handle = fopen($file, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $content = chunk_split(base64_encode($content));
                $header .= "Content-Type: application/octet-stream; name=\"" . $file->getClientOriginalName() . "\"\r\n"; // use different content types here
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"" . $file->getClientOriginalName() . "\"\r\n\r\n";
                $header .= $content . "\r\n\r\n";
                $header .= "--$boundary" . "\r\n";
            }
        }

        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        if ($client->getFolder('Sent')) {
            $folderName = 'Sent';
            goto b;
        }
        if ($client->getFolder('Sent Items')) {
            $folderName = 'Sent Items';
            goto b;
        }
        if ($client->getFolder('Sent Messages')) {
            $folderName = 'Sent Messages';
            goto b;
        }

        b:
        $sendEmail = imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}$folderName", $header, "\\Seen");
        imap_close($stream);
        Mail::setSwiftMailer($backup);

        if (!$sendEmail) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'Email not send due to slow internet.'
            ]);
            throw $error;
        }

        return Redirect::back()->with('success', 'Reply send successfully');
    }

    public function status(Request $request)
    {
        $email = Email::find($request->get("email_id"));
        $email->update(['marked_as_read' => 1]);
        $emails = Email::with('attachments', 'inlineAttachments')->where('folder', 'INBOX')
            ->where('parent_id', null)
            ->with('childEmails.attachments')
            ->orderBy('email_id', 'DESC')->paginate(10);
        return response()->json($emails, 200);
    }

    public function emailMark(Request $request)
    {
        $emailSetting = EmailSetting::where('username', $request->activeEmail)->first();
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        $folder = $client->getFolder($request->folder);
        $message = $folder->query()->getMessageByUid($request->emailId);
        if($message->getFlags()->has('seen')) {
            $message->unsetFlag('Seen');
            
            return response()->json([
                'result' => false
            ]);
        }
        else {
            $message->setFlag('Seen');
            
            return response()->json([
                'result' => true
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {

        set_time_limit(500);
        /** @var \Webklex\PHPIMAP\Client $client */

        if ($request->get('email') != null) {
            $emailSettings = EmailSetting::where('status', 1)->where('username', $request->get('email'))->orderBy('username')->get();
        } else {
            $emailSettings = EmailSetting::where('status', 1)->limit(1)->get();
        }

        foreach ($emailSettings as $emailSetting) {
            $results = $this->fetchEmail($emailSetting);
        }

        if ($request->has('email')) {
            if ($request->has('case_id')) {
                return Redirect::route('cases.show', $request->case_id);
            } else {
                return Redirect::back();
            }
        } else {
            return redirect(route('fetch-email.index'))->with('success', 'Product title created successfully');
        }
    }

    public function changeFolder($id, $activeEmail, $originalFolder, $moveTofolder)
    {
        $emailSetting = EmailSetting::where('username', $activeEmail)->first();
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        $folder = $client->getFolder($originalFolder);
        $message = $folder->query()->getMessageByUid($id);

        if ($moveTofolder === 'archive') {
            $moveMessage = $message->move('Archive');
        }
        if ($moveTofolder === 'inbox') {
            $moveMessage = $message->move('INBOX');
        }
        if ($moveTofolder === 'sent') {
            if ($client->getFolder('Sent')) {
                $moveMessage = $message->move('Sent');
                goto b;
            }
            if ($client->getFolder('Sent Items')) {
                $moveMessage = $message->move('Sent Items');
                goto b;
            }
            if ($client->getFolder('Sent Messages')) {
                $moveMessage = $message->move('Sent Messages');
                goto b;
            }
        }
        if ($moveTofolder === 'drafts') {
            $moveMessage = $message->move('Drafts');
        }
        if ($moveTofolder === 'junk') {
            if ($client->getFolder('Junk')) {
                $moveMessage = $message->move('Junk');
                goto b;
            }
            if ($client->getFolder('Junk Email')) {
                $moveMessage = $message->move('Junk Email');
                goto b;
            }
        }
        if ($moveTofolder === 'trash') {
            if ($client->getFolder('Trash')) {
                $moveMessage = $message->move('Trash');
                goto b;
            }
            if ($client->getFolder('Deleted Items')) {
                $moveMessage = $message->move('Deleted Items');
                goto b;
            }
        }

        b:
        $uid = $moveMessage->getAttributes()["uid"];

        return Redirect::back()->with('success', 'Email move successfully');
    }

    public function emailStarStatus(Request $request)
    {
        $emailSetting = EmailSetting::where('username', $request->activeEmail)->first();
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        $folder = $client->getFolder($request->folder);
        $message = $folder->query()->getMessageByUid($request->emailId);
        if($message->getFlags()->has('flagged')) {
            $message->unsetFlag('Flagged');
            
            return response()->json([
                'result' => false
            ]);
        }
        else {
            $message->setFlag('Flagged');
            
            return response()->json([
                'result' => true
            ]);
        }
    }

    public function permanentDeleteEmail($id, $activeEmail, $folder) 
    {
        $emailSetting = EmailSetting::where('username', $activeEmail)->first();
        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        $folder = $client->getFolder($folder);
        $message = $folder->query()->getMessageByUid($id);
        $message->delete(true);
        
        return Redirect::back()->with('success', 'Email move successfully');
    }

    public function draftsEmail(Request $request)
    {
        $to = array();
        if ($request['form']['to'] !== null) {
            $to = explode('; ', $request['form']['to']);
            if (substr($to[sizeOf($to) - 1], -1) === ';') {
                $to[sizeOf($to) - 1] = substr($to[sizeOf($to) - 1], 0, -1);
            }
        }
        $cc = array();
        if ($request['form']['cc'] !== null) {
            $cc = explode('; ', $request['form']['cc']);
            if (substr($cc[sizeOf($cc) - 1], -1) === ';') {
                $cc[sizeOf($cc) - 1] = substr($cc[sizeOf($cc) - 1], 0, -1);
            }
        }
        $bcc = array();
        if ($request['form']['bcc'] !== null) {
            $bcc = explode('; ', $request['form']['bcc']);
            if (substr($bcc[sizeOf($bcc) - 1], -1) === ';') {
                $bcc[sizeOf($bcc) - 1] = substr($bcc[sizeOf($bcc) - 1], 0, -1);
            }
        }

        $emailSetting = EmailSetting::where('username', $request['form']['from'])->first();
        if (!$emailSetting) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'name' => 'From email not exist in this system.'
            ]);
            throw $error;
        }

        $backup = Mail::getSwiftMailer();
        $transport = new Swift_SmtpTransport($emailSetting->smtp_outgoing_server, $emailSetting->smtp_outgoing_port, $emailSetting->smtp_outgoing_encryption);
        $transport->setUsername($emailSetting->username);
        $transport->setPassword($emailSetting->password);
        $mailtrap = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailtrap);

        $savedDateTime = date_format(Carbon::now(), "r");
        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $emailSetting->username, $emailSetting->password);
        $boundary = "------=" . md5(uniqid(rand()));

        if ($request['form']['message_id'] != null) {
            $header = "In-Reply-To: <" . $request['form']['message_id'] . ">\r\n";
            $header .= "References: <" . $request['form']['message_id'] . ">\r\n";
        }
        else {
            $randomMessageIdPart = Str::random(40);
            $header = "In-Reply-To: <" . $randomMessageIdPart . $emailSetting->username . ">\r\n";
            $header .= "References: <" . $randomMessageIdPart. $emailSetting->username . ">\r\n";
        }

        $header .= "From: " . $request['form']['from'] . "\r\n";

        if ($request['form']['to'] !== null) {
            foreach ($to as $key => $singleTo) {
                if ($key === 0) {
                    $header .= "To: <" . trim($singleTo) . ">";
                } else {
                    $header .= ", <" . trim($singleTo) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request['form']['cc'] !== null) {
            foreach ($cc as $key => $singleCc) {
                if ($key === 0) {
                    $header .= "Cc: <" . trim($singleCc) . ">";
                } else {
                    $header .= ", <" . trim($singleCc) . ">";
                }
            }
            $header .= "\r\n";
        }
        if ($request['form']['bcc'] !== null) {
            foreach ($bcc as $key => $singleBcc) {
                if ($key === 0) {
                    $header .= "Bcc: <" . trim($singleBcc) . ">";
                } else {
                    $header .= ", <" . trim($singleBcc) . ">";
                }
            }
            $header .= "\r\n";
        }

        if ($request['form']['subject']) {
            $subject = substr($request['form']['subject'],0,3)==='RE:'? $request['form']['subject'] : 'RE: ' . $request['form']['subject'];
            $header .= "Subject: " . $subject . "\r\n";
        }

        $header .= "Date: $savedDateTime\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";
        $header .= "This is a multi-part message in MIME format.\r\n";
        $header .= "--$boundary\r\n";
        $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $header .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $header .= nl2br($request['form']['body']) . "\r\n\r\n";
        $header .= "--$boundary\r\n";

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $header .= "--$boundary" . "\r\n";
                $file_size = filesize($file);
                $handle = fopen($file, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $content = chunk_split(base64_encode($content));
                $header .= "Content-Type: application/octet-stream; name=\"" . $file->getClientOriginalName() . "\"\r\n"; // use different content types here
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"" . $file->getClientOriginalName() . "\"\r\n\r\n";
                $header .= $content . "\r\n\r\n";
                $header .= "--$boundary" . "\r\n";
            }
        }

        set_time_limit(10000);
        ini_set('memory_limit', '-1');
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $emailSetting->password,
            'protocol' => $emailSetting->protocol,
        ]);
        if ($client) {
            try {
                $client->connect();
            } catch (\Exception $e) {
                $error = \Illuminate\Validation\ValidationException::withMessages([
                    'name' => 'Connection not established due to slow internet or email password incorrect.'
                ]);
                throw $error;
            }
        }

        $liveSavedMail = imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Drafts", $header, "\\Draft");
        imap_close($stream);
        Mail::setSwiftMailer($backup);

        if (!$liveSavedMail) {
            return response()->json([
                'message' => 'Mail not move to drafts folder live successfully.'
            ]);
        }

        return response()->json([
            'message' => 'Mail move to drafts folder live successfully.'
        ]);
    }

    public function fetchingEmailDetail(Request $request)
    {
        dd("ok");
        $emailSetting = EmailSetting::where('status', 1)->where('username', $request->get('activeEmail'))->orderBy('username')->first();
        return response()->json([
            'data' => $emailSetting
        ]);
    }

    public function export($id)
    {
        $attachment = Attachment::where('id', $id)->firstOrFail();

        if ($attachment->content_id) {
            $data = $attachment->content_id;
        }

        return response()->download(storage_path('app/public/images/' . $data));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $emailAccountCredential = EmailSetting::where('username', $request->get('active_account'))->first();
        $folderName = $request->get('active_folder');
        $from = $request->get('from');
        $subject = $request->get('subject');
        $imapConnector = new ImapConnect($emailAccountCredential);
        $imapClient = $imapConnector->imapClientConnection();
        if ($imapClient->isConnected()) {
            $folder = $imapClient->getFolderByName($folderName);
            $messages = $folder->query()->from($from)->subject($subject)->get();

            dd($messages);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function fetchEmail($emailSetting)
    {
        $client = new ImapConnect();

        $client = $client->imapClientConnection($emailSetting);

        if ($client) {
            $folders = $client->getFolders($hierarchical = true);

            // Class for Import emails in to database
            $importEmail = new ImportEmail();
            $importEmail = $importEmail->importEmail($folders, $emailSetting);

            Email::insert($importEmail['data']);
            Attachment::insert($importEmail['attachmentData']);
            $client->disconnect();
        }
//
//        $emailSettings = EmailSetting::where('status', 1)->get();
//
//        return dispatch(new ImportEmailsJob($emailSetting));
    }

    private function cleanSubject($subject)
    {
        if (Str::of($subject)->startsWith('RE:') || Str::of($subject)->startsWith('Re:')) {
            return Str::of($subject)->after(':')->trim();
        }
        return $subject;
    }

    public function allEmail(Request $request)
    {
        $emails = Email::query();
        $emails = $this->search($emails, [
            'from_name',
            'from_email',
            'subject'
        ]);
        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $emails = $this->sort($emails, $columns, $request->get('direction'));
        }
        $colors = [
            'default' => '#606003',
            'info@ejogga.com' => '#5BFF33',
            'info@boomtekk.com' => '#33FFDA',
            'info@xstreamgym.com' => '#FF8D33',
            'delivery@ejogga.com' => '#C4FF33',
            'care@xstreamgym.com' => '#606003',
            'info@stockovers.co.uk' => '#876C6C',
            'care@bingbangbosh.com' => '#FF4933',
            'delivery@boomtekk.com' => '#33F0FF',
            'info@bingbangbosh.com' => '#FFCE33',
            'info@xstreamgymuk.com' => '#3393FF',
            'care@xstreamgymuk.com' => '#F597B2',
            'aron.adams@boomtekk.com' => '#524848',
            'delivery@xstreamgym.com' => '#FE2A67',
            'support@bingbangbosh.com' => '#33B8FF',
            'mo.allen@bingbangbosh.com' => '#C433FF',
            'alex.adams@xstreamgym.com' => '#DE2AFE',
            'delivery@stockovers.co.uk' => '#F59797',
            'Delivery@bingbangbosh.com' => '#91561a',
            'alex.adams@bingbangbosh.com' => '#3342FF',
            'mariah.ellie@bingbangbosh.com' => '#8333FF',
        ];

        $emails = $emails->with('attachments', 'inlineAttachments', 'childEmails.attachments')->where('folder', 'INBOX')
            ->where('parent_id', null)
            ->orderBy('email_id', 'DESC')->paginate();
        $emailSettings = EmailSetting::where('status', 1)->orderBy('username')->get();
        $params = $request->all();

        $inboxCount = Email::where('folder', 'INBOX')->count();
        $trashCount = Email::where('folder', 'trash')->count();
        $junkCount = Email::where('folder', 'Junk')->count();
        $sentCount = Email::where('folder', 'Sent')->count();
        $archiveCount = Email::where('folder', 'Archive')->count();

        return Inertia::render('EmailFetch/Index', [
            'emails' => $emails->withQueryString(),
            'inboxCount' => $inboxCount,
            'trashCount' => $trashCount,
            'junkCount' => $junkCount,
            'archiveCount' => $archiveCount,
            'sentCount' => $sentCount,
            'emailSettings' => $emailSettings,
            'colors' => $colors
        ]);
    }

    private function getFolderName($folderName)
    {
        $folderNames = ['Archive' => 'Archive',
            'Drafts' => 'Drafts',
            'INBOX' => 'INBOX',
            'inbox' => 'inbox',
            'Inbox' => 'Inbox',
            'Junk' => 'Junk',
            'Junk Email' => 'Junk Email',
            'Sent' => 'Sent',
            'Sent Items' => 'Sent Items',
            'Sent Messages' => 'Sent Messages',
            'Trash' => 'Trash',
            'Deleted Items' => 'Deleted Items'
        ];
        return $folderNames[$folderName] ?? null;

    }

    private function getEmailBodyWithReplacedImages($message)
    {
        $bodyParts = explode('</html>', $message->getHTMLBody());
        $body = $bodyParts[0] . '</html>';
        $body = preg_split('/<body.*?\s?>/', $body);
        if (isset($body[1])) {
            $body = Str::of($body[1])->before('</body>');
            $body = preg_replace('/<style>(.*)?<\/style>/ms','',$body);

        } else {
            $body = $body[0];
            $body = preg_replace('/<style>(.*)?<\/style>/ms','',$body);
        }

        if ($message->hasAttachments()) {
            $attachments = $message->getAttachments();
            foreach ($attachments as $attachment) {
                if ($attachment->type == 'image' || $attachment->type == 'text' && $attachment->img_src == null) {
                    $imgSrc = 'data:' . $attachment->content_type . ';base64,' . base64_encode($attachment->content);
                    if ($attachment->id && $imgSrc != null) {
                        $body = str_replace('cid:' . $attachment->id, $imgSrc, $body);
                    }
                }
            }
        }

        //when imap package skip inline attachments this code extract skipped images and embed into html template
        if (isset($bodyParts[1]) && strlen(substr($bodyParts[1], 20)) > 15) {
            $bodyParts[1] = '';
            $header = $message->getHeader();
            $boundary = $header->find("/boundary=\"?([^\"]*)[\";\s]/");
            $rawBody = $message->getRawBody();
            $parts = preg_split("/-*$boundary-*/", $rawBody, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($parts as $part) {
                $headerInfo = [];
                $headerAdditionalInfo = [];
                preg_match_all('/(Content-.*):(\s?.*;?)/', $part, $headers);
                if (isset($headers[2])) {
                    foreach ($headers[1] as $index => $value) {
                        if ($value == 'Content-Type') {
                            $subHeaders = preg_split('/;/', $headers[2][$index], -1, PREG_SPLIT_NO_EMPTY);
                            $headerInfo[$value] = trim($subHeaders[0]);
                            if (isset($subHeaders[1])) {
                                $headerAdditionalInfo[] = $subHeaders[1];
                            }
                            continue;
                        }
                        if ($value == 'Content-Disposition') {
                            $subHeaders = preg_split('/;/', $headers[2][$index], -1, PREG_SPLIT_NO_EMPTY);
                            $headerInfo[$value] = trim($subHeaders[0]);
                            if (isset($subHeaders[1])) {
                                $headerAdditionalInfo[] = $subHeaders[1];
                            }
                            if (isset($subHeaders[2])) {
                                $headerAdditionalInfo[] = $subHeaders[2];
                            }
                            continue;
                        }
                        $headerInfo[$value] = Str::of($headers[2][$index])->trim()->ltrim('<')->rtrim('>')->rtrim('\r');
                    }
                }
                foreach ($headerAdditionalInfo as $info) {
                    preg_match_all('/^\s?(.*)=\"?(.*)\"?/', $info, $matches);
                    if (isset($matches[1]) && isset($matches[1][0]) && isset($matches[2]) && isset($matches[2][0])) {
                        $headerInfo[$matches[1][0]] = rtrim(trim($matches[2][0]), '\r');
                    }
                }
                if (isset($headerInfo['Content-Type'])) {
                    $headerInfo['type'] = preg_split('/\//', $headerInfo['Content-Type'], -1, PREG_SPLIT_NO_EMPTY)[0];
                }

                preg_match_all('/\r\n\r\n\"*(.*)$/ms', $part, $contents);
                $contents[0] = '';
                if (isset($contents[1]) && isset($contents[1][0])) {
                    if (isset($headerInfo['Content-Disposition']) && $headerInfo['Content-Disposition'] == 'inline') {
                        $imgSrc = 'data:' . $headerInfo['Content-Type'] . ';base64,' . trim($contents[1][0]);
                        if ($headerInfo['Content-ID'] && $imgSrc != null) {
                            $body = str_replace('cid:' . $headerInfo['Content-ID'], $imgSrc, $body);
                        }
                    }
                }

            }
        }
        // end

        return $body;
    }

    private function getAttachments($attachments): array
    {
        $data = [];
        foreach ($attachments as $attachment) {

            $disposition = $attachment->getAttributes()["disposition"] ? $attachment->getAttributes()["disposition"]->get('values')[0] : null;
    if ($disposition == 'attachment' || $disposition == null ) {
                $properties = [];
                $properties['name'] = $attachment->getAttributes()["name"] ?? 'Undefined';
                $properties['content_type'] = $attachment->get('content_type');
                $properties['type'] = $attachment->getAttributes()["type"];
                $properties['size'] = $attachment->getAttributes()["size"];
                $properties['extension'] = $attachment->getExtension();
                $properties['path'] = 'email-attachments/' . uniqid() . $properties['name'];
                Storage::disk('local')->put($properties['path'], $attachment->getAttributes()["content"]);
                $data[] = $properties;
            }
        }
        return $data;

    }
}
