<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertifyPayIn1 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->certi_lab = $item['certi_lab']; 
        $this->assessment = $item['assessment'];
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
                      ->subject('แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน')
                      ->view('mail/lab.pay_in1')
                      ->with(['certi_lab' => $this->certi_lab,
                              'assessment' => $this->assessment,
                              'url' => $this->url
                             ]);
    }
}
