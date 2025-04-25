<?php

namespace App\Mail\Tracking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PayInTwoMail extends Mailable
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
        $this->pay_in = $item['pay_in'];
        $this->export = $item['export'];  
        $this->attach = $item['attach'];

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

        if($this->attach != ''){ // ส่ง mail พร้อมไฟล์ pdf
 
            $location =  public_path(). '/uploads/'.$this->attach; 
    
            return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                         ->cc($this->email_cc)
                         ->subject('แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง')
                         ->view('mail.Tracking.pay_in_two')
                         ->with([
                                  'certi' => $this->certi,
                                  'pay_in' => $this->pay_in,
                                  'url' => $this->url
                          ])
                         ->attach($location);
           }else{
               return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                         ->cc($this->email_cc)
                         ->subject('แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง')
                         ->view('mail.Tracking.pay_in_two')
                         ->with([
                                  'certi' => $this->certi,
                                  'pay_in' => $this->pay_in,
                                  'url' => $this->url
                                ]);
           }
 
    }
}
 