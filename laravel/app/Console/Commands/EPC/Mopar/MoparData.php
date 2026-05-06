<?php

namespace App\Console\Commands\EPC\Mopar;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MoparData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mopar:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and Import Mopar Data';

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
        $moparftp = Storage::disk('moparftp');
        $sds3 = Storage::disk('s3sdteam');

        $date = date('m_d_Y');
        $mopars3path = 'MoparAccessories/mopar_' . $date . '/';

        try
        {
            // Mopar Accessories Data Folder Files
            $datafiles = $moparftp->files('Accessories/Data');

            foreach($datafiles as $file)
            {
                $fileToSave = $moparftp->download($file);
                $sds3->put($mopars3path . $file, $fileToSave);
            }

            // Mopar Accessories Image Folder Files
            $imagefiles = $moparftp->files('Accessories/Images');

            foreach($imagefiles as $file)
            {
                $fileToSave = $moparftp->download($file);
                $sds3->put($mopars3path . $file, $fileToSave);
            }

            // Mopar Accessories ISheet Folder Files
            $isheetfiles = $moparftp->files('Accessories/ISheets');

            foreach($isheetfiles as $file)
            {
                $fileToSave = $moparftp->download($file);
                $sds3->put($mopars3path . $file, $fileToSave);
            }

            // Mopar Accessories Logo Images Folder Files
            $logofiles = $moparftp->files('Accessories/Logo Images');

            foreach($logofiles as $file)
            {
                $fileToSave = $moparftp->download($file);
                $sds3->put($mopars3path . $file, $fileToSave);
            }

            // Mopar Accessories Vehicle Images Folder Files
            $vehiclefiles = $moparftp->files('Accessories/Vehicle Images');

            foreach($vehiclefiles as $file)
            {
                $fileToSave = $moparftp->download($file);
                $sds3->put($mopars3path . $file, $fileToSave);
            }

            return Command::SUCCESS;
        } catch(Exception $e) {
            return Command::FAILURE;
        }
    }
}
