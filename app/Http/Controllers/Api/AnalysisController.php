<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Services\AnalysisService;


class AnalysisController extends Controller
{
    public function index(Request $request)
    {

        $subQuery = Order::betweenDate($request->startDate,
                                       $request->endDate);
                                       
        list($data, $labels, $totals) = AnalysisService::perDate($subQuery, $request->type);

        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' => $labels,
            'totals' => $totals,
        ], Response::HTTP_OK);
    }
}
