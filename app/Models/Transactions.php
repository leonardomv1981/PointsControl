<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_program',
        'date',
        'points',
        'value_points',
        'type',
        'description',
        'status',
    ];
}
