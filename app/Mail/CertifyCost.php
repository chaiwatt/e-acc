<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CertifyCost extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->app_no = $item['app_no'];
        $this->email = $item['email'];
        $this->check_status = $item['check_status']; 
        $this->remark = $item['remark'];
        $this->status_scope = $item['status_scope'];
        $this->remark_scope = $item['remark_scope'];
        $this->attachs = $item['attachs'];
        $this->attachs_scope = $item['attachs_scope'];
        $this->url = $item['url'];
        $this->title = $item['title'];
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
                    ->view('mail.certify_cost')
                    ->with(['app_no' => $this->app_no,
                            'title' => $this->title,
                            'check_status' => $this->check_status,
                            'remark' => $this->remark,
                            'status_scope' => $this->status_scope,
                            'remark_scope' => $this->remark_scope,
                            'attachs' => $this->attachs,
                            'attachs_scope' => $this->attachs_scope,
                            'url' => $this->url
                      ]);
    }
}
