<?php

namespace App\Mail\Basic;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->subject      = $item['subject'];
        $this->body         = $item['body'];
        $this->from_address = $item['from_address'];
        $this->from_name    = $item['from_name'];
        $this->attach_path  = array_key_exists('attach_path', $item) ? $item['attach_path'] : null ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $build = $this->from($this->from_address, $this->from_name)
                        ->subject($this->subject)
                        ->view('mail/Basic.mail_test')
                        ->with([
                               'subject' => $this->subject,
                               'body'    => $this->body
                            ]);

        if(!is_null($this->attach_path)){
            $build->attach($this->attach_path);
        }

        return $build;
    }

}
