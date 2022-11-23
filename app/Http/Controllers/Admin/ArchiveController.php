<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Email;
use App\Models\Attachment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SalesChannel;
use App\Models\EmailSetting;
use App\Services\Traits\Sort;
use App\Services\Traits\Filter;
use App\Services\Traits\Search;
use Webklex\PHPIMAP\ClientManager;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class ArchiveController extends Controller
{

    use Sort;
    use Filter;
    use Search;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $emails = Email::query();
        $emails = $request->get('enable') ? $emails->where('enable', 1) : $emails;
        $emails = $request->get('disable') ? $emails->orWhere('enable', 0) : $emails;
        $emails = $this->search($emails, [
            'from_name',
            'from_email',
            'subject'
        ]);

        if ($request->has('direction')) {
            $columns = $this->sortables($request);
            $emails = $this->sort($emails, $columns, $request->get('direction'));
        }
        $emails = $emails->with('attachments', 'inlineAttachments', 'childEmails.attachments')->where('folder', 'Archive')
            ->where('parent_id', null)
            ->orderBy('email_id', 'DESC')->paginate(10);

        $params = $request->all();
//        dd($params);
        $inboxCount = Email::where('folder', 'INBOX')->count();
        $trashCount = Email::where('folder', 'Trash')->count();
        $junkCount = Email::where('folder', 'Junk')->count();
        $sentCount = Email::where('folder', 'Sent')->count();
        $archiveCount = Email::where('folder', 'Archive')->count();

        return Inertia::render('EmailFetch/Index', [
            'emails' => $emails->withQueryString(),
            'inboxCount' => $inboxCount,
            'trashCount' => $trashCount,
            'junkCount' => $junkCount,
            'sentCount' => $sentCount,
            'archiveCount' => $archiveCount
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        set_time_limit(500);
        /** @var \Webklex\PHPIMAP\Client $client */
        $saleChannel = SalesChannel::where('name', 'Ejogga')->first();
        $emailSetting = EmailSetting::where('channel_id', $saleChannel->id)->first();
        $password = Crypt::decryptString($emailSetting->password);

        $cm = new ClientManager($options = []);
        $client = $cm->make([
            'host' => $emailSetting->incoming_server,
            'port' => $emailSetting->incoming_port,
            'encryption' => $emailSetting->incoming_encryption,
            'username' => $emailSetting->username,
            'validate_cert' => true,
            'password' => $password,
            'protocol' => $emailSetting->protocol,
        ]);

        $client->connect();

        $inboxFolder = $client->getFolder('Archive');

        /*$query=$inboxFolder->query();
        $query->fetchOrderDesc();*/
        $query = $inboxFolder->messages();
        $emailFatchs = $query->all()->limit(10)->setFetchOrder("desc")->get();

        //dd($emailFatchs->count());
        //$emailFatchs = $query->all()->limit(10)->get();

        //$emailFatchs = $inboxFolder->messages()->all()->limit(10)->setFetchOrder("desc")->get();

        foreach ($emailFatchs as $message) {
            $msg = $message->getHTMLBody();
            $emailBody = str_replace("cid:", "/storage/images/", $msg);
            $email = Email::firstOrCreate(
                ['email_id' => $message->getUid()],
                [
                    'email_id' => $message->getUid() ? $message->getUid() : null,
                    'company_id' => 1,
                    'subject' => $message->getsubject() ? $message->getSubject() : null,
                    'body' => $emailBody ? $emailBody : null,
                    'from_email' => $message->getFrom() ? $message->getFrom()[0]->mail : null,
                    'from_name' => $message->getFrom() ? $message->getFrom()[0]->personal : null,
                    'to_email' => $message->getTo() ? $message->getTo()[0]->mail : null,
                    'to_name' => $message->getTo() ? $message->getTo()[0]->personal : null,
                    'masked_as_read' => $message->getFlags()->get('seen') == 'seen' ? true : false,
                    'folder' => 'Archive',
                    'date' => $message->getDate()
                ]);
//            if ($email->wasRecentlyCreated) {
            $attachments = $message->getAttachments();

            foreach ($attachments as $attachment) {

                $content = Str::limit($attachment->content, 50);
                $file = $attachment;
                //save format
                $format = $attachment->getO();
                //save full adress of image
                $path = storage_path('app/public/images/');
                $attachment->save($path, $attachment->id);
                Attachment::firstOrCreate(
                    ['content_id' => $attachment->id,
                        'name' => $attachment->name,
                        'content' => $attachment->content],
                    [
                        'email_id' => $email->id,
                        'name' => $attachment->getName(),
//                        'name' => $attachment->id,
                        'url' => '/storage/images/' . $attachment->getName(),
                        'is_inline' => $attachment->getAttributes()['disposition'] && $attachment->getAttributes()['disposition']->get()[0] == 'inline',
                        'content_type' => $format,
                        'content_id' => $attachment->getName(),
                        'content' => $content ? $content : '',
                        'size' => $attachment->size,
                    ]);

            }
        }

        return redirect(route('archive-email.index'))->with('success', 'Product title created successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
