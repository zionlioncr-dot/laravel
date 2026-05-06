<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoparPartISheet extends Model
{

	protected $table = 'moparpartisheet';

	protected $fillable = [
        
        'part_number',
	'isheet',
	];
    use HasFactory;
}
