<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransferCertificate extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($item)
    {
        $this->url = $item['url'];
        $this->certilab = $item['certilab'];
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
                    ->subject('นำส่งใบรับรองระบบงาน (โอนใบรับรอง)')
                    ->view('mail.lab.send_transfer_certificate')
                    ->with([
                            'certilab' => $this->certilab,
                            'url' => $this->url
                            ]);
    }
}
