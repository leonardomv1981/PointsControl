<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mytrips extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'id_trip'
    ];
}
