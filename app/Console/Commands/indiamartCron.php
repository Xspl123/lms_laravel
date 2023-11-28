<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\IndiaMartApiController;

class indiamartCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indiamart:cron';

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
        $controller = new IndiaMartApiController();
        $controller->getIndiaMartApiRsponse();
        $this->info('getIndiaMartApiRsponse command executed successfully.');
    }
}
