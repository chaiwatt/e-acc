<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertifyAuditor extends Mailable
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
                    ->view('mail/lab.certify_auditor')
                    ->with(['app_no' => $this->app_no,
                            'title' => $this->title,
                            'name' => $this->name,
                            'url' => $this->url
                      ]);
    }
}
