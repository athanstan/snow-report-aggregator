<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnowReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'color',
        'open_lifts',
        'total_lifts',
    ];
}
