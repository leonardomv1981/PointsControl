<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loungesaccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_loungescard',
        'date',
        'airport',
        'access_own',
        'access_guest',
        'status',
    ];
}
