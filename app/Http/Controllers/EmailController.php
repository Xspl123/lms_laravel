<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Attachment;
use Swift_Mailer;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Get email data from request
        $to = $request->input('to');
        $cc = $request->input('cc');
        $bcc = $request->input('bcc');
        $subject = $request->input('subject');
        $body = $request->input('body');
        $attachment = $request->file('attachment');
    
        // Create SMTP Transport object
        $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername('your-email@gmail.com')
            ->setPassword('your-email-password');
    
        // Create Swift Mailer instance
        $mailer = new Swift_Mailer($transport);
    
        // Create Swift Message instance
        $message = new Swift_Message($subject);
    
        // Set From and To addresses
        $message->setFrom(['your-email@gmail.com' => 'Your Name'])
            ->setTo([$to])
            ->setCc([$cc])
            ->setBcc([$bcc]);
    
        // Set message body
        $message->setBody($body);
    
        // Add attachment, if any
        if ($attachment) {
            $message->attach(Swift_Attachment::fromPath($attachment->path()));
        }
    
        // Send the email
        $mailer->send($message);
    
        return response()->json(['message' => 'Email sent successfully']);
    }
    
}
