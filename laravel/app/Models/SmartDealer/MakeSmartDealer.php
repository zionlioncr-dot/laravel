<?php

namespace App\Models\SmartDealer;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeSmartDealer extends Model
{
    use Sluggable, HasFactory;

    protected $table = 'makekeith';
    protected $primaryKey = 'MakeID';
    protected $fillable = [
        'MakeName',
        'slug'
    ];

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
