<?php

namespace App\Models\SmartDealer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelCategorySmartDealer extends Model
{
    use HasFactory;

    protected $table = 'modelcategorykeith';
    protected $primaryKey = 'ModelCategoryID';
    protected $fillable = [
        'CategoryID',
        'BaseVehicleID',
        'SubCategoryID'
    ];

    public function getKey(): int {
        return $this->ModelCategoryID;
    }
}
