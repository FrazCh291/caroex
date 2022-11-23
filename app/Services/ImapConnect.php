<?php

namespace App\Services;

use Webklex\PHPIMAP\Facades\Client;
use Webklex\PHPIMAP\ClientManager;

class ImapConnect
{
    public $mailbox;

    public function __construct($emailSetting = null)
    {
        $this->mailbox = $emailSetting;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Webklex\PHPIMAP\Exceptions\MaskNotFoundException
     */
    public function imapClientConnection($emailSetting = null)
    {
        if (!$emailSetting) {
            $emailSetting = $this->mailbox;
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


//
//        $client = \Webklex\PHPIMAP\Facades\Client::make([
//            'host' => $emailSetting->incoming_server,
//            'port' => $emailSetting->incoming_port,
//            'encryption' => $emailSetting->incoming_encryption,
//            'username' => $emailSetting->username,
//            'validate_cert' => true,
//            'password' => $emailSetting->password,
//            'protocol' => $emailSetting->protocol,
////            'message' => \Webklex\PHPIMAP\Support\Masks\MessageMask::class,
////            'attachment' => \Webklex\PHPIMAP\Support\Masks\AttachmentMask::class,
//            'options' => [
//                'delimiter' => '/',
//                'fetch' => \Webklex\PHPIMAP\IMAP::FT_PEEK,
//                'sequence' => \Webklex\PHPIMAP\IMAP::ST_MSGN,
//                'fetch_body' => true,
//                'fetch_flags' => true,
//                'message_key' => 'list',
//                'fetch_order' => 'desc',
//                'dispositions' => ['attachment', 'inline'],
//                'open' => [
//                    'DISABLE_AUTHENTICATOR' => 'GSSAPI'
//                ],
//                'decoder' => [
//                    'message' => 'utf-8', // mimeheader
//                    'attachment' => 'utf-8' // mimeheader
//                ]]]);

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

        return $client;
    }
}
