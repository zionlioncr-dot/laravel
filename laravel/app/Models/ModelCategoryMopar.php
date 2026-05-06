<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCategoryMopar extends Model
{

        protected $table = 'modelcategorymopar';
         protected $primaryKey = 'ModelCategoryID';


          protected $fillable = [
        'CategoryID',
	'BaseVehicleID',
	'SubCategoryID'
	

          ];

use HasFactory;

public function getKey(): int {
	return $this->ModelCategoryID;
}

}
