<?php

namespace App\Mail\IB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class IBPayInOneMail extends Mailable
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
        $this->files = $item['files'];
        $this->pay_in = $item['pay_in'];
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
                     ->view('mail/IB.pay_in1')
                     ->subject('แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน')
                     ->with(['certi_ib' => $this->certi_ib, 
                            'files' => $this->files,
                            'pay_in' => $this->pay_in,
                            'url' => $this->url
                            ]);
    }
}
