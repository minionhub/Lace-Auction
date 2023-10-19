<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'keywords' => 'object',
        'others_info' => 'object',
        'images' => 'object'
    ];

    //Scopes
    public function scopeRunning($query)
    {
        return $query->where('start_date', '<', now())->where('end_date', '>', now())->where('status',1);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now())->where('end_date', '>', now())->where('status',1);
    }

    public function scopeExpired($query)
    {
        return $query->where('start_date', '<', now())->where('end_date', '<', now())->where('status',1);
    }

    public function scopeBidCompleted($query)
    {
        return $query->where('bid_complete', 1)->where('status',1);
    }

    // Relations
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault();
    }

    public function bids()
    {
        return $this->hasMany(Bid::class)->with('user');
    }

    public function winner()
    {
        return $this->belongsTo(Winner::class)->withDefault();
    }

    //Custom
    public function userBidExist()
    {
        return $this->bids()->where('user_id', auth()->id())->first();
    }
}
