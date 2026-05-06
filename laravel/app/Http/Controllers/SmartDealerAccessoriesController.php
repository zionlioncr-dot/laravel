<?php

namespace App\Http\Controllers;

use App\Models\SmartDealer\MakeSmartDealer;
use App\Models\SmartDealer\ModelCategorySmartDealer;
use App\Models\SmartDealer\ModelSmartDealer;
use App\Models\SmartDealer\ProductSmartDealer;
use Illuminate\Http\Request;

class SmartDealerAccessoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getMakes', 'getMakesModels', 'getMakesModelsYears', 'getCategory', 'getSubCategory', 'getProducts', 'getProductsSearch', 'getVehicle']);
    }

    public function getMakes(Request $request)
    {

        try {
            $makes = MakeSmartDealer::select('MakeName', 'slug')->get();
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($makes)), 'data' => $makes]);
    }

    public function getMakesModels(Request $request, $make_slug)
    {
        try {
            //echo "slug".$make_slug;
            $models = ModelSmartDealer::distinct()->select('ModelName', 'modelkeith.slug', 'photo')
                ->join('makekeith', 'makekeith.MakeID', '=', 'modelkeith.MakeID')
                ->where("makekeith.slug", $make_slug)->get();
        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCodde' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($models)), 'data' => $models]);
    }

    public function getMakesModelsYears(Request $request, $make_slug, $model_slug)
    {
        try {
            $year = ModelSmartDealer::distinct()->select('Year')
                ->join('makekeith', 'makekeith.MakeID', '=', 'modelkeith.MakeID')
                ->where('makekeith.slug', $make_slug)->where('modelkeith.slug', $model_slug)->get();


        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($year)), 'data' => $year]);
    }


    public function getVehicle(Request $request, $make_slug, $model_slug, $year)
    {

        try {
            $vehicle = ModelSmartDealer::distinct()->select('BaseVehicleID')
                ->join('makekeith', 'makekeith.MakeID', '=', 'modelkeith.MakeID')
                ->where('makekeith.slug', $make_slug)->where('modelkeith.slug', $model_slug)
                ->where('Year', $year)->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($vehicle)), 'data' => $vehicle]);
    }


    public function getCategory(Request $request, $make_slug, $model_slug, $year)
    {

        try {

            $categories = ModelCategorySmartDealer::distinct()->select('categorykeith.CategoryName', 'categorykeith.slug')->where("BaseVehicleID", $request->BaseVehicleID)
                ->join('categorykeith', 'categorykeith.CategoryID', '=', 'modelcategorykeith.CategoryID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($categories)), 'data' => $categories]);
    }

    public function getSubCategory(Request $request, $make_slug, $model_slug, $year, $category_slug)
    {

        try {
            $subcategories = ModelCategorySmartDealer::distinct()->select('subcategorykeith.SubCategoryName', 'subcategorykeith.slug')->where('modelcategorykeith.BaseVehicleID', $request->BaseVehicleID)
                ->join('categorykeith', 'categorykeith.CategoryID', '=', 'modelcategorykeith.CategoryID')
                ->where('categorykeith.slug', $category_slug)
                ->join('subcategorykeith', 'subcategorykeith.SubCategoryID', '=', 'modelcategorykeith.SubCategoryID')
                ->join('categoryproductkeith', 'categoryproductkeith.ModelCategoryID', '=', 'modelcategorykeith.ModelCategoryID')->join('productkeith', 'productkeith.ItemID', '=', 'categoryproductkeith.ItemID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($subcategories)), 'data' => $subcategories]);
    }

    public function getProducts(Request $request, $make_slug, $model_slug, $year, $category_slug, $subcategory_slug)
    {

        try {
            $products = ModelCategorySmartDealer::select('productkeith.*')->where('modelcategorykeith.BaseVehicleID', $request->BaseVehicleID)
                ->join('categorykeith', 'categorykeith.CategoryID', '=', 'modelcategorykeith.CategoryID')
                ->where('categorykeith.slug', $category_slug)
                ->join('subcategorykeith', 'subcategorykeith.SubCategoryID', '=', 'modelcategorykeith.SubCategoryID')
                ->where('subcategorykeith.slug', $subcategory_slug)
                ->join('categoryproductkeith', 'categoryproductkeith.ModelCategoryID', '=', 'modelcategorykeith.ModelCategoryID')->join('productkeith', 'productkeith.ItemID', '=', 'categoryproductkeith.ItemID')->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => $products]);
    }

    public function getProductsSearch(Request $request)
    {

        try {
            $products = ProductSmartDealer::where('ItemID', 'LIKE', '%' . $request->search . '%')
                ->orWhere('ItemTitle', 'LIKE', '%' . $request->search . '%')
                ->orWhere('ItemDescription', 'LIKE', '%' . $request->search . '%')
                ->get();

        } catch (Throwable $e) {
            return response()->json(['httpStatus' => array('statusCode' => 400, 'statusTxt' => 'Unable to Locate Accessory with that Part Number.')]);
        }

        return response()->json(['httpStatus' => array('statusCode' => 200, 'statusTxt' => 'OK', 'totalCount' => count($products)), 'data' => $products]);
    }
}
