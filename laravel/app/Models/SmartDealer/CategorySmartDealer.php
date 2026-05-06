<?php

namespace App\Models\SmartDealer;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorySmartDealer extends Model
{
     use Sluggable, HasFactory;

     protected $table = 'categorykeith';
     protected $primaryKey = 'CategoryID';
     protected $fillable = [
        'CategoryName',
        'slug',
     ];

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
