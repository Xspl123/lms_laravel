<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail as MailFacade;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->mail;

        
            MailFacade::to($email->to)
                ->cc($email->cc)
                ->bcc($email->bcc)
                ->send(new SendMail($email->toArray()));

            // update the status to 'success' after sending the email
            $email->mail_status = 'success';
       
        $email->save();
    }
}
