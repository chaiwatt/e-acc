<?php

namespace App\Mail\CB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CBPayInTwoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->certi_cb = $item['certi_cb'];
        $this->attach = $item['attach'];
        $this->PayIn = $item['PayIn'];
    
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
         $location =  public_path(). '/uploads/files/applicants/check_files_cb/';
         return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                     ->cc($this->email_cc)
                     ->subject('แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง')
                     ->view('mail/CB.pay_in_two')
                     ->with([
                              'certi_cb' => $this->certi_cb,
                              'pay_in' => $this->PayIn,
                              'url' => $this->url
                            ])
                     ->attach($location.$this->attach);
    }
}
