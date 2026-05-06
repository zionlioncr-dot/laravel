<?php

namespace App\Console\Commands\EPC\Ford;

use Illuminate\Console\Command;

class FordImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ford:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and Reupload Ford Accessory Images';

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
        return 0;
    }
}
