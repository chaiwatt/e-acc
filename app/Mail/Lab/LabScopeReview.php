<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LabScopeReview extends Mailable
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
        $this->url = $item['url'];
    }

    public function build()
    {
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
        ->subject('ลงนามยืนยันขอบข่าย')
        ->view('mail.lab.lab_scope_review')
        ->with([
                'certi_lab' => $this->certi_lab,
                'url' => $this->url,
               ]);
    }
}
