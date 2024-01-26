<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// import spendingcontroller
use App\Http\Controllers\SpendingController;
class EmailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(SpendingController $spendingController)
    {
        parent::__construct();
        $this->controller = $spendingController;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->controller->sendEmail();
        $this->info('Report Has Been Sent Successfully');

    }
}
