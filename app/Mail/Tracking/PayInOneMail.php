<?php

namespace App\Mail\Tracking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayInOneMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    { 
        $this->pay_in = $item['pay_in'];
        $this->certi = $item['certi'];
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
            $mail =  $this->from( config('mail.from.address'), (!empty($this->email)  ? $this->email : config('mail.from.name')) );
            if(!empty($this->email_cc)){
              $mail =      $mail->cc($this->email_cc);
            }
            if($this->files != ''){ // ส่ง mail พร้อมไฟล์ pdf
                $location =  public_path(). '/uploads/'.$this->files; 
                $mail =      $mail->attach($location);
            }
            $mail =     $mail->subject('แจ้งหลักฐานการชำระค่าบริการในการตรวจประเมิน')
                                ->view('mail.Tracking.pay_in_one')
                                ->with(['certi' => $this->certi,
                                        'pay_in' => $this->pay_in,
                                        'url' => $this->url
                                ]);
         return $mail;
 

 
    }
}
