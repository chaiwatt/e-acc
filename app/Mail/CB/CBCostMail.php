<?php

namespace App\Mail\CB;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CBCostMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    { 
        $this->certi_cb = $item['certi_cb'];
        $this->check_status = $item['check_status']; 
        $this->certi_cost = $item['certi_cost'];
        $this->status_scope = $item['status_scope'];
        $this->attachs_scope = $item['attachs_scope'];
        $this->attachs = $item['attachs'];
        $this->title = $item['title'];

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
                        ->subject('การประมาณการค่าใช้จ่าย')
                        ->view('mail/CB.cost')
                        ->with(['certi_cb' => $this->certi_cb,
                                'title' => $this->title,
                                'check_status' => $this->check_status,
                                'certi_cost' => $this->certi_cost,
                                'status_scope' => $this->status_scope,
                                'attachs' => $this->attachs,
                                'attachs_scope' => $this->attachs_scope,
                                'url' => $this->url
                        ]);
    }
}
