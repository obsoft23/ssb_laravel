<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chats extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        
        'created_at' => 'datetime:H:i',
        
    ];


}
