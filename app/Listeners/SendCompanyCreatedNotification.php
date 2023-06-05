<?php

namespace App\Listeners;
use App\Models\User;
use App\Models\Mail;
use App\Events\CompanyCreated;
use App\Notifications\CompanyCreatedNotification;

class SendCompanyCreatedNotification
{
    public function handle(CompanyCreated $event)
    {
        $company = $event->company;
        $cid = $event->cid;

        
        // Send the notification to an appropriate recipient
        $admin = User::where('urole', 'CEO')->first();
        $admin->notify(new CompanyCreatedNotification($company));

        // Save email entry in the mail table
        Mail::create([
            'uuid' => $company->uuid,
            'company_id' => $cid,
            'email' => $admin->email,
            'subject' => 'Welcome to Our Company',
            'message' => 'Thank you for joining our company. We look forward to working with you!',
        ]);
    }
}
