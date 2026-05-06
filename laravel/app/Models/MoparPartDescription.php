<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoparPartDescription extends Model
{

	 protected $table = 'moparpartdescription';
        //protected $primaryKey = 'ford_id';

        protected $fillable = [
        'Market',
        'Language',
        'PartNumber',
        'Category',
        'Subcategory',
        'Group',
        'GroupDescription',
        'GroupDisclosure',
        'PartDescription',

        'PartDisclosure',
	'PriceDate',
	'MSRP',
	'DealerNetPricing',
	'InstallTime',
	'ISheet',
	'MarketingName',
	'NounName',
	'NounDescription'


        ];

    use HasFactory;
}
