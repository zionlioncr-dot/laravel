<?php

namespace App\Http\Controllers\EPC\Ford;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MakeFord;
use App\Models\ModelFord;
use App\Models\ModelCategoryFord;
use App\Models\ProductFord;
use Symfony\Component\Process\Process;

class FordAccessoriesController extends Controller
{
	public function __construct() {
    $this->middleware('auth')->except(['getMakesFord','getMakesModelsFord', 'getMakesModelsYearsFord','getCategoryFord','getSubCategoryFord','getProductsFord','getProductsFordSearch','getVehicleFord']);
}

    public function getMakesFord(Request $request)
    {

        try {
            $makes = MakeFord::all();
        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Makes', 'makes' => $makes]);
    }

    public function getMakesModelsFord(Request $request,$make_slug)
    {
	    
	    
	    try {
		echo "slug".$make_slug;	    
		$models = ModelFord::distinct()->select('ModelName','modelford.slug','photo')
				 ->join('makeford', 'makeford.MakeID', '=', 'modelford.MakeID')
				 ->where("makeford.slug",$make_slug)->get();
        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Models', 'models' => $models]);
    }

    public function getMakesModelsYearsFord(Request $request,$make_slug,$model_slug)
    {
	try {
		$year = ModelFord::distinct()->select('Year')
			        ->join('makeford', 'makeford.MakeID', '=', 'modelford.MakeID')
			       ->where('makeford.slug',$make_slug)->where('modelford.slug',$model_slug)->get();


        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Years', 'years' => $year]);
    }


    public function getVehicleFord(Request $request,$make_slug,$model_slug,$year)
    {

        try {
		$vehicle = ModelFord::distinct()->select('BaseVehicleID')				     
				     ->join('makeford', 'makeford.MakeID', '=', 'modelford.MakeID')
                               	     ->where('makeford.slug',$make_slug)->where('modelford.slug',$model_slug)
				     ->where('Year',$year)->get();

        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Categories', 'vehicle' => $vehicle]);
    }


    public function getCategoryFord(Request $request,$make_slug,$model_slug,$year)
    {

        try {

            $categories = ModelCategoryFord::distinct()->select('categoryford.CategoryName','categoryford.slug')->where("BaseVehicleID",$request->BaseVehicleID)

                ->join('categoryford', 'categoryford.CategoryID', '=', 'modelcategoryford.CategoryID')->get();

        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Vehicle', 'categories' => $categories]);
    }

    public function getSubCategoryFord(Request $request,$make_slug,$model_slug,$year,$category_slug)
    {

        try {
		    $subcategories = ModelCategoryFord::distinct()->select('subcategoryford.SubCategoryName','subcategoryford.slug')->where('modelcategoryford.BaseVehicleID',$request->BaseVehicleID)
                ->join('categoryford','categoryford.CategoryID','=','modelcategoryford.CategoryID')               
		->where('categoryford.slug',$category_slug)
		->join('subcategoryford','subcategoryford.SubCategoryID','=','modelcategoryford.SubCategoryID')
		->join('categoryproductford', 'categoryproductford.ModelCategoryID', '=', 'modelcategoryford.ModelCategoryID')->join('productford','productford.ItemID','=','categoryproductford.ItemID')->get();

        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled SubCategories', 'subcategories' => $subcategories]);
    }

    public function getProductsFord(Request $request,$make_slug,$model_slug,$year,$category_slug,$subcategory_slug)
    {

        try {
		$products = ModelCategoryFord::select('productford.*')->where('modelcategoryford.BaseVehicleID',$request->BaseVehicleID)
		->join('categoryford','categoryford.CategoryID','=','modelcategoryford.CategoryID')
                ->where('categoryford.slug',$category_slug)
		->join('subcategoryford','subcategoryford.SubCategoryID','=','modelcategoryford.SubCategoryID')
                ->where('subcategoryford.slug',$subcategory_slug)
                ->join('categoryproductford', 'categoryproductford.ModelCategoryID', '=', 'modelcategoryford.ModelCategoryID')->join('productford','productford.ItemID','=','categoryproductford.ItemID')->get();

        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Products', 'products' => $products]);
    }

    public function getProductsFordSearch(Request $request)
    {

        try {
		$products = ProductFord::where('part_no','LIKE','%'.$request->search.'%')
			   ->orWhere('Name','LIKE','%'.$request->search.'%')
		   	   ->orWhere('description','LIKE','%'.$request->search.'%')
			   ->get();

        } catch(Throwable $e)
        {
            return response()->json(['status' => 'Unable to Locate Accessory with that Part Number.'], 400);
        }

        return response()->json(['status' => 'Successfully Pulled Products', 'products' => $products]);
    }
}
