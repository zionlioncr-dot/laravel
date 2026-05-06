<?php

namespace App\Models\SmartDealer;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSmartDealer extends Model
{
    use Sluggable, HasFactory;

    protected $table = 'productkeith';
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
