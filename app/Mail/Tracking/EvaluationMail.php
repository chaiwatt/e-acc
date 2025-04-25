<?php

namespace App\Mail\Tracking;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EvaluationMail extends Mailable
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
        $this->evaluation = $item['evaluation'];
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
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                   ->cc($this->email_cc)
                   ->subject('ยืนยันผลการตรวจประเมิน')
                   ->view('mail.Tracking.evaluation')
                   ->with(['certi' => $this->certi,
                           'evaluation' => $this->evaluation,
                           'export' => $this->export,
                           'url' => $this->url
                          ]);
    }
}
