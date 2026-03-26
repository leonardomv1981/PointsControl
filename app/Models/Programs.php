<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programs extends Model
{
    use HasFactory;
    protected $table = 'programs';
    protected $fillable = [
        'id',
        'id_user',
        'program_name',
        'cpm_value',
        'points_validity',
        'status',
    ];
}
