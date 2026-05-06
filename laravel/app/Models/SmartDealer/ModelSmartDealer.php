<?php

namespace App\Models\SmartDealer;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelSmartDealer extends Model
{
    use Sluggable, HasFactory;

    protected $table = 'modelkeith';
    protected $primaryKey = 'BaseVehicleID';
    protected $fillable = [
        'ModelID',
        'MakeID',
        'Year',
        'ModelName',
        'slug',
        'photo'
    ];

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
