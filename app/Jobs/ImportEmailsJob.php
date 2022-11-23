<?php

namespace App\Jobs;

use App\Models\Attachment;
use App\Models\Attendences;
use App\Models\Cases;
use App\Models\Email;
use App\Models\EmailSetting;
use App\Services\ImapConnect;
use App\Services\ImportEmail;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class ImportEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $folders;
    protected $emailSettings;
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailSettings)
    {

        $this->emailSettings = $emailSettings;


//        dd($this->folders,$this->emailSetting);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Class for imap connection

        foreach ($this->emailSettings as $emailSetting) {
            $client = new ImapConnect();
            if ($client) {
                $client = $client->imapClientConnection($emailSetting);

                $folders = $client->getFolders($hierarchical = true);

                // Class for Import emails in to database
                $importEmail = new ImportEmail();
                $importEmail = $importEmail->importEmail($folders, $emailSetting);

                Email::insertOrIgnore($importEmail['data']);
                Attachment::insert($importEmail['attachmentData']);
            }

        }

        $emailSettings = EmailSetting::where('status', 1)->get();
        return dispatch(new ImportEmailsJob($emailSettings))->delay(1);
    }
}
