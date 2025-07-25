<?php

namespace App\Mail\CB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EditScopeRequest extends Mailable
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
                   ->subject('แจ้งการแก้ใขขอบข่ายเรียบร้อยแล้ว')
                   ->view('mail.CB.mail_request_edit_cb_scope')
                   ->with([
                            'certi_cb' => $this->certi_cb,
                            'url' => $this->url
                           ]);
    }
}
