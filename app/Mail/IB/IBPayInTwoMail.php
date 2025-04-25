<?php

namespace App\Mail\IB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IBPayInTwoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->certi_ib = $item['certi_ib'];
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
        $location =  public_path(). '/uploads/files/applicants/check_files_ib/';
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                      ->cc($this->email_cc)
                      ->subject('แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง')
                      ->view('mail/IB.pay_in_two')
                      ->with([
                             'certi_ib' => $this->certi_ib,
                             'pay_in' => $this->PayIn,
                             'url' => $this->url
                             ])
                      ->attach($location.$this->attach);
    }
}
