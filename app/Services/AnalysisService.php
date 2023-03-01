<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AnalysisService {

  public static function perDate($subQuery, $type) 
  {
    $return_value = match($type) {
      'perDay'   => "%Y%m%d",
      'perMonth' => "%Y%m",
      'perYear'  => "%Y",
      /** 
       * TODO:
       * Errorの対処
       */
    };

    $query = $subQuery->where('status', true)
    ->groupBy('id')
    ->selectRaw('id,
                SUM(subtotal) as totalPerPurchase,
                DATE_FORMAT(created_at, ?) as date', [$return_value]);

    $data = DB::table($query)
    ->groupBy('date')
    ->selectRaw('date, 
                sum(totalPerPurchase) as total')
    ->get();

    $labels = $data->pluck('date');
    $totals = $data->pluck('total');

    return [$data, $labels, $totals];
  }


}

?>