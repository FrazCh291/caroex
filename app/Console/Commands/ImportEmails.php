<?php

namespace App\Console\Commands;

use App\Jobs\ImportEmailsJob;
use App\Models\EmailSetting;
use Illuminate\Console\Command;

class ImportEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Import:Emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $emailSettings = EmailSetting::where('status', 1)->get();
        return dispatch(new ImportEmailsJob($emailSettings));

    }
}
