<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Coordinate;
use Illuminate\Http\Request;
use Log;
use Carbon\Carbon;

class CoordinatesController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request) {
        $minimumDateTime = Carbon::now()->setTimezone('Asia/Singapore')->subHour($request->filter);
        $coordinates = Coordinate::where('created_at', '>=', $minimumDateTime)->get();
        return response()->json($coordinates);
    }

    public function store(Request $request) {
        Coordinate::firstOrCreate([
            'latitude' => round($request->latitude, 2),
            'longitude' => round($request->longitude, 2)
        ]);
        return response()->json(['status' => 'OK']);
    }
}
