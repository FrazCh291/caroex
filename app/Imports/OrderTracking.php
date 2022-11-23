<?php

namespace App\Imports;

use App\Models\Review;
use App\Models\Setting;
use Swift_Mailer;
use App\Models\Deal;
use App\Models\Order;
use App\Models\Import;
use Swift_SmtpTransport;
use App\Models\Feedback;
use App\Models\OrderItem;
use App\Models\SalesChannel;
use App\Models\EmailSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Webklex\PHPIMAP\Facades\Client;

class OrderTracking implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected $fileName;

    /**
     * @param $file
     */
    public function __construct($file)
    {
        $this->fileName = $file;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $channel_id = request()->get('channel_id');
        $saleChannel = SalesChannel::where('id', $channel_id)->first();
        $import = Import::updateOrCreate(['file_name' => $this->fileName], [
            'channel_id' => $saleChannel->id,
            'file_name' => $this->fileName,
            'user_id' => Auth::user()->id,
            'company_id' => Auth::user() ? Auth::user()->company_id : '',
        ]);
//        $this->logable($import, $saleChannel);

        foreach ($rows as $row) {
            $str = explode(" ID-", $row['ref1']);
            $order = OrderItem::where('id', $str[1])->first();

//            $feedback = new Review();
//            $feedback->company_id = Auth::user() ? Auth::user()->company_id : '';
//            $feedback->customer_id = $order->order ? $order->order->id : '';
//            $feedback->order_id = $order->order_id;
//            $feedback->channel_id = $order->channel_id;
//            $feedback->comment = 'Good';
//            $feedback->rating = 5;
//            $feedback->status = 'pending';
//            $feedback->is_active = True;
//            $feedback->save();

            $orderItem = OrderItem::where('id', $str[1])->first();

            if (!$orderItem->tracking_number) {
                OrderItem::where('id', $str[1])->update(['tracking_number' => $row['urn']]);
                Order::where('id', $order->order_id)->update(['order_status' => 'shipped']);
                $orderDealNumber = Order::where('id', $order->order_id)->first();
                $trackingEmailNotification = Setting::where('type', 'tracking_email_notification')->first();
                if ($trackingEmailNotification && $trackingEmailNotification->enable == true) {
                    $orderItem = OrderItem::where('id', $str[1])->first();
                    $collectDate1 = strtr($this->checkWeekend()['collect_date1'], '-', '/');
                    $collectDate2 = strtr($this->checkWeekend()['collect_date2'], '-', '/');
                    $estimatedDate1 = strtr($this->checkWeekend()['estimated_date1'], '-', '/');
                    $estimatedDate2 = strtr($this->checkWeekend()['estimated_date2'], '-', '/');
                    $collectDate1 = date('d/m/Y', strtotime($collectDate1));

                    $collectDate2 = date('d/m/Y', strtotime($collectDate2));
                    $estimatedDate1 = date('d/m/Y', strtotime($estimatedDate1));
                    $estimatedDate2 = date('d/m/Y', strtotime($estimatedDate2));

                    $customer_email = $order->order->customer->email;
                    $customer_name = $order->order->customer->name;

                    if ($orderItem->order->channel->slug == 'ejogga') {
                        $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();

                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);
                        $backup = Mail::getSwiftMailer();
                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);
                        Mail::setSwiftMailer($mailtrap);

                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });

                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");

                        // reset to default configuration
                        Mail::setSwiftMailer($backup);
                    }

                    if ($orderItem->order->channel->slug == 'boomtekk') {

                        $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();

                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);

                        $backup = Mail::getSwiftMailer();
                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);
                        Mail::setSwiftMailer($mailtrap);
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });
                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");

                        // reset to default configuration
                        Mail::setSwiftMailer($backup);
                    }

                    if ($orderItem->order->channel->slug == 'amazon') {

                        $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();
                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);

                        $backup = Mail::getSwiftMailer();
                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);

                        Mail::setSwiftMailer($mailtrap);
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });
                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");

                        // reset to default configuration
                        Mail::setSwiftMailer($backup);
                    }

                    if ($orderItem->order->channel->slug == 'groupon') {

                        $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();

                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);
                        $backup = Mail::getSwiftMailer();
                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);
                        Mail::setSwiftMailer($mailtrap);
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });

                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");

                        // reset to default configuration
                        Mail::setSwiftMailer($backup);
                    }

                    if ($orderItem->order->channel->slug == 'xstreamgym') {

                        $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();
                        $backup = Mail::getSwiftMailer();

                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);

                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);

                        Mail::setSwiftMailer($mailtrap);
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });

                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");
                        // reset to default configuration
                        Mail::setSwiftMailer($backup);

                    }

                    if ($orderItem->order->channel->slug == 'gogroopie') {

                        $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();

                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);

                        $backup = Mail::getSwiftMailer();
                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);

                        Mail::setSwiftMailer($mailtrap);
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });
                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");

                        // reset to default configuration
                        Mail::setSwiftMailer($backup);
                    }

                    if ($orderItem->order->channel->slug == 'wowcher') {

                        $booktekk = Deal::where('deal_number', $orderItem->order->deal_id)->first();
                        if ($booktekk) {
                            $channel = SalesChannel::where('slug', 'boomtekk')->first();
                            $email = EmailSetting::where('channel_id', $channel->id)->where('status', true)->first();

                        } else {
                            $email = EmailSetting::where('channel_id', $orderItem->order->channel_id)->where('company_id', Auth::user()->company_id)->where('status', true)->first();
                        }

                        Session::put('collectDate1', $collectDate1);
                        Session::put('collectDate2', $collectDate2);
                        Session::put('estimatedDate1', $estimatedDate1);
                        Session::put('estimatedDate2', $estimatedDate2);
                        Session::put('product', $orderItem->product->name);
                        Session::put('tracking_number', $orderItem->tracking_number);
                        Session::put('delivery_email', $email->username);
                        Session::put('channel', $order->order->channel->name);
                        Session::put('customer', $customer_name);

                        $backup = Mail::getSwiftMailer();

                        // set mailing configuration
                        $transport = new Swift_SmtpTransport($email->smtp_outgoing_server, $email->smtp_outgoing_port, $email->smtp_outgoing_encryption);
                        $transport->setUsername($email->username);
                        $transport->setPassword($email->password);
                        $mailtrap = new Swift_Mailer($transport);

                        Mail::setSwiftMailer($mailtrap);
                        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                        $beautymail->send('emails.test', [], function ($message) use ($email, $customer_email, $orderItem, $customer_name) {
                            $message
                                ->from($email->username)
                                ->to($customer_email, $customer_name)
                                ->subject($orderItem->product->name . " - " . $orderItem->tracking_number);
                        });

                        $emailTemplate = $beautymail->view('emails.test')->render();
                        $stream = imap_open("{mail.livemail.co.uk/imap/ssl/novalidate-cert}", $email->username, $email->password);
                        $boundary = "------=" . md5(uniqid(rand()));
                        $msg = "From: $email->username\r\n"
                            . "To: $customer_email \r\n"
                            . "Subject: This is the subject\r\n"
                            . "MIME-Version: 1.0\r\n"
                            . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
                            . "\r\n\r\n"
                            . "--$boundary\r\n"
                            . "Content-Type: text/html;\r\n\tcharset=\"ISO-8859-1\"\r\n"
                            . "Content-Transfer-Encoding: 8bit \r\n"
                            . "\r\n\r\n"
                            . "$emailTemplate\r\n"
                            . "\r\n\r\n";
                        imap_append($stream, "{mail.livemail.co.uk/imap/ssl/novalidate-cert}Sent", $msg, "\\Seen");

                        // reset to default configuration
                        Mail::setSwiftMailer($backup);
                    }
                }
            }
        }

        Import::where('id', $import->id)->update(['number_of_rows' => count($rows)]);

        return redirect()->route('imports.index');
    }

    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @return int
     */
    public function chunkSize(): int
    {
        return 15000;
    }


//    public function logable($import, $saleChannel)
//    {
//        $request = [
//            'company_id'=> Auth::user()->company_id,
//            'user_id'=> Auth::user()->id,
//            'module' => $import,
//            'activity' => 'Import',
//            'description' => Auth::user()->name.' '. $saleChannel->name. ' ' .'import CSV'
//        ];
//
//        $this->log($request);
//    }


    /**
     * @return array|void
     */
    public function checkWeekend()
    {
        $weekMap = [
            0 => 'SU',
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];
        $dayOfTheWeek = Carbon::now()->dayOfWeek;
        $weekday = $weekMap[$dayOfTheWeek];
        if ($weekday == 'TH') {
            $t = Carbon::now()->addDay();
            $date = "0" . $t->day . "-0" . $t->month;
            $receivedDate = $date;

            $holiday = array(
                '08-09' => 'New Year Day',
                '18-02' => 'Martin Luther King Day',
                '22-02' => 'Washington\'s Birthday',
                '05-07' => 'Independence Day',
                '11-11' => 'Veterans Day',
                '24-12' => 'Christmas Eve',
                '25-12' => 'Christmas Day',
                '31-12' => 'New Year Eve'
            );

            foreach ($holiday as $key => $value) {
                if ($receivedDate == $key) {
                    return ['collect_date1' => Carbon::now(),
                        'collect_date2' => Carbon::now()->addDays(2),
                        'estimated_date1' => Carbon::now()->addDays(6),
                        'estimated_date2' => Carbon::now()->addDays(7)
                    ];
                } else {
                    return ['collect_date1' => Carbon::now(),
                        'collect_date2' => Carbon::now()->addDays(1),
                        'estimated_date1' => Carbon::now()->addDays(5),
                        'estimated_date2' => Carbon::now()->addDays(6)
                    ];
                }
            }

        } else if ($weekday == 'FR') {

            $t = Carbon::now()->addDay();
            $date = "0" . $t->day . "-0" . $t->month;
            $receivedDate = $date;

            $holiday = array(
                '08-09' => 'New Year Day',
                '18-02' => 'Martin Luther King Day',
                '22-02' => 'Washington\'s Birthday',
                '05-07' => 'Independence Day',
                '11-11' => 'Veterans Day',
                '24-12' => 'Christmas Eve',
                '25-12' => 'Christmas Day',
                '31-12' => 'New Year Eve'
            );

            foreach ($holiday as $key => $value) {
                if ($receivedDate == $key) {
                    return ['collect_date1' => Carbon::now(),
                        'collect_date2' => Carbon::now()->addDays(2),
                        'estimated_date1' => Carbon::now()->addDays(5),
                        'estimated_date2' => Carbon::now()->addDays(6)
                    ];
                } else {
                    return ['collect_date1' => Carbon::now(),
                        'collect_date2' => Carbon::now()->addDays(1),
                        'estimated_date1' => Carbon::now()->addDays(4),
                        'estimated_date2' => Carbon::now()->addDays(5)
                    ];
                }
            }

        } else {

            $t = Carbon::now()->addDay();
            $date = "0" . $t->day . "-0" . $t->month;
            $receivedDate = $date;

            $holiday = array(
                '08-09' => 'New Year Day',
                '18-02' => 'Martin Luther King Day',
                '22-02' => 'Washington\'s Birthday',
                '05-07' => 'Independence Day',
                '11-11' => 'Veterans Day',
                '24-12' => 'Christmas Eve',
                '25-12' => 'Christmas Day',
                '31-12' => 'New Year Eve'
            );

            foreach ($holiday as $key => $value) {
                if ($receivedDate == $key) {
                    return ['collect_date1' => Carbon::now(),
                        'collect_date2' => Carbon::now()->addDays(2),
                        'estimated_date1' => Carbon::now()->addDays(4),
                        'estimated_date2' => Carbon::now()->addDays(5)
                    ];
                } else {
                    return ['collect_date1' => Carbon::now(),
                        'collect_date2' => Carbon::now()->addDays(1),
                        'estimated_date1' => Carbon::now()->addDays(2),
                        'estimated_date2' => Carbon::now()->addDays(3)
                    ];
                }
            }

        }
    }
}

