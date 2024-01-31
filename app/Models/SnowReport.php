<?php

namespace App\Models;

use App\Enums\SnowReportStatusString;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SnowReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'status',
        'open_lifts',
        'total_lifts',
        'base_snow',
        'mid_snow',
        'top_snow',
        'updated_at'
    ];

    protected $casts = [
        'status' => SnowReportStatusString::class,
    ];

    public function slopes(): HasMany
    {
        return $this->hasMany(Slope::class);
    }

    public function lifts(): HasMany
    {
        return $this->hasMany(Lift::class);
    }
}
