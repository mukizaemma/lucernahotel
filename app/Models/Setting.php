<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table ='settings';    

    protected $fillable =[
        'company',
        'address',
        'email',
        'phone',
        'reception_phone',
        'manager_phone',
        'restaurant_phone',
        'logo',
        'deliveryInfo',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'linkedin',
        'linktree',
        'quote',
        'google_map_embed',
        'star_rating',
    ];

    protected $casts = [
        'star_rating' => 'integer',
    ];
}
