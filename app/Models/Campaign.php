<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    const CACHE_PREFIX = "campaigns";

    /**
     * The attributes that are mass assignable
     * 
     * @var string[]
     */
    protected $fillable = [
        'name',
        'to',
        'from',
        'total_budget',
        'daily_budget',
        'creatives'
    ];
    
    /**
     * The attributes that should be cast.
     * 
     * @var array
     */
    protected $casts = [
        'creatives' => 'array'
    ];
}
