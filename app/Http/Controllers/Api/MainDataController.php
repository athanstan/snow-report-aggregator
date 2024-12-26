<?php

namespace App\Http\Controllers\Api;

use App\Enums\SnowReportLiftStatus;
use App\Http\Controllers\Controller;
use App\Models\SnowReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainDataController extends Controller
{
    public function index(Request $request)
    {
        $SnowReports = Cache::remember('snow_reports', 60 * 60, function () {
            return SnowReport::withCount([
                'slopes as total_slopes_count',
                'slopes as open_slopes_count' => fn($query) => $query->where('status', SnowReportLiftStatus::OPEN->toStatusString()),
            ])->get();
        });

        return response()->json($SnowReports);
    }

    public function show(Request $request, int $id)
    {
        $SnowReport = Cache::remember('snow_report_' . $id, 60 * 60, function () use ($id) {
            return SnowReport::withCount([
                'slopes as total_slopes_count',
                'slopes as open_slopes_count' => fn($query) => $query->where('status', SnowReportLiftStatus::OPEN->toStatusString()),
            ])->findOrFail($id);
        });

        return response()->json($SnowReport);
    }
}
