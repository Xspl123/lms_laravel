<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\Mail as Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailData;

   
    public function __construct(MailData $mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->email;
    
    try {
        Mail::to($email->to)
            ->cc($email->cc)
            ->bcc($email->bcc)
            ->send(new SendMail($email->toArray()));

        // update the status to 'success' after sending the email
        $email->mail_status = 'success';
    } catch (\Exception $e) {
        // update the status to 'failed' if an exception occurred
        $email->mail_status = 'failed';
    }
    
    $email->save();
        
    }
}
