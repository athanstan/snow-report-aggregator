<?php

namespace App\Models;

use App\Enums\SnowReportStatusString;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnowReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'status',
        'open_lifts',
        'total_lifts',
        'updated_at'
    ];

    protected $casts = [
        'status' => SnowReportStatusString::class,
    ];
}
