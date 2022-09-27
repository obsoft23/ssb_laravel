<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

  protected $guarded = [];

  protected $casts = [
    'read' => "int",
    'created_at' => 'datetime:H:i',
    
];
}
