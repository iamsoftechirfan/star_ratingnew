<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable=[
                'name',
                'email',
                'search_item',
                'place_name',
                'formatted_address',
                'place_id',
                'types',
                'rating',
                'rating_stats',
                'lat',
                'lng',
                'negative_reviews_count',
                'reviews',
                'created_at',
                'updated_at'
    ];
}
