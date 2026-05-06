<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMopar extends Model
{
use Sluggable;

        protected $table = 'categorymopar';
         protected $primaryKey = 'CategoryID';


          protected $fillable = [
        'CategoryName',
	'slug',
	

          ];

use HasFactory;

public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'CategoryName'
            ]
        ];
}

public function getKey(): int {
	return $this->CategoryID;
}
}
