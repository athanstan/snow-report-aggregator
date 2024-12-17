<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SnowReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainDataController extends Controller
{
    public function __invoke(Request $request)
    {
        $SnowReports = Cache::remember('snow_reports', 60 * 60, function () {
            return SnowReport::all();
        });

        return response()->json($SnowReports);
    }
}
