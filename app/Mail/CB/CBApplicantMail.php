<?php

namespace App\Mail\CB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CBApplicantMail extends Mailable
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
        $this->app_no = $item['app_no'];
        $this->name = $item['name'];
        $this->request = $item['request'];      
    
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
                    ->subject('คำขอรับบริการยืนยันความสามารถหน่วยรับรอง')
                    ->view('mail.CB.applicant')
                    ->with([
                                'title' => $this->title,
                                'app_no' => $this->app_no,
                                'name' => $this->name,
                                'request' => $this->request,
                                'url' => $this->url
                            ]);
    }
}
