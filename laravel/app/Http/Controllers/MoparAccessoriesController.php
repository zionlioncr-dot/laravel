<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MakeMopar;
use App\Models\ModelMopar;
use App\Models\ModelCategoryMopar;
use App\Models\ProductMopar;
use Symfony\Component\Process\Process;

class MoparAccessoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getMakesMopar', 'getEnvyMakesMopar', 'getEnvyMakesYearsMopar', 'getEnvyMakesYearModelsMopar', 'getEnvyCategoryMopar', 'getEnvySubCategoryMopar', 'getEnvyProductsMopar', 'getEnvySlugsMopar', 'getMakesModelsMopar', 'getMakesModelsYearsMopar', 'getCategoryMopar', 'getSubCategoryMopar', 'getProductsMopar', 'getProductsMoparSearch', 'getVehicleMopar', 'getEnvyProductMopar', 'getEnvyProductsMoparSuggestions']);
    }

    public function getMakesMopar(Request $request)
    {

        try {
            $makes = MakeMopar::select('MakeName', 'slug')->get();
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($makes)), 'data' => $makes]);
    }

    public function getMakesModelsMopar(Request $request, $make_slug)
    {


        try {
            //echo "slug".$make_slug;	    
            $models = ModelMopar::distinct()->select('ModelName', 'modelmopar.slug', 'photo')
                ->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')
                ->where("makemopar.slug", $make_slug)->get();
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCodde' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($models)), 'data' => $models]);
    }

    public function getMakesModelsYearsMopar(Request $request, $make_slug, $model_slug)
    {
        try {
            $year = ModelMopar::distinct()->select('Year')
                ->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')
                ->where('makemopar.slug', $make_slug)->where('modelmopar.slug', $model_slug)->get();


        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($year)), 'data' => $year]);
    }


    public function getVehicleMopar(Request $request, $make_slug, $model_slug, $year)
    {

        try {
            $vehicle = ModelMopar::distinct()->select('BaseVehicleID')
                ->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')
                ->where('makemopar.slug', $make_slug)->where('modelmopar.slug', $model_slug)
                ->where('Year', $year)->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($vehicle)), 'data' => $vehicle]);
    }


    public function getCategoryMopar(Request $request, $make_slug, $model_slug, $year)
    {

        try {

            $categories = ModelCategoryMopar::distinct()->select('categorymopar.CategoryName', 'categorymopar.slug')->where("BaseVehicleID", $request->BaseVehicleID)

                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($categories)), 'data' => $categories]);
    }

    public function getSubCategoryMopar(Request $request, $make_slug, $model_slug, $year, $category_slug)
    {

        try {
            $subcategories = ModelCategoryMopar::distinct()->select('subcategorymopar.SubCategoryName', 'subcategorymopar.slug')->where('modelcategorymopar.BaseVehicleID', $request->BaseVehicleID)
                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')
                ->where('categorymopar.slug', $category_slug)
                ->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')
                ->join('categoryproductmopar', 'categoryproductmopar.ModelCategoryID', '=', 'modelcategorymopar.ModelCategoryID')->join('productmopar', 'productmopar.ItemID', '=', 'categoryproductmopar.ItemID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($subcategories)), 'data' => $subcategories]);
    }

    public function getProductsMopar(Request $request, $make_slug, $model_slug, $year, $category_slug, $subcategory_slug)
    {

        try {
            $products = ModelCategoryMopar::select('productmopar.*')->where('modelcategorymopar.BaseVehicleID', $request->BaseVehicleID)
                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')
                ->where('categorymopar.slug', $category_slug)
                ->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')
                ->where('subcategorymopar.slug', $subcategory_slug)
                ->join('categoryproductmopar', 'categoryproductmopar.ModelCategoryID', '=', 'modelcategorymopar.ModelCategoryID')->join('productmopar', 'productmopar.ItemID', '=', 'categoryproductmopar.ItemID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => $products]);
    }

    public function getProductsMoparSearch(Request $request)
    {

        try {
            $products = ProductMopar::where('part_no', 'LIKE', '%' . $request->search . '%')
                ->orWhere('Name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                ->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => $products]);
    }




    public function getEnvyMakesMopar(Request $request)
    {

        try {
            $makes = MakeMopar::select('MakeID as id', 'MakeName', 'slug')->get();
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($makes)), 'data' => $makes]);
    }


    public function getEnvyMakesYearsMopar(Request $request, $makeID)
    {
        try {
            $year = ModelMopar::distinct()->select('Year as name')
                ->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')
                ->where('makemopar.MakeID', $makeID)->get();


        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($year)), 'data' => $year]);
    }


    public function getEnvyMakesYearModelsMopar(Request $request, $makeID, $year)
    {


        try {
            //echo "slug".$make_slug;
            $models = ModelMopar::distinct()->select('BaseVehicleID', 'ModelName as name', 'modelmopar.slug', 'photo as path_image')
                ->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')
                ->where("makemopar.MakeID", $makeID)->where("modelmopar.Year", $year)->get();
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCodde' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($models)), 'data' => $models]);
    }


    public function getEnvyCategoryMopar(Request $request, $makeID, $year, $BaseVehicleID)
    {

        try {

            $categories = ModelCategoryMopar::distinct()->select('categorymopar.CategoryID as id ', 'categorymopar.CategoryName as name', 'categorymopar.slug')->where("BaseVehicleID", $BaseVehicleID)

                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($categories)), 'data' => $categories]);
    }



    public function getEnvySubCategoryMopar(Request $request, $makeID, $year, $BaseVehicleID, $CategoryID)
    {

        try {
            $subcategories = ModelCategoryMopar::distinct()->select('subcategorymopar.SubCategoryID as id', 'subcategorymopar.SubCategoryName as name', 'subcategorymopar.slug')->where('modelcategorymopar.BaseVehicleID', $BaseVehicleID)
                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')
                ->where('categorymopar.CategoryID', $CategoryID)
                ->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')
                ->join('categoryproductmopar', 'categoryproductmopar.ModelCategoryID', '=', 'modelcategorymopar.ModelCategoryID')->join('productmopar', 'productmopar.ItemID', '=', 'categoryproductmopar.ItemID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($subcategories)), 'data' => $subcategories]);
    }

    public function getEnvyProductsMopar(Request $request, $makeID, $year, $BaseVehicleID, $CategoryID, $SubCategoryID)
    {

        try {
            if($SubCategoryID == 0){
                $products = ModelCategoryMopar::select('productmopar.*')->where('modelcategorymopar.BaseVehicleID', $BaseVehicleID)
                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')
                ->where('categorymopar.CategoryID', $CategoryID)
                ->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')
                //->where('subcategorymopar.SubCategoryID', $SubCategoryID)
                ->join('categoryproductmopar', 'categoryproductmopar.ModelCategoryID', '=', 'modelcategorymopar.ModelCategoryID')->join('productmopar', 'productmopar.ItemID', '=', 'categoryproductmopar.ItemID')->get();


            }else{
                $products = ModelCategoryMopar::select('productmopar.*')->where('modelcategorymopar.BaseVehicleID', $BaseVehicleID)
                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')
                ->where('categorymopar.CategoryID', $CategoryID)
                ->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')
                ->where('subcategorymopar.SubCategoryID', $SubCategoryID)
                ->join('categoryproductmopar', 'categoryproductmopar.ModelCategoryID', '=', 'modelcategorymopar.ModelCategoryID')->join('productmopar', 'productmopar.ItemID', '=', 'categoryproductmopar.ItemID')->get();

            }
            
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => $products]);
    }

    public function getEnvySlugsMopar(Request $request, $vehicle)
    {
        $vehicleArray = explode('-', $vehicle);

        try {
            $products = ModelCategoryMopar::when($vehicleArray, function ($query, $vehicleArray) {
                if (isset($vehicleArray[6])) {
                    return $query->distinct()->select('makemopar.MakeID', 'makemopar.MakeName', 'makemopar.slug as MakeSlug', 'modelmopar.BaseVehicleID', 'modelmopar.ModelName', 'modelmopar.slug as ModelSlug', 'modelmopar.Year', 'categorymopar.CategoryID', 'categorymopar.CategoryName', 'categorymopar.slug as CategorySlug', 'subcategorymopar.SubCategoryID', 'subcategorymopar.SubCategoryName', 'subcategorymopar.slug as SubCategorySlug', 'productmopar.ItemID', 'productmopar.Name as ProductName', 'productmopar.slug as ProductSlug')->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')->where('categorymopar.slug', $vehicleArray[4])->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')->where('subcategorymopar.slug', $vehicleArray[5])->join('categoryproductmopar', 'categoryproductmopar.ModelCategoryID', '=', 'modelcategorymopar.ModelCategoryID')->join('productmopar', 'productmopar.ItemID', '=', 'categoryproductmopar.ItemID')->where('productmopar.slug', $vehicleArray[6])->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')->where('makemopar.slug', $vehicleArray[1])->where('modelmopar.Year', $vehicleArray[2])->where('modelmopar.slug', $vehicleArray[3]);
                }

                if (isset($vehicleArray[5])) {
                    return $query->distinct()->select('makemopar.MakeID', 'makemopar.MakeName', 'makemopar.slug as MakeSlug', 'modelmopar.BaseVehicleID', 'modelmopar.ModelName', 'modelmopar.slug as ModelSlug', 'modelmopar.Year', 'categorymopar.CategoryID', 'categorymopar.CategoryName', 'categorymopar.slug as CategorySlug', 'subcategorymopar.SubCategoryID', 'subcategorymopar.SubCategoryName', 'subcategorymopar.slug as SubCategorySlug')->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')->where('categorymopar.slug', $vehicleArray[4])->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')->where('subcategorymopar.slug', $vehicleArray[5])->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')->where('makemopar.slug', $vehicleArray[1])->where('modelmopar.Year', $vehicleArray[2])->where('modelmopar.slug', $vehicleArray[3]);
                }

                if (isset($vehicleArray[4])) {
                    return $query->distinct()->select('makemopar.MakeID', 'makemopar.MakeName', 'makemopar.slug as MakeSlug', 'modelmopar.BaseVehicleID', 'modelmopar.ModelName', 'modelmopar.slug as ModelSlug', 'modelmopar.Year', 'categorymopar.CategoryID', 'categorymopar.CategoryName', 'categorymopar.slug as CategorySlug')->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')->where('categorymopar.slug', $vehicleArray[4])->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')->where('makemopar.slug', $vehicleArray[1])->where('modelmopar.Year', $vehicleArray[2])->where('modelmopar.slug', $vehicleArray[3]);
                }

                if (isset($vehicleArray[3])) {
                    return $query->select('makemopar.MakeID', 'makemopar.MakeName', 'makemopar.slug as MakeSlug', 'modelmopar.BaseVehicleID', 'modelmopar.ModelName', 'modelmopar.slug as ModelSlug', 'modelmopar.Year')->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')->where('makemopar.slug', $vehicleArray[1])->where('modelmopar.Year', $vehicleArray[2])->where('modelmopar.slug', $vehicleArray[3]);
                }

                if (isset($vehicleArray[2])) {
                    return $query->distinct()->select('makemopar.MakeID', 'makemopar.MakeName', 'makemopar.slug as MakeSlug', 'modelmopar.BaseVehicleID', 'modelmopar.ModelName', 'modelmopar.slug as ModelSlug', 'modelmopar.Year')->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')->where('makemopar.slug', $vehicleArray[1])->where('modelmopar.Year', $vehicleArray[2]);
                }

                if (isset($vehicleArray[1])) {
                    return $query->distinct()->select('makemopar.MakeID', 'makemopar.MakeName', 'makemopar.slug as MakeSlug')->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')->where('makemopar.slug', $vehicleArray[1]);
                }
            })->get();

            $slugs = array();

            if (isset($vehicleArray[1])) {
                array_push($slugs, array("id" => $products[0]['MakeID'], "name" => $products[0]['MakeName'], "slug" => $products[0]['MakeSlug'], "pName" => "makeId"));
            }
            if (isset($vehicleArray[2])) {
                array_push($slugs, array('id' => $products[0]["Year"], 'name' => $products[0]["Year"], 'slug' => $products[0]["Year"], 'pName' => 'yearId'));
            }
            if (isset($vehicleArray[3])) {
                array_push($slugs, array('id' => $products[0]["BaseVehicleID"], 'name' => $products[0]["ModelName"], 'slug' => $products[0]["ModelSlug"], 'pName' => 'modelId'));
            }

            if (isset($vehicleArray[4])) {
                array_push($slugs, array('id' => $products[0]["CategoryID"], 'name' => $products[0]["CategoryName"], 'slug' => $products[0]["CategorySlug"], 'pName' => 'categoryId'));
            }
            if (isset($vehicleArray[5])) {
                array_push($slugs, array('id' => $products[0]["SubCategoryID"], 'name' => $products[0]["SubCategoryName"], 'slug' => $products[0]["SubCategorySlug"], 'pName' => 'subcategoryId'));
            }
            if (isset($vehicleArray[6])) {
                array_push($slugs, array('id' => $products[0]["ItemID"], 'name' => $products[0]["ProductName"], 'slug' => $products[0]["ProductSlug"], 'pName' => 'productId'));
            }

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => array('catalog' => 'mopar', 'slugs' => $slugs)]);
    }

    public function getEnvyProductMopar(Request $request)
    {
        $json = $request->post();

        //print_r($json);

        try {
            //print_r($json["partNumber"]);
            $products = ProductMopar::select('productmopar.*')->where('productmopar.part_no', $json["partNumber"])->get();
            //print_r($products[0]); 

            $price = str_replace("$", "", $products[0]->price);

            $part[] = array(
                "id" => $products[0]->ItemID,
                "name" => $products[0]->name,
                "description" => $products[0]->description,
                "notes" => "",
                "price" => array("price" => $price, "showPrice" => $price),
                "partNumber" => $products[0]->part_no,
                "path_image" => $products[0]->image,
                "assembly" => 0,
                "position" => 0,
                "vehicles" => array(),
                "shippingInfo" => array("weight" => 0, "packs" => 0, "length" => 0, "width" => 0, "height" => 0),
                "relatedProducts" => array(),
                "isTaxable" => true
            );

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => array("part" => $part)]);
    }

    public function getEnvyProductsMoparSuggestions(Request $request)
    {
        $json = $request->post();
        //print_r($json);
        try {
            $products = ProductMopar::select([
                'productmopar.*',
                'makemopar.MakeID',
                'makemopar.MakeName',
                'makemopar.slug as MakeSlug',
                'modelmopar.BaseVehicleID',
                'modelmopar.Year',
                'modelmopar.ModelName',
                'modelmopar.slug as ModelSlug',
                'categorymopar.CategoryID',
                'categorymopar.CategoryName',
                'categorymopar.slug as CategorySlug',
                'subcategorymopar.SubCategoryID',
                'subcategorymopar.SubCategoryName',
                'subcategorymopar.slug as SubCategorySlug'
            ])
                ->where(function ($query) use ($json) {
                    $query->where('part_no', 'LIKE', '%' . $json["keyword"] . '%')
                        ->orWhere('Name', 'LIKE', '%' . $json["keyword"] . '%')
                        ->orWhere('description', 'LIKE', '%' . $json["keyword"] . '%');
                })
                ->join('categoryproductmopar', 'categoryproductmopar.ItemID', '=', 'productmopar.ItemID')
                ->join('modelcategorymopar', 'modelcategorymopar.ModelCategoryID', '=', 'categoryproductmopar.ModelCategoryID')
                ->join('categorymopar', 'categorymopar.CategoryID', '=', 'modelcategorymopar.CategoryID')
                ->join('subcategorymopar', 'subcategorymopar.SubCategoryID', '=', 'modelcategorymopar.SubCategoryID')
                ->join('modelmopar', 'modelmopar.BaseVehicleID', '=', 'modelcategorymopar.BaseVehicleID')
                ->join('makemopar', 'makemopar.MakeID', '=', 'modelmopar.MakeID')
                ->where('makemopar.slug', $json["slugs"]["make"])
                ->where('modelmopar.year', $json["slugs"]["year"])
                ->where('modelmopar.slug', $json["slugs"]["model"])
                ->get();

            $parts = [];

            foreach ($products as &$product) {
                $price = str_replace("$", "", $product->price);

                $slugs[0] = array(
                    "id" => $product->MakeID,
                    "name" => $product->MakeName,
                    "slug" => $product->MakeSlug,
                    "pName" => "makeId"
                );
                $slugs[1] = array(
                    "id" => $product->Year,
                    "name" => $product->Year,
                    "slug" => $product->Year,
                    "pName" => "yearId"
                );
                $slugs[2] = array(
                    "id" => $product->BaseVehicleID,
                    "name" => $product->ModelName,
                    "slug" => $product->ModelSlug,
                    "pName" => "modelId"
                );
                $slugs[3] = array(
                    "id" => 0,
                    "name" => "",
                    "slug" => "",
                    "pName" => "trimId"
                );
                $slugs[4] = array(
                    "id" => 0,
                    "name" => "",
                    "slug" => "",
                    "pName" => "engineId"
                );
                $slugs[5] = array(
                    "id" => $product->CategoryID,
                    "name" => $product->CategoryName,
                    "slug" => $product->CategorySlug,
                    "pName" => "categoryId"
                );
                $slugs[6] = array(
                    "id" => $product->SubCategoryID,
                    "name" => $product->SubCategoryName,
                    "slug" => $product->SubCategorySlug,
                    "pName" => "subcategoryId"
                );

                $part = array(
                    "id" => $product->ItemID,
                    "name" => $product->name,
                    "part_number" => $products[0]->part_no,
                    "oePartNumber" => "",
                    "oe_part_numbers" => "",
                    "slug" => $product->slug,
                    "pathImage" => $product->image,
                    "price" => array("price" => $price, "showPrice" => $price),
                    "assembly" => 0,
                    "position" => 0,
                    "slugs" => $slugs,
                    "available" => true
                );

                array_push($parts, $part);
            }


        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'products' => $parts]);
    }

}

