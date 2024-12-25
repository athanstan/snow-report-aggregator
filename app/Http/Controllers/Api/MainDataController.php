<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SnowReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainDataController extends Controller
{
    public function index(Request $request)
    {
        $SnowReports = Cache::remember('snow_reports', 60 * 60, function () {
            return SnowReport::all();
        });

        return response()->json($SnowReports);
    }

    public function show(Request $request, int $id)
    {
        $SnowReport = Cache::remember('snow_report_' . $id, 60 * 60, function () use ($id) {
            return SnowReport::findOrFail($id);
        });

        return response()->json($SnowReport);
    }
}
