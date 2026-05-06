<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FordAccesories extends Model
{
	protected $table = 'ford';
	protected $primaryKey = 'ford_id';

	protected $fillable = [
        'name',
        'part_no',
        'part_no_original',
	'image',
	'year',
	'make',
	'model',
	'description',
	'vehicle_disclaimer',
	
	'brand',
	'category',
	
	'color',
	'price',
	'cost',
	'weight',
	'height',
	'width',
	'length',
	'install_time',
	
    ];

    use HasFactory;
}
