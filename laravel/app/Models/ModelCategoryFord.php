<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCategoryFord extends Model
{

        protected $table = 'modelcategoryford';
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
