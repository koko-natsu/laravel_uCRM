<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Order;


class AnalysisController extends Controller
{
    public function index(Request $request)
    {

        $subQuery = Order::betweenDate($request->startDate, $request->endDate);

        if($request->type === 'perDay')
        {
            $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, SUM(subtotal) as totalPerPurchase,
            DATE_FORMAT(created_at, "%Y%m%d") as date');

            $data = DB::table($subQuery)
            ->groupBy('date')
            ->selectRaw('date, sum(totalPerPurchase) as total')
            ->get();
        }

        return response()->json([
            'data' => $data,
            'tyep' => $request->type,
        ], Response::HTTP_OK);
    }
}
