<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RequestEditScope extends Mailable
{
    use Queueable, SerializesModels;

    // public $certi_lab;
    // public $url;
    // public $email;
    // public $email_cc;
    // public $email_reply;

    // public function __construct($item)
    // {
    //     // dd($item);
    //     $this->certi_lab = $item['certi_lab'];
    //     $this->url = $item['url'];
    //     $this->email = $item['email'];
    //     $this->email_cc = $item['email_cc'];
    //     $this->email_reply = $item['email_reply'];
    // }

    // /**
    //  * Build the message.
    //  *
    //  * @return $this
    //  */
    // public function build()
    // {

    //     return $this->from( config('mail.from.address'), config('mail.from.name') )
    //     ->cc($this->email_cc)
    //     ->subject('ขอให้แก้ไขขอบข่าย')
    //     ->view('mail.lab.mail_request_edit_lab_scope')
    //     ->with([
    //             'certi_lab' => $this->certi_lab,
    //             'url' => $this->url,
    //          ]);
    // }

    public function __construct($item)
    {
    
        $this->certi_lab = $item['certi_lab'];

        $this->url = $item['url'];
        $this->email = $item['email'];
        $this->email_cc = $item['email_cc'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                        ->cc($this->email_cc)
                        ->subject('แจ้งการแก้ไขขอบข่าย')
                        ->view('mail.lab.mail_request_edit_lab_scope')
                        ->with([
                                'certi_lab' => $this->certi_lab,   
                                'url' => $this->url,
                               ]);
    }
}
