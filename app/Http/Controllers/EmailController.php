<?php

namespace App\Http\Controllers;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\Mail as Email;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $uuid = mt_rand(10000000, 99999999);
        $owner_id = Auth::user()->id;
        $sender_id = Auth::user()->id;

        $mailData = [
            'title' => 'xspl',
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
            'sender_name' => $request->sender_name

        ];
            Mail::to($mailData['to'])->cc($mailData['cc'])->bcc($mailData['bcc'])->send(new SendMail($mailData));
            
        
            $email = new Email();
            $email->uuid = $uuid;
            $email->owner_id = $owner_id;
            $email->sender_id = $uuid;
            $email->template_id = $request->template_id;
            $email->subject = $request->subject;
            $email->to = $request->to;
            $email->cc = $request->cc;
            $email->bcc = $request->bcc;
            $email->body = $request->body;
            $email->sender_name = $request->sender_name;
            $email->save();

        return response()->json([
            'message' => 'Email has been sent to  successfully!'
        ], 200);
    }

}
