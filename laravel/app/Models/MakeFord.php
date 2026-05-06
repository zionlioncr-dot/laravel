<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeFord extends Model
{
use Sluggable;

	protected $table = 'makeford';
         protected $primaryKey = 'MakeID';


          protected $fillable = [
        'MakeName',
	'slug'        

	  ];

use HasFactory;

public function getKey(): int {
	return $this->MakeID;
}

public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'MakeName'
            ]
        ];
}
}
