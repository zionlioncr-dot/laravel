<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoparPartNames extends Model
{

	protected $table = 'moparpartnames';

	protected $fillable = [
        'part_number',
        'marketing_name',
        'noun_name',
        'noun_description'
    ];
    use HasFactory;
}
