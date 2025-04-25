<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertifyCostCertificate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->find_certi = $item['find_certi'];
        $this->file = $item['file'];
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
        $location =  public_path(). '/uploads/files/applicants/check_files/';
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                    ->cc($this->email_cc)
                    ->subject('แจ้งหลักฐานการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง')
                    ->view('mail.lab.pay_in_two')
                    ->with([        
                            'find_certi' => $this->find_certi,
                            'PayIn' => $this->PayIn,
                            'url' => $this->url
                           ])
                    ->attach($location.$this->file) ;
    }
}
