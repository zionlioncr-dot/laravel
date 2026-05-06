<?php

namespace App\Models\SmartDealer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductSmartDealer extends Model
{
	use HasFactory;

	protected $table = 'categoryproductkeith';

	protected $fillable = [
        'ModelCategoryID',
	    'ItemID',
    ];
}
