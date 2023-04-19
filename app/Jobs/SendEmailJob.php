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
        $mailData = new MailData([
            'title' => 'My Email Title',
            'uuid' => $uuid,
            'p_id' => $request->pid,
            'owner_id' => $owner_id,
            'sender_id' => $sender_id,
            'template_id' => $request->template_id,
            'subject' => $request->subject,
            'to' => $request->to,
            'cc' => $request->cc,
            'bcc' => $request->bcc,
            'body' => $request->body,
            'sender_name' => $request->sender_name,
            'mail_status' => Mail::PENDING,
        ]);
        
        $mail = new Mail([
            'uuid' => $uuid,
            'owner_id' => $owner_id,
            'sender_id' => $uuid,
            'template_id' => $request->template_id,
            'subject' => $request->subject,
            'to' => $request->to,
            'cc' => $request->cc,
            'bcc' => $request->bcc,
            'body' => $request->body,
            'sender_name' => $request->sender_name,
            'mail_status' => Mail::PENDING,
        ]);
        $mail->save();
        
    }
}
