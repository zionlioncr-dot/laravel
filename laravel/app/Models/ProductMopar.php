<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMopar extends Model
{
use Sluggable;

        protected $table = 'productmopar';
         protected $primaryKey = 'ItemID';


          protected $fillable = [
        'Name',
	'part_no',
	'part_no_original',
	'image',
	'description',
	'vehicle_disclaimer',
	'brand',
	'color',
	'price',
	'cost',
	'weight',
	'height',
	'width',
	'length',
	'install_time',
	'slug',

          ];

use HasFactory;

public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'Name'
            ]
        ];
}

public function getKey(): int {
	return $this->ItemID;
}
}
