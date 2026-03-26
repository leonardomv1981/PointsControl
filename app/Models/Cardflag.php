<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardflag extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'flag',
        'app',
        'status',
    ];
}
