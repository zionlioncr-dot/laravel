<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function() {
    return 'SmartDealerAPI v2.0 Documentation';
});

Route::middleware('App\Http\Middleware\BasicAuthMiddleware')->group(function() {
    /**
     * Vehicle Inventory Data
     */

    /** Ford Accessory Data */
    Route::get('/catalog/ford-accessories/getMakesFord', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getMakesFord');
    Route::get('/catalog/ford-accessories/getMakesModelsFord/{make_slug}', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getMakesModelsFord');
    Route::get('/catalog/ford-accessories/getMakesModelsYearsFord/{make_slug}/{model_slug}', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getMakesModelsYearsFord');
    Route::get('/catalog/ford-accessories/getVehicleFord/{make_slug}/{model_slug}/{year}', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getVehicleFord');
    Route::get('/catalog/ford-accessories/getCategoryFord/{make_slug}/{model_slug}/{year}', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getCategoryFord');
    Route::get('/catalog/ford-accessories/getSubCategoryFord/{make_slug}/{model_slug}/{year}/{category_slug}', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getSubCategoryFord');
    Route::get('/catalog/ford-accessories/getProductsFord/{make_slug}/{model_slug}/{year}/{category_slug}/{subcategory_slug}', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getProductsFord');
    Route::get('/catalog/ford-accessories/getProductsFordSearch', 'App\Http\Controllers\EPC\Ford\FordAccessoriesController@getProductsFordSearch');


    /**
     * Vehicle Inventory Data
     */

    /** Mopar Accessory Data */
    Route::get('/catalog/mopar-accessories/getMakesMopar', 'App\Http\Controllers\MoparAccessoriesController@getMakesMopar');
    Route::get('/catalog/mopar-accessories/getMakesModelsMopar/{make_slug}', 'App\Http\Controllers\MoparAccessoriesController@getMakesModelsMopar');
    Route::get('/catalog/mopar-accessories/getMakesModelsYearsMopar/{make_slug}/{model_slug}', 'App\Http\Controllers\MoparAccessoriesController@getMakesModelsYearsMopar');
    Route::get('/catalog/mopar-accessories/getVehicleMopar/{make_slug}/{model_slug}/{year}', 'App\Http\Controllers\MoparAccessoriesController@getVehicleMopar');
    Route::get('/catalog/mopar-accessories/getCategoryMopar/{make_slug}/{model_slug}/{year}', 'App\Http\Controllers\MoparAccessoriesController@getCategoryMopar');
    Route::get('/catalog/mopar-accessories/getSubCategoryMopar/{make_slug}/{model_slug}/{year}/{category_slug}', 'App\Http\Controllers\MoparAccessoriesController@getSubCategoryMopar');
    Route::get('/catalog/mopar-accessories/getProductsMopar/{make_slug}/{model_slug}/{year}/{category_slug}/{subcategory_slug}', 'App\Http\Controllers\MoparAccessoriesController@getProductsMopar');
    Route::get('/catalog/mopar-accessories/getProductsMoparSearch', 'App\Http\Controllers\MoparAccessoriesController@getProductsMoparSearch');


/**
     * Vehicle Inventory Data
     */
/** Keith Accessory Data */
    Route::get('/catalog/smartdealer/getMakes', 'App\Http\Controllers\SmartDealerhAccessoriesController@getMakes');
    Route::get('/catalog/smartdealer/getMakesModels/{make_slug}', 'App\Http\Controllers\SmartDealerAccessoriesController@getMakesModels');
    Route::get('/catalog/smartdealer/getMakesModelsYears/{make_slug}/{model_slug}', 'App\Http\Controllers\SmartDealerAccessoriesController@getMakesModelsYears');
    Route::get('/catalog/smartdealer/getVehicle/{make_slug}/{model_slug}/{year}', 'App\Http\Controllers\SmartDealerAccessoriesController@getVehicle');
    Route::get('/catalog/smartdealer/getCategory/{make_slug}/{model_slug}/{year}', 'App\Http\Controllers\SmartDealerAccessoriesController@getCategory');
    Route::get('/catalog/smartdealer/getSubCategory/{make_slug}/{model_slug}/{year}/{category_slug}', 'App\Http\Controllers\SmartDealerAccessoriesController@getSubCategory');
    Route::get('/catalog/smartdealer/getProducts/{make_slug}/{model_slug}/{year}/{category_slug}/{subcategory_slug}', 'App\Http\Controllers\SmartDealerAccessoriesController@getProducts');
    Route::get('/catalog/smartdealer/getProductsSearch', 'App\Http\Controllers\SmartDealerAccessoriesController@getProductsKeithSearch');
});

    Route::get('/makes/', 'App\Http\Controllers\MoparAccessoriesController@getEnvyMakesMopar');
    Route::get('/years/makes/{makeID}', 'App\Http\Controllers\MoparAccessoriesController@getEnvyMakesYearsMopar');
    Route::get('/models/makes/{makeID}/years/{year}', 'App\Http\Controllers\MoparAccessoriesController@getEnvyMakesYearModelsMopar');

    Route::get('/categories/makes/{makeID}/years/{year}/models/{BaseVehicleID}', 'App\Http\Controllers\MoparAccessoriesController@getEnvyCategoryMopar');
    Route::get('/subcategories/makes/{makeID}/years/{year}/models/{BaseVehicleID}/categories/{CategoryID}', 'App\Http\Controllers\MoparAccessoriesController@getEnvySubCategoryMopar');
    Route::get('/products/makes/{makeID}/years/{year}/models/{BaseVehicleID}/categories/{CategoryID}/subcategories/{SubCategoryID}', 'App\Http\Controllers\MoparAccessoriesController@getEnvyProductsMopar');
    Route::get('/seo-url/en/{vehicle}', 'App\Http\Controllers\MoparAccessoriesController@getEnvySlugsMopar');
    Route::post('/product-det/', 'App\Http\Controllers\MoparAccessoriesController@getEnvyProductMopar');
    Route::post('/suggestions-search/', 'App\Http\Controllers\MoparAccessoriesController@getEnvyProductsMoparSuggestions');
    