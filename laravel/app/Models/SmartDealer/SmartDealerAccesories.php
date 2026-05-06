<?php

namespace App\Models\SmartDealer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmartDealerAccesories extends Model
{
    use HasFactory;

	protected $table = 'accesories';
	//protected $primaryKey = 'ford_id';

	protected $fillable = [
        'Make',
        'Model',
        'Category',
        'SubCategory',
        'Part',
        'ItemTitle',
        'ItemDescription',
        'ListPrice',
        'BeginYear',
        'EndYear',
        'Image',
        'PDF',
        'LaborTime',
        'OptionA',
        'OptionB',
        'OptionC',
        'ItemID',
        'ItemHidden',
        'Cost',
    ];
}
