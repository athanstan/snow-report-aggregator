<?php

namespace App\Models;

use App\Enums\SnowReportLiftStatusString;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
        'capacity',
        'snow_report_id',
        'updated_at'
    ];

    protected $casts = [
        'status' => SnowReportLiftStatusString::class,
    ];
}
