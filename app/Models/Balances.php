<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balances extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_program',
        'total_points',
        'total_value',
        'status'
    ];

}
