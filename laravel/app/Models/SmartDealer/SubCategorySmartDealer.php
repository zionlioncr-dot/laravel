<?php

namespace App\Models\SmartDealer;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategorySmartDealer extends Model
{
    use Sluggable, HasFactory;

    protected $table = 'subcategorykeith';
    protected $primaryKey = 'SubCategoryID';
    protected $fillable = [
        'CategoryID',
        'SubCategoryName',
        'slug',
    ];

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
