<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoparVehicleDefinition extends Model
{

	 protected $table = 'moparvechicledefinition';
        //protected $primaryKey = 'ford_id';

        protected $fillable = [
        'Market',
        'Language',
        'ApplicationCode',
        'ApplicationName',
        'Year',
        'DivisionName',
        'DivisionImage',
        'FamilyName',
        'Model',

        'Line',
        'Series',

        'Body',
        'VehicleImage',
        

    ];
    use HasFactory;
}
