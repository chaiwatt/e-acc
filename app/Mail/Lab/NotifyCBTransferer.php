<?php

namespace App\Mail\Lab;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyCBTransferer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->certificateExport = $item['certificateExport'];
        $this->transferee = $item['transferee'];
        $this->transferer = $item['transferer'];
        $this->certiCb = $item['certiCb'];
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from( config('mail.from.address'),config('mail.from.name') ) // $this->email
        ->subject('มีการสร้างคำขอเพื่อขอโอนใบรับรองของท่าน')
        ->view('mail.cb.mail_notify_transferer')
        ->with([
                'certificateExport' => $this->certificateExport,
                'transferee' => $this->transferee,
                'transferer' => $this->transferer,
                'certiCb' => $this->certiCb,
               ]);
    }
}
