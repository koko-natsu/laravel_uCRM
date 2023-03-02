<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Services\AnalysisService;
use App\Services\DecileService;
use App\Services\RFMService;



class AnalysisController extends Controller
{
    public function index(Request $request)
    {

        $subQuery = Order::betweenDate($request->startDate,
                                       $request->endDate);
        
        if($request->type === 'decile')
        {
            list($data, $labels, $totals) = DecileService::decile($subQuery);
        } 
        elseif($request->type === 'rfm')
        {
            list($data, $eachCount) = RFMService::rfm($subQuery, $request->rfmPrms);
            
            return response()->json([
                'data' => $data,
                'eachCount' => $eachCount,
            ], Response::HTTP_OK);
        }
         else 
        {
            list($data, $labels, $totals) = AnalysisService::perDate($subQuery, $request->type);
        }

        return response()->json([
            'data' => $data,
            'labels' => $labels,
            'totals' => $totals,
        ], Response::HTTP_OK);
    }
}


?>