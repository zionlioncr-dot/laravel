<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFord extends Model
{
use Sluggable;

        protected $table = 'categoryford';
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
