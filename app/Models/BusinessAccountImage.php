<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class BusinessAccountImage extends Model
{
    use HasFactory;
   
 
   

  protected   $guarded = [];

  protected $hidden = ["deleted_at"];
}
