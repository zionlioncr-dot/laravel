<?php

namespace App\Console\Commands;
use App\Models\MoparVehicleDefinition;
use App\Models\MoparPartApplication;
use App\Models\MoparPartDescription;
use App\Models\MoparPartNames;
use App\Models\MoparPartISheet;
use App\Models\MakeMopar;
use App\Models\ModelMopar;
use App\Models\CategoryMopar;
use App\Models\SubCategoryMopar;
use App\Models\ModelCategoryMopar;
use App\Models\ProductMopar;
use App\Models\CategoryProductMopar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class loadMopar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mopar:dataload';

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

     public function slugify_text($text, string $divider = '-')
{
  // replace non letter or digits by divider
  $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, $divider);

  // remove duplicate divider
  $text = preg_replace('~-+~', $divider, $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {



/*
	    $file = 'ExtractVehicleDefinition.txt';
    $fileContents = file($file);
        $i = 0;
$lang = 'ford_us_en';



if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, "|")) !== FALSE) {
        


        // $data = str_getcsv($line);
        //$count = count($data);
         MoparVehicleDefinition::create([
            'Market' => $data[0],
            'Language' => $data[1],
            'ApplicationCode' => $data[2],
            'ApplicationName' => utf8_encode($data[3]),
            'Year' => $data[4],
            'DivisionName' => $data[5],
            'DivisionImage' => $data[6],
            'FamilyName' => $data[7],
            'Model' => $data[8],
 	    'Line' => $data[9],
            'Series' => $data[10],
            'Body' => $data[11],
            'VehicleImage' => $data[12],

         ]);
        }
    

}


$file = 'ExtractPartApplication.txt';
    $fileContents = file($file);
        $i = 0;
$lang = 'ford_us_en';



if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, "|")) !== FALSE) {
 MoparPartApplication::create([
            'Market' => $data[0],
            'Language' => $data[1],
            'PartNumber' => $data[2],
            'ModelYear' => utf8_encode($data[3]),
            'ApplicationCode' => $data[4],
            'Application' => utf8_encode($data[5]),
            'ApplicationRemark' => utf8_encode($data[6]),
            'VehicleCode' => $data[7],
            'VehicleLine' => utf8_encode($data[8]),
            'Image' => $data[9],
            //'ImageCaption' => $data[10],
            

         ]);
        }
}
 
	    $file = 'ExtractPartDescription.txt';
    $fileContents = file($file);
        $i = 0;
$lang = 'ford_us_en';



if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, "|")) !== FALSE) {
 MoparPartDescription::create([
            'Market' => $data[0],
            'Language' => $data[1],
            'PartNumber' => $data[2],
            'Category' => utf8_encode($data[3]),
            'Subcategory' => utf8_encode($data[4]),
            'Group' => utf8_encode($data[5]),
            'GroupDescription' => utf8_encode($data[6]),
            'GroupDisclosure' => utf8_encode($data[7]),
            'PartDescription' => utf8_encode($data[8]),
	    'PartDisclosure' => utf8_encode($data[10]),
	    'PriceDate' => $data[11],
	    'MSRP' => $data[12],
	    'DealerNetPricing' => $data[13],
	    'InstallTime' => $data[14],
	    'ISheet' => utf8_encode($data[15]),
	    //'MarketingName' => utf8_encode($data[16]),
	    //'NounName' => utf8_encode($data[17]),
	    //'NounDescription' => utf8_encode($data[18]),
            //'ImageCaption' => $data[10],


         ]);
        }
}
 

	    $accesories = MoparVehicleDefinition::distinct()->get(["DivisionName"]);

        foreach($accesories as $accesory){
                echo "Make:".$accesory->DivisionName;
                $makes = explode(",",$accesory->DivisionName);

                foreach($makes as $make){
                        echo "make 2:".$make;
                        if($make != ""){
                                $makeMopar = MakeMopar::where('MakeName',$make)->first();
                                //print_r($makeFord);
                                if(!$makeMopar){

                                        MakeMopar::create(['MakeName' => $make, 'slug' => $this->slugify_text($make,'-') ]);
                                //      $slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
                                }
                        }else{
                                $make = "All";
                                $makeMopar = MakeMopar::where('MakeName',$make)->first();
                                //print_r($makeFord);
                                if(!$makeMopar){

                                        MakeMopar::create(['MakeName' => $make, 'slug' => $this->slugify_text($make) ]);                                 //      $slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
                                }
                        }
                }
	}

 

$accesories = MoparVehicleDefinition::distinct()->select(["DivisionName","ApplicationName","Year","Model","Line","Series","Body"])->get();

        foreach($accesories as $accesory){
		$years = explode(",",$accesory->Year);
	print_r($years);
                $makes = explode(",",$accesory->DivisionName);
		$models = explode(",",$accesory->ApplicationName . "-" . $accesory->Model . "-" . $accesory->Line . "-" . $accesory->Series . "-" . $accesory->Body);
                foreach($makes as $make){
			//echo "make 2:".$make;
			if($make == "")
				$make = "All";

			if($make != ""){

                                $makeMopar = MakeMopar::where('MakeName',$make)->first();
				print_r($makeMopar);


                                if($makeMopar){


					print_r($models);
					foreach($models as $model){
						if($model == '')
							$model = "All";

						if($accesory->Year == ''){
							$year = 0;
						$modelMopar = ModelMopar::where('Year',$year)->where('ModelName',$model)->where('MakeID',$makeMopar->getKey())->first();


						if(!$modelMopar){
							$maxModel = intval(ModelMopar::max('ModelID'));
							$max = 0;
							if($maxModel == 0)
								$max = 1;
							else
								$max = $maxModel + 1;

							ModelMopar::create(['MakeID' => $makeMopar->getKey(),
								'ModelID' => $max,
                                                        'ModelName' => $model,
                                                        'Year' => $year,
                                                        'slug' => $this->slugify_text($model),
                                                        'photo' => 'test.jpg' ]);
                                                //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
						}
						}
						foreach($years as $year){
						$modelMopar = ModelMopar::where('Year',$year)->where('ModelName',$model)->where('MakeID',$makeMopar->getKey())->where('Year',$year)->first();


						if(!$modelMopar){
							$maxModel = intval(ModelMopar::max('ModelID'));
							$max = 0;
							if($maxModel == 0)
								$max = 1;
							else
								$max = $maxModel + 1;


							ModelMopar::create(['MakeID' => $makeMopar->getKey(),
								'ModelID' => $max,
							'ModelName' => $model,
							'Year' => $year,
							'slug' => $this->slugify_text($model),
							'photo' => 'test.jpg' ]);
                                        	//$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
						}
						}
					}
				}
                        }
                }
        }

 

$i = 0;	
	foreach(MoparPartApplication::cursor() as $accesory){
		echo $i." ";
		$i++;

//$categories = explode("/",$accesory->category);

		$product = ProductMopar::where("part_no",$accesory->PartNumber)->first();

		if(!$product){
			$moparProduct = MoparPartDescription::where("PartNumber",$accesory->PartNumber)->first();
			ProductMopar::create(['name' => substr($moparProduct->PartDescription,0,1000),
				'part_no' => $moparProduct->PartNumber,
				'part_no_original' => $moparProduct->PartNumber,
				'image' => $moparProduct->ISheet,
				'description' => $moparProduct->Group.
				'<br><br>'.$moparProduct->GroupDescription,
				'vehicle_disclaimer' => '', 
				'brand' => 'Mopar',
				'color' => '',
				'price' => $moparProduct->PriceDate,
				'cost' => $moparProduct->MSRP,
				'weight' => '',
				'height' => '', 
				'width' => '',
				'length' => '',
				'install_time' => '',
				'slug' => $this->slugify_text(substr($moparProduct->PartDescription,0,1000))]);
		}
		$product1 = ProductMopar::where("part_no",$accesory->PartNumber)->first();
		$product_id = $product1->getKey();

		$product = MoparPartDescription::where("PartNumber",$accesory->PartNumber)->first();

		if(!$product)
			continue;
		
		$category = $product->Category;	
		if($category == "")
			$category = "All";
		
		$subCategory = $product->Subcategory;
		if($subCategory == ""){
                	$subCategory = "All";
		}
		$categoryMopar = CategoryMopar::where('CategoryName',$category)->first();
		if(!$categoryMopar)
		{

                     CategoryMopar::create(['CategoryName' => $category, 'slug' => $this->slugify_text($category)]);
                                        //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
		}

		


                $categoryMopar2 = CategoryMopar::where('CategoryName',$category)->first();
		if(!empty($categoryMopar2)){

		$subCategoryMopar = SubCategoryMopar::where('SubCategoryName',$subCategory)->first();
			if(is_null($subCategoryMopar)){
				

			SubCategoryMopar::create(['SubCategoryName' => $subCategory, 'slug' => $this->slugify_text($subCategory),'CategoryID'=> $categoryMopar2->getKey() ]);
                                        //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
			}

		}

	    $categoryMopar1 = CategoryMopar::where('CategoryName',$category)->first();
            $subCategoryMopar1 = SubCategoryMopar::where('SubCategoryName',$subCategory)->first();
	    $moparVehicleDefinition = MoparVehicleDefinition::where('Market',$accesory->Market)->where('Language',$accesory->Language)->where('ApplicationCode',$accesory->ApplicationCode)->where('ApplicationName',$accesory->Application)->where('Year',$accesory->ModelYear)->get();

            //$makes = explode(",",$accesory->make);


            if($accesory->ModelYear == ''){
                $years = array(0);
            }
            foreach($moparVehicleDefinition as $vehicle){
                //echo "make 2:".$make;
		$make = $vehicle->DivisionName;
		$models = explode(",",$vehicle->ApplicationName . "-" . $vehicle->Model . "-" . $vehicle->Line . "-" . $vehicle->Series . "-" . $vehicle->Body);
            	$years = explode(",",$vehicle->Year);
                if($make == "")
                    $make = "All";
                $makeMopar = MakeMopar::where('MakeName',$make)->first();

                foreach($models as $model){
                    if($model == '')
                        $model = "All";
                    foreach($years as $year){
                    $modelMopar = ModelMopar::where('ModelName',$model)->where('MakeID',$makeMopar->getKey())->where('Year',$year)->first();

		    if($modelMopar){

			    $modelID = $modelMopar->getKey();

			    if($categoryMopar1 && $subCategoryMopar1){

                        $modelCategoryMopar1 = ModelCategoryMopar::where('BaseVehicleID',$modelID)->where('CategoryID',$categoryMopar1->getKey())->where('SubCategoryID',$subCategoryMopar1->getKey())->first();

                        if(!$modelCategoryMopar1){

				ModelCategoryMopar::create(['CategoryID' => $categoryMopar1->getKey(),
							  'SubCategoryID' => $subCategoryMopar1->getKey(),
							   'BaseVehicleID'=> $modelID]);
			}

 			$modelCategoryMopar12 = ModelCategoryMopar::where('BaseVehicleID',$modelID)->where('CategoryID',$categoryMopar1->getKey())->where('SubCategoryID',$subCategoryMopar1->getKey())->first();

			$categoryProductMopar12 = CategoryProductMopar::where('ModelCategoryID', $modelCategoryMopar12->getKey())->where('ItemID', $product_id)->first();

			if(!$categoryProductMopar12){
			CategoryProductMopar::create(['ModelCategoryID' => $modelCategoryMopar12->getKey(),
				'ItemID' => $product_id]);
                        }}

                    }
                    }

		}
                }
            }
*/	
 $file = 'ExtractPartNames.csv';
    $fileContents = file($file);
        $i = 0;
$lang = 'ford_us_en';
$i = 0;


if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {

echo "Aqui".$data[0];
        // $data = str_getcsv($line);
        //$count = count($data);
         MoparPartNames::create([
            'part_number' => $data[0],
            'marketing_name' => $data[1],
            'noun_name' => $data[2],
	    'noun_description' => '',
	 ]);
       

	ProductMopar::where('part_no', $data[0])      
      		->update(['name' => $data[1],'slug' => $this->slugify_text($data[1])]);

    $i++;
	}

}
/*
 $file = 'ExtractPartISheet.txt';
    $fileContents = file($file);
        $i = 0;
$lang = 'ford_us_en';
$i = 0;


if (($handle = fopen($file, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 0, "|")) !== FALSE) {

echo "Aqui".$data[0];
        // $data = str_getcsv($line);
        //$count = count($data);
         MoparPartISheet::create([
            'part_number' => $data[2],
            'isheet' => $data[3]
         ]);


        ProductMopar::where('part_no', $data[2])
                ->update(['image' => $data[3].'.pdf']);

    $i++;
        }
}
	    
     
	    
	    $directories = ['/imagespdfsupdate/MoparAccessories/mopar_12_11_2023/Accessories/ISheets'];

	$from = Storage::disk('smartdealerftp');
        $to = Storage::disk('s3sdteam');

    foreach($directories as $directory){
        $files = Storage::disk($from)->allFiles($directory);

        foreach ($files as $file) {

            Storage::disk($to)->writeStream($file, Storage::disk($from)->readStream($file));

            // If you no longer need the originals
            //Storage::disk($from)->delete($file);
        }

     //   Storage::disk($from)->deleteDirectory($directory);
    }
return 0;
*/    
    }

}
