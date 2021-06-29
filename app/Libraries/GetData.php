<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;


class GetData
{
    // for four Google Charts
    public static function get_chart_data($select_mode, $year, $month) 
    {
        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {
            // $query = "SELECT * FROM `lkr_media` WHERE YEAR(date_time)=:year GROUP BY MONTH(date_time)";
            $query = "SELECT date_time, SUM(profit) AS profit, SUM(impression) AS impression, SUM(direct_click) AS direct_click, 
                    SUM(clip_click) AS clip_click, SUM(clip_click+direct_click) AS clicks, 
                    SUM(clip_click+direct_click)/SUM(impression) AS click_rate FROM `lkr_media` 
                    WHERE YEAR(date_time)=:year GROUP BY MONTH(date_time);";
            $media_data = DB::connection('test_media')->select($query, ['year' => $year]);
            $chart_data = self::compute_chart_data($select_mode, $media_data);

        }
        // month case
        else if ($select_mode == "month")
        {
            $query = "SELECT * FROM `lkr_media` WHERE YEAR(date_time)=$year AND MONTH(date_time)=$month";
            $media_data = DB::connection('test_media')->select(DB::raw($query));
            $chart_data = self::compute_chart_data($select_mode, $media_data);
        }
        // default case for showing latest 7 days
        else 
        {
            $query = "SELECT date_time, profit as profit, impression as impression, direct_click as direct_click, 
                     clip_click as clip_click, (direct_click+clip_click) as clicks, 100*(direct_click+clip_click)/impression as click_rate
                     FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 day) AND CURDATE()";
            $media_data = DB::connection('test_media')->select($query);
            $chart_data = self::compute_chart_data($select_mode, $media_data);

        }

        return $chart_data;
        
    }
    // for four statistical values
    public static function get_total_data($select_mode, $year, $month) 
    {
        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {

            $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
                    SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
                    FROM lkr_media WHERE YEAR(date_time) =:year";

            $total_data = DB::connection('test_media')->select($query, ['year' => $year]);
        }
        // month case
        else if ($select_mode == "month")
        {
            $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
                    SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
                    FROM lkr_media WHERE YEAR(date_time) =:year AND MONTH(date_time)=:month";

            $total_data = DB::connection('test_media')->select($query, ['year' => $year, 'month' => $month]);
        }

        // default case for showing latest 7 days
        else 
        {
            $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
            SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
            FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE()";

            $total_data = DB::connection('test_media')->select($query); // size of (1,1) array
        }
        return $total_data[0];
    }

    // For rendering all years in DB
    public static function get_year_smallest() 
    {
        $query = "SELECT MIN(YEAR(date_time)) as year_smallest FROM lkr_media";
        $query_data = DB::connection('test_media')->select($query); // size of (1,1) array
        $year_smallest = $query_data[0]->year_smallest;
        return $year_smallest;
    }

    // Make data from SQL query structurize
    public static function compute_chart_data($select_mode, $media_data) 
    {
        $x_axis = [];
        // array to show (four charts)
        $profit = [];
        $impression = [];
        $direct_click = $clip_click = $clicks = [];
        $click_rate = [];
        $i = 0;
        foreach ($media_data as $data) {
            // x-axis of chart
            // year case
            if ($select_mode == "year")
            {
                $x_axis[] = date("m", strtotime($data->date_time));
            }
            else if ($select_mode == "month")
            {
                $x_axis[] = date("d", strtotime($data->date_time));
            }
            // default is shown latest 7 days
            else
            {
                $x_axis[] = date("d", strtotime($data->date_time));

            }
            // y-axis of chart
            $profit[] = (int)$data->profit;
            $impression[] = (int)$data->impression;
            $direct_click[] = (int)$data->direct_click;
            $clip_click[] = (int)$data->clip_click;
            $clicks[] = $data->direct_click + $data->clip_click;
            $click_rate[] = round(100*$clicks[$i]/$impression[$i], 3);

            // counter
            $i += 1;
        }

        $chart_data = array('x_axis'=>$x_axis, 'profit'=>$profit, 'impression'=>$impression, 
                        'direct_click'=>$direct_click, 'clip_click'=>$clip_click, 'clicks'=>$clicks,
                        'click_rate'=>$click_rate);
        return $chart_data;

    }

}
