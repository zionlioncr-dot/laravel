<?php

namespace App\Console\Commands\EPC\Ford;
use App\Models\FordAccesories;
use App\Models\MakeFord;
use App\Models\ModelFord;
use App\Models\CategoryFord;
use App\Models\SubCategoryFord;
use App\Models\ModelCategoryFord;
use App\Models\ProductFord;
use App\Models\CategoryProductFord;
use Illuminate\Console\Command;
use \Cviebrock\EloquentSluggable\Services\SlugService;
class FordData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ford:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and Import Ford Data';

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
        $file = 'AccCatalog_20231009.csv';
    $fileContents = file($file);
	$i = 0;
$lang = 'ford_us_en';

/*


    foreach ($fileContents as $line) {
	if($i != 0){
		

	 $data = str_getcsv($line);
        $count = count($data);
         FordAccesories::create([
            'name' => $data[0],
            'part_no' => $data[1],
            'part_no_original' => $data[2],
            'image' => $data[15],
            'year' => $data[$count - 1],
            'make' => $data[$count - 3],
            'model' => $data[$count - 2],
            'description' => $data[4],
            'vehicle_disclaimer' => $data[$count - 16],
            'brand' => $data[$count - 47],
            'category' => $data[32],
            'color' => $data[20],
            'price' => floatval($data[5]),
            'cost' => floatval($data[9]),
            'weight' => floatval($data[10]),
            'height' => floatval($data[11]),
            'width' => floatval($data[10]),
            'lenght' => floatval($data[9]),
	    'install_time' => floatval($data[$count - 18])
	    4

	 ]);
	}
	$i++;
}
   
	$accesories = FordAccesories::distinct()->where('part_no_original',$lang)->get(["make"]);

	foreach($accesories as $accesory){
		echo "Make:".$accesory->make;
		$makes = explode(",",$accesory->make);
		
		foreach($makes as $make){
			echo "make 2:".$make;
			if($make != ""){
				$makeFord = MakeFord::where('MakeName',$make)->first();
				//print_r($makeFord);
				if(!$makeFord){
					
					MakeFord::create(['MakeName' => $make, 'slug' => $this->slugify_text($make,'-') ]);
				//	$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
				}
			}else{
				$make = "All";
				$makeFord = MakeFord::where('MakeName',$make)->first();
                                //print_r($makeFord);
                                if(!$makeFord){

                                        MakeFord::create(['MakeName' => $make, 'slug' => $this->slugify_text($make) ]);
                                //      $slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
                                }
			}
		}
	}

 */      

	$accesories = FordAccesories::select(["make","year","model"])->where('part_no_original',$lang)->get();

        foreach($accesories as $accesory){
		$years = explode(",",$accesory->year);
	print_r($years);	
                $makes = explode(",",$accesory->make);
		$models = explode(",",$accesory->model);
                foreach($makes as $make){
			//echo "make 2:".$make;
			if($make == "")
				$make = "All";

			if($make != ""){

                                $makeFord = MakeFord::where('MakeName',$make)->first();
				print_r($makeFord);
				

                                if($makeFord){

					
					print_r($models);
					foreach($models as $model){
						if($model == '')
							$model = "All";

						if($accesory->year == ''){
							$year = 0;
						$modelFord = ModelFord::where('Year',$year)->where('ModelName',$model)->where('MakeID',$makeFord->getKey())->first();

						
						if(!$modelFord){
							$maxModel = intval(ModelFord::max('ModelID'));
							$max = 0;
							if($maxModel == 0)
								$max = 1;
							else
								$max = $maxModel + 1;

							ModelFord::create(['MakeID' => $makeFord->getKey(),
								'ModelID' => $max,
                                                        'ModelName' => $model,
                                                        'Year' => $year,
                                                        'slug' => $this->slugify_text($model),
                                                        'photo' => 'test.jpg' ]);
                                                //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
						}
						}
						foreach($years as $year){
						$modelFord = ModelFord::where('Year',$year)->where('ModelName',$model)->where('MakeID',$makeFord->getKey())->where('Year',$year)->first();


						if(!$modelFord){
							$maxModel = intval(ModelFord::max('ModelID'));
							$max = 0;
							if($maxModel == 0)
								$max = 1;
							else
								$max = $maxModel + 1;


							ModelFord::create(['MakeID' => $makeFord->getKey(),
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

 

	$accesories1 = FordAccesories::all();
	print_r($accesories1);

	foreach($accesories1 as $accesory){
		if($accesory->part_no_original != $lang){
			continue;
		}
		echo "Category:".$accesory->category;
		$categories = explode("/",$accesory->category);

		$product = ProductFord::where("part_no",$accesory->part_no)->first();

		if(!$product){
		ProductFord::create(['Name' => $accesory->name,'part_no' => $accesory->part_no,'part_no_original' => $accesory->part_no_original,'image' => $accesory->image,'description' => $accesory->description,'vehicle_disclaimer' => $accesory->vehicle_disclaimer, 'brand' => $accesory->brand,'color' => $accesory->color,'price' => $accesory->price,'cost' => $accesory->cost,'weight' => $accesory->weight,'height' => $accesory->height, 'width' => $accesory->width,'length' => $accesory->length,'install_time' => $accesory->install_time,'slug' => $this->slugify_text($accesory->name)]);
		}
		$product = ProductFord::where("part_no",$accesory->part_no)->first();
		$product_id = $product->getKey();
		/*foreach($categories as $category){
			echo "category 2:".$category;
			if($category != ""){
				$categoryFord = CategoryFord::where('CategoryName',$category)->first();
				//print_r($makeFord);
				if(!$categoryFord){

					CategoryFord::create(['CategoryName' => $category, 'slug' => $category ]);
					//$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
				}
			}
		}
		 */
		 

		$categoryFord = CategoryFord::where('CategoryName',$categories[0])->first();
		if(!$categoryFord){

                     CategoryFord::create(['CategoryName' => $categories[0], 'slug' => $this->slugify_text($categories[0])]);
                                        //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
		}
		if(empty($categories[1])){
			$categories[1] = "All";
		}
		$categoryFord = CategoryFord::where('CategoryName',$categories[0])->first();
		if($categoryFord){

			$subCategoryFord = SubCategoryFord::where('SubCategoryName',$categories[1])->first();
		    if(is_null($subCategoryFord)){	
			SubCategoryFord::create(['SubCategoryName' => $categories[1], 'slug' => $this->slugify_text($categories[1]),'CategoryID'=> $categoryFord->getKey() ]);
                                        //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
		}
		}

		if(empty($categories[2])){
			
			$categories[2] = "All";	
		}	
			$categoryFord = CategoryFord::where('CategoryName',$categories[2])->first();
		
		if(!$categoryFord){

                     CategoryFord::create(['CategoryName' => $categories[2], 'slug' => $this->slugify_text($categories[2]) ]);
                                        //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
                }
			if(empty($categories[3])){
				$categories[3] = "All";
			}
                $categoryFord = CategoryFord::where('CategoryName',$categories[2])->first();
                if($categoryFord){
			$subCategoryFord = SubCategoryFord::where('SubCategoryName',$categories[3])->first();
			if(is_null($subCategoryFord)){
			SubCategoryFord::create(['SubCategoryName' => $categories[3], 'slug' => $this->slugify_text($categories[3]),'CategoryID'=> $categoryFord->getKey() ]);
                                        //$slug = SlugService::createSlug(MakeFord::class, 'slug', $make);
			}
		
		}

	    $categoryFord1 = CategoryFord::where('CategoryName',$categories[0])->first();
            $subCategoryFord1 = SubCategoryFord::where('SubCategoryName',$categories[1])->first();
            $categoryFord2 = CategoryFord::where('CategoryName',$categories[2])->first();
            $subCategoryFord2 = SubCategoryFord::where('SubCategoryName',$categories[3])->first();

            $makes = explode(",",$accesory->make);
            $models = explode(",",$accesory->model);
            $years = explode(",",$accesory->year);

            if($accesory->year == ''){
                $years = array(0);
            }
            foreach($makes as $make){
                //echo "make 2:".$make;
                if($make == "")
                    $make = "All";
                $makeFord = MakeFord::where('MakeName',$make)->first();

                foreach($models as $model){
                    if($model == '')
                        $model = "All";
                    foreach($years as $year){
                    $modelFord = ModelFord::where('ModelName',$model)->where('MakeID',$makeFord->getKey())->where('Year',$year)->first();

		    if($modelFord){
		    
			    $modelID = $modelFord->getKey();
		    
			    if($categoryFord1 && $subCategoryFord1){
			    
                        $modelCategoryFord1 = ModelCategoryFord::where('BaseVehicleID',$modelID)->where('CategoryID',$categoryFord1->getKey())->where('SubCategoryID',$subCategoryFord1->getKey())->first();

                        if(!$modelCategoryFord1){

				ModelCategoryFord::create(['CategoryID' => $categoryFord1->getKey(), 
							  'SubCategoryID' => $subCategoryFord1->getKey(),
							   'BaseVehicleID'=> $modelID]);
			}

 			$modelCategoryFord12 = ModelCategoryFord::where('BaseVehicleID',$modelID)->where('CategoryID',$categoryFord1->getKey())->where('SubCategoryID',$subCategoryFord1->getKey())->first();

			$categoryProductFord12 = CategoryProductFord::where('ModelCategoryID', $modelCategoryFord12->getKey())->where('ItemID', $product_id)->first();

			if(!$categoryProductFord12){
			CategoryProductFord::create(['ModelCategoryID' => $modelCategoryFord12->getKey(),
				'ItemID' => $product_id]);
                        }}
			    if($categoryFord2 && $subCategoryFord2){
			
                        $modelCategoryFord2 = ModelCategoryFord::where("BaseVehicleID",$modelID)->where('CategoryID',$categoryFord2->getKey())->where('SubCategoryID',$subCategoryFord2->getKey())->first();

                        if(!$modelCategoryFord2){

				ModelCategoryFord::create(['CategoryID' => $categoryFord2->getKey(), 
						           'SubCategoryID' => $subCategoryFord2->getKey(),
							   'BaseVehicleID'=> $modelID]);
}
			    }

			     $modelCategoryFord22 = ModelCategoryFord::where('BaseVehicleID',$modelID)->where('CategoryID',$categoryFord2->getKey())->where('SubCategoryID',$subCategoryFord2->getKey())->first();

		$categoryProductFord22 = CategoryProductFord::where('ModelCategoryID', $modelCategoryFord22->getKey())->where('ItemID', $product_id)->first();

                        if(!$categoryProductFord22){
                        CategoryProductFord::create(['ModelCategoryID' => $modelCategoryFord22->getKey(),
                                'ItemID' => $product_id]);
                        } 
                    }
                    }

                    
                }
            }
		
	
	}
	return 0;//redirect()->back()->with('success', 'CSV file imported successfully.');
    
    }
}
