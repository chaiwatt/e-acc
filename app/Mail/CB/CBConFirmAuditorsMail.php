<?php

namespace App\Mail\CB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CBConFirmAuditorsMail extends Mailable
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
        $this->auditors = $item['auditors'];
        $this->authorities = $item['authorities'];    

     
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
                     ->subject('การแต่งตั้งคณะผู้ตรวจประเมิน')
                     ->view('mail.IB.con_firm_auditors')
                     ->with([
                             'certi_cb' => $this->certi_cb,
                             'auditors' => $this->auditors,
                             'authorities' => $this->authorities,
                             'url' => $this->url
                           ]);
    }
}
