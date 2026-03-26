<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loungescards extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_user',
        'id_cardflag',
        'name',
        'login',
        'access_own',
        'access_guest',
        'access_own_used',
        'access_guest_used',
        'status',
    ];
        
}
