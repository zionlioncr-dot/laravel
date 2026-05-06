<?php

namespace App\Console\Commands\EPC\SmartDealer;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class SmartDealerData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartdealer:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and Import SmartDealer Data';

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
        $sdftp = Storage::disk('smartdealerftp');
        $sds3 = Storage::disk('s3sdteam');

        $date = date('m_d_Y');
        $sds3path = 'Keith/keith_' . $date . '/';

        try {
            // Mopar Accessories Data Folder Files
            $datafiles = $sdftp->files('/');

            foreach ($datafiles as $file) {
                $fileToSave = $sdftp->download($file);
                $sds3->put($sds3path . $file, $fileToSave);
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            return Command::FAILURE;
        }
    }
}
