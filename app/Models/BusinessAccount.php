<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAccount extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
       /* 'user_id',
        'business_id',
        "business_name",
        "business_descripition",
        "opening_time",
        "closing_time",
        "email",
        "phone",
        "business_category",
        "business_sub_category",
        "full_address",
        "house_no",
        "postal_code",
        "city_or_town",
        "county_locality",
        "country_nation",
        "latitude",
        "longtitude",
        "active_days",
        
    */];

    protected $hidden = [
        'business_account_id',
        'business_category',
        'user_id',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'active_days' => 'array',
        'created_at' => 'date: M Y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
