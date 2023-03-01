<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\Order;

class AnalysisController extends Controller
{
    
    
    public function index() 
    {
        return Inertia::render('Analysis');
    }



    // function decile() {
    //     $startDate = '2022-01-01';
    //     $endDate   = '2022-01-31';

    //     $subQuery = Order::betweenDate($startDate, $endDate)
    //     ->where('status', true)
    //     ->groupBy('id')
    //     ->selectRaw('id,
    //                 customer_id,
    //                 customer_name,
    //                 SUM(subtotal) as totalPerPurchase');
                  
    //     $subQuery = DB::table($subQuery)
    //     ->groupBy('customer_id')
    //     ->selectRaw('customer_id,
    //                 customer_name,
    //                 SUM(totalPerPurchase) as total')
    //     ->orderBy('total', 'desc');


    //     /**
    //      * 購入順に連番を設定する
    //      */
    //     DB::statement('set @row_num = 0;');
    //     $subQuery = DB::table($subQuery)
    //     ->selectRaw('
    //     @row_num := @row_num+1 as row_num,
    //     customer_id,
    //     customer_name,
    //     total');

    //     /**
    //      * 全体の数を数えて、1/10の値や合計を取得
    //      */
    //     $count = DB::table($subQuery)->count();
    //     $total = DB::table($subQuery)->selectRaw('sum(total) as total')->get();
    //     $total = $total[0]->total;

    //     $decile = ceil($count / 10);

    //     $bindValues = [];
    //     $tempValue = 0;
    //     for($i = 1; $i <= 10; $i++)
    //     {
    //         array_push($bindValues, 1 + $tempValue);
    //         $tempValue += $decile;
    //         array_push($bindValues, 1 + $tempValue);
    //     }

    //     /**
    //      * 10分割しグループ毎に数字を設定する
    //      */
    //     DB::statement('set @row_num = 0;');
    //     $subQuery = DB::table($subQuery)
    //     ->selectRaw("
    //     row_num,
    //     customer_id,
    //     customer_name,
    //     total,
    //     CASE
    //         WHEN ? <= row_num AND row_num < ? THEN 1
    //         WHEN ? <= row_num AND row_num < ? THEN 2
    //         WHEN ? <= row_num AND row_num < ? THEN 3
    //         WHEN ? <= row_num AND row_num < ? THEN 4
    //         WHEN ? <= row_num AND row_num < ? THEN 5
    //         WHEN ? <= row_num AND row_num < ? THEN 6
    //         WHEN ? <= row_num AND row_num < ? THEN 7
    //         WHEN ? <= row_num AND row_num < ? THEN 8
    //         WHEN ? <= row_num AND row_num < ? THEN 9
    //         WHEN ? <= row_num AND row_num < ? THEN 10
    //         ELSE NULL END as decile

    //      /**
    //       * グループ毎の合計、平均
    //       */
    //     $subQuery = DB::table($subQuery)
    //     ->groupBy('decile')
    //     ->selectRaw('
    //     decile,
    //     round(avg(total)) as average,
    //     sum(total) as totalPerGroup');

    //     /**
    //      * 構成比
    //      */
    //     DB::statement("set @total = ${total} ;");
    //     $data = DB::table($subQuery)
    //     ->selectRaw('
    //     decile,
    //     average,
    //     totalPerGroup,
    //     round(100 * totalPerGroup / @total, 1) as totalRatio')
    //     ->get();

    //     // dd($data);
    // }
}