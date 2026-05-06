<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryMopar extends Model
{
use Sluggable;

        protected $table = 'subcategorymopar';
         protected $primaryKey = 'SubCategoryID';


protected $fillable = [
	'CategoryID',
        'SubCategoryName',
	'slug',
	

          ];

use HasFactory;

public function getKey(): int {
	return $this->SubCategoryID;
}

public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'SubCategoryName'
            ]
        ];
}
}
