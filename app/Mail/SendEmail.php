<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;



class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to = $this->to;
        $cc = $this->cc;
        $bcc = $this->bcc;
        $subject = $this->subject;
        $body = $this->body;
        $attachment = $this->attachment;

    return $this->view('emails.send')
                ->to($to)
                ->cc($cc)
                ->bcc($bcc)
                ->subject($subject)
                ->attach($attachment);
        //return $this->view('view.name');
    }
}
