<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mails:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mails = DB::table('mails')->where('status', 'pending')->take(50)->get();

        foreach ($mails as $email) {
            Mail::to($mailData['to'])->cc($mailData['cc'])->bcc($mailData['bcc'])->send(new SendMail($mailData));
            DB::table('mails')->where('id', $email->id)->update(['status' => 'sent']);
        }
    }
}
