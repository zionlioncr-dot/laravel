<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelFord extends Model
{
use Sluggable;

        protected $table = 'modelford';
         protected $primaryKey = 'BaseVehicleID';


protected $fillable = [
	'ModelID',
        'MakeID',
	'Year',
	'ModelName',
	'slug',
	'photo'

          ];

use HasFactory;

public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'ModelName'
            ]
        ];
}

public function getKey(): int {
	return $this->ModelID;
}
}
