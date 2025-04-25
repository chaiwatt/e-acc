<?php

namespace App\Mail\Tracking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuditorsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    { 
        $this->title = $item['title']; 
        $this->name = $item['name'];
        $this->certi = $item['certi']; 
        $this->auditors = $item['auditors'];
        $this->export = $item['export'];
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

        $mail =  $this->from( config('mail.from.address'), (!empty($this->email)  ? $this->email : config('mail.from.name')) );

        if(!empty($this->email_cc)){
           $mail =      $mail->cc($this->email_cc);
        }
 
           $mail =     $mail->subject('การแต่งตั้งคณะผู้ตรวจประเมิน')
                       ->view('mail.Tracking.auditors')
                       ->with([
                        'title' => $this->title,
                        'certi' => $this->certi,
                        'auditors' => $this->auditors,
                        'export' => $this->export,
                        'authorities' => $this->authorities,
                        'url' => $this->url
                       ]);
         return $mail;
       
    }
}
