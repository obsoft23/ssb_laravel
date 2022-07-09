<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocations extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
        'category_id',
        
        'updated_at',
        'created_at'
    ];
}
