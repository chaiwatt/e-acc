<?php

namespace App\Mail\Tracking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InspectiontMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->certi = $item['certi']; 
        $this->inspection = $item['inspection'];
        $this->export = $item['export'];

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
 
           $mail =     $mail->subject('ยืนยันขอบข่ายการรับรอง')
                            ->view('mail.Tracking.inspection')
                            ->with(['certi' => $this->certi,
                                    'inspection' => $this->inspection,
                                    'export' => $this->export,
                                    'url' => $this->url
                                    ]);
         return $mail;
                
    }
}
