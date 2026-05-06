<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoparPartApplication extends Model
{
	protected $table = 'moparpartapplication';
        //protected $primaryKey = 'ford_id';

        protected $fillable = [
        'Market',
        'Language',
        'PartNumber',
        'ModelYear',
        'ApplicationCode',
        'Application',
        'ApplicationRemark',
        'VehicleCode',
        'VehicleLine',

        'Image',
        'ImageCaption',

       
	];
    use HasFactory;
}
