<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RFMService {

  public static function rfm($subQuery, $rfmPrms)
  {
        /**
         * 購買毎にまとめる
         */
        $subQuery = $subQuery->where('status', true)
        ->groupBy('id')
        ->selectRaw('id,
                    customer_id,
                    customer_name,
                    created_at,
                    SUM(subtotal) as totalPerPurchase');

        /**
         * 会員毎にまとめる 
         */
        $subQuery = DB::table($subQuery)
        ->groupBy('customer_id')
        ->selectRaw('customer_id,
                    customer_name,
                    max(created_at) as recentDate,
                    datediff(now(), max(created_at)) as recency,
                    count(customer_id) as frequency,
                    sum(totalPerPurchase) as monetary');

        /**
         * 会員毎のRFMランクを計算する
         * ]
         */
        $subQuery = DB::table($subQuery)
            ->selectRaw('customer_id,
            customer_name,
            recentDate,
            recency,
            frequency,
            monetary,
        CASE 
            WHEN recency < ? then 5
            WHEN recency < ? then 4
            WHEN recency < ? then 3
            WHEN recency < ? then 2
            ELSE 1 END AS r,
        CASE 
            WHEN ? <= frequency then 5
            WHEN ? <= frequency then 4
            WHEN ? <= frequency then 3
            WHEN ? <= frequency then 2
            ELSE 1 END AS f,
        CASE 
            WHEN ? <= monetary then 5
            WHEN ? <= monetary then 4
            WHEN ? <= monetary then 3
            WHEN ? <= monetary then 2
            ELSE 1 END AS m', $rfmPrms);

        /**
         * ランク毎の数を計算する
         */
        $rCount = DB::table($subQuery)
        ->rightJoin('ranks', 'ranks.rank', '=', 'r')
        ->groupBy('rank')
        ->selectRaw('rank as r, count(r)')
        ->orderBy('r', 'desc')
        ->pluck('count(r)');
        
        $fCount = DB::table($subQuery)
        ->rightJoin('ranks', 'ranks.rank', '=', 'f')
        ->groupBy('rank')
        ->selectRaw('rank as f, count(f)')
        ->orderBy('f', 'desc')
        ->pluck('count(f)');
        
        $mCount = DB::table($subQuery)
        ->rightJoin('ranks', 'ranks.rank', '=', 'm')
        ->groupBy('rank')
        ->selectRaw('rank as m, count(m)')
        ->orderBy('m', 'desc')
        ->pluck('count(m)');
        
        // Log::debug([$rCount, $fCount, $mCount]);

        $eachCount = [];
        $rank = 5;

        for($i = 0; $i < 5; $i++)
        {
            array_push($eachCount, [
                'rank' => $rank,
                'r' => $rCount[$i],
                'f' => $fCount[$i],
                'm' => $mCount[$i]
            ]);
            $rank--;
        }

        /**
         * RとFを二次元で表示する
         */
        $data = DB::table($subQuery)
        ->rightJoin('ranks', 'ranks.rank', '=', 'r')
        ->groupBy('rank')
        ->selectRaw('concat("r_", rank) as rRank,
        count(case when f = 5 then 1 end) as f_5,
        count(case when f = 4 then 1 end) as f_4,
        count(case when f = 3 then 1 end) as f_3,
        count(case when f = 2 then 1 end) as f_2,
        count(case when f = 1 then 1 end) as f_1')
        ->orderBy('rRank', 'desc')
        ->get();

        return [$data, $eachCount];

  }

}

?>