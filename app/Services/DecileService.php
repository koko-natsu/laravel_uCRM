<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DecileService {

  public static function decile($subQuery)
  {
    $subQuery = $subQuery->where('status', true)
    ->groupBy('id')
    ->selectRaw('id,
                customer_id,
                customer_name,
                SUM(subtotal) as totalPerPurchase');
    /**
     * FIXME:
     * group_byしたテーブルに集計関数とcustomer_id以外のデータが
     * 入っているため、エラーとなるので、
     * database.php 'mysql' => [ 'strict' => false ]
     * に変更し厳格ではなくしている。クエリを修正する必要がある。
     */
    $subQuery = DB::table($subQuery)
    ->groupBy('customer_id')
    ->selectRaw('customer_id,
                customer_name,
                SUM(totalPerPurchase) as total')
    ->orderBy('total', 'desc');


    /**
     * 購入順に連番を設定する
     */
    DB::statement('set @row_num = 0;');
    $subQuery = DB::table($subQuery)
    ->selectRaw('
    @row_num := @row_num+1 as row_num,
    customer_id,
    customer_name,
    total');

    /**
     * 全体の数を数えて、1/10の値や合計を取得
     */
    $count = DB::table($subQuery)->count();
    $total = DB::table($subQuery)->selectRaw('sum(total) as total')->get();
    $total = $total[0]->total;

    $decile = ceil($count / 10);

    $bindValues = [];
    $tempValue = 0;
    for($i = 1; $i <= 10; $i++)
    {
        array_push($bindValues, 1 + $tempValue);
        $tempValue += $decile;
        array_push($bindValues, 1 + $tempValue);
    }

    /**
     * 10分割しグループ毎に数字を設定する
     */
    DB::statement('set @row_num = 0;');
    $subQuery = DB::table($subQuery)
    ->selectRaw("
    row_num,
    customer_id,
    customer_name,
    total,
    CASE
        WHEN ? <= row_num AND row_num < ? THEN 1
        WHEN ? <= row_num AND row_num < ? THEN 2
        WHEN ? <= row_num AND row_num < ? THEN 3
        WHEN ? <= row_num AND row_num < ? THEN 4
        WHEN ? <= row_num AND row_num < ? THEN 5
        WHEN ? <= row_num AND row_num < ? THEN 6
        WHEN ? <= row_num AND row_num < ? THEN 7
        WHEN ? <= row_num AND row_num < ? THEN 8
        WHEN ? <= row_num AND row_num < ? THEN 9
        WHEN ? <= row_num AND row_num < ? THEN 10
        ELSE NULL END as decile
        ", $bindValues);

    /**
     * NOTE: 
     * 10分割でグループ分けするが、境界線の金額が同一の場合の処理が必要
     * なのではないか。
     * TODO:
     * ntileを使用するクエリに変更する
     */

      /**
      * グループ毎の合計、平均
      */
    $subQuery = DB::table($subQuery)
    ->groupBy('decile')
    ->selectRaw('
    decile,
    round(avg(total)) as average,
    sum(total) as totalPerGroup');

    /**
     * 構成比
     */
    DB::statement("set @total = ${total} ;");
    $data = DB::table($subQuery)
    ->selectRaw('
    decile,
    average,
    totalPerGroup,
    round(100 * totalPerGroup / @total, 1) as totalRatio')
    ->get();

    $labels = $data->pluck('decile');
    $totals = $data->pluck('totalPerGroup');

    return [$data, $labels, $totals];
  }
}