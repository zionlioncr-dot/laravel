<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProductFord extends Model
{
	use HasFactory;

	protected $table = 'categoryproductford';

	protected $fillable = [
        'ModelCategoryID',
	'ItemID',


          ];
}
