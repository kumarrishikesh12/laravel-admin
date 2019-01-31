<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'marketplace_id', 'categories', 'created_by', 'created_by',
    ];
}
