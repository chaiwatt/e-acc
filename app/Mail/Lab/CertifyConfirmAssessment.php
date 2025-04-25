<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertifyConfirmAssessment extends Mailable
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
 
        $this->status_scope = $item['status_scope'];
        $this->remark = $item['remark'];
        $this->evidence = $item['evidence'];

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
                    ->subject('ยืนยันขอบข่ายการรับรองหน่วยตรวจ')
                    ->view('mail.lab.certify_confirm_assessment')
                    ->with([
                            'certi_lab' => $this->certi_lab,
                            'status_scope' => $this->status_scope,
                            'remark' => $this->remark,
                            'evidence' => $this->evidence,
                            'url' => $this->url
                        ]);
    }
    
}
