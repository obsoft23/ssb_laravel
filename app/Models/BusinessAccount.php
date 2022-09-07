<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAccount extends Model
{
    use HasFactory;
    protected $guarded = [];
    

    protected $hidden = [
        
        'vocation_id',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'active_days' => 'array',
        'created_at' => 'date: M Y',
        'latitude' => 'double',
        'longtitude' => 'double',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function favourite()
    {
        return $this->belongsTo('App\Models\Favourite');
    }


}
