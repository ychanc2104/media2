<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;


class GetData
{
    public static function get_chart_data($select_mode, $year) 
    {
        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {
            console.log('year mode');
            $query = "SELECT * FROM `lkr_media` WHERE YEAR(date_time)=:year GROUP BY MONTH(date_time)";
            $media_data = DB::connection('test_media')->select($query, ['year' => $year]);
            $chart_data = compute_chart_data($select_mode, $media_data);


        }
        else
        {
            $query = "SELECT DAY(date_time) as x_axis, profit as profit, impression as impression, direct_click as direct_click, 
                     clip_click as clip_click, (direct_click+clip_click) as clicks, 100*(direct_click+clip_click)/impression as click_rate
                     FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 day) AND CURDATE()";
            $media_data = DB::connection('test_media')->select($query);
            $chart_data = $media_data;
            // $day = [];
            // // array to show (four charts)
            // $profit = [];
            // $impression = [];
            // $direct_click = $clip_click = $clicks = [];
            // $click_rate = [];
            
            // $i = 0;
            // foreach ($media_data as $data) {
            //     // x-axis of chart
            //     $day[] = date("d", strtotime($data->date_time));
            //     // $month[] = date("m", strtotime($data->Date));

            //     // y-axis of chart
            //     $profit[] = $data->profit;
            //     $impression[] = $data->impression;
            //     $direct_click[] = $data->direct_click;
            //     $clip_click[] = $data->clip_click;
            //     $clicks[] = $data->direct_click + $data->clip_click;
            //     $click_rate[] = round(100*$clicks[$i]/$impression[$i], 3);

            //     // counter
            //     $i += 1;
            // }
        }


        // $chart_data = array('day'=>$day, 'profit'=>$profit, 'impression'=>$impression, 
        //                     'direct_click'=>$direct_click, 'clip_click'=>$clip_click, 'clicks'=>$clicks,
        //                     'click_rate'=>$click_rate);
        // $chart_data = $media_data;


        return $chart_data;
        
    }

    public static function get_total_data($select_mode, $year) 
    {
        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {

            // $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
            //         SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
            //         FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE()";

            // $total_data = DB::connection('test_media')->select($query); // size of (1,1) array


            // $year = 2020;
            // $from = $year-1;
            // $to = $year;
            $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
                    SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
                    FROM lkr_media WHERE YEAR(date_time) =:year";

            $total_data = DB::connection('test_media')->select($query, ['year' => $year]);
            // $total_data[0]->search_year = $year;
            // return index 0 because the total_data is a array of size(1,1)
            // return $total_data[0];
        }
        else
        {
            $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
            SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
            FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE()";

            $total_data = DB::connection('test_media')->select($query); // size of (1,1) array
        }
        return $total_data[0];
    }


    public static function get_year_smallest() 
    {
        // if ($query == "")
        // {
            $query = "SELECT MIN(YEAR(date_time)) as year_smallest FROM lkr_media";
            $query_data = DB::connection('test_media')->select($query); // size of (1,1) array
            $year_smallest = $query_data[0]->year_smallest;
            // return index 0 because the total_data is a array of size(1,1)
            return $year_smallest;
        // }
    }


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
            if ($select_mode == "year")
            {
                $x_axis[] = date("m", strtotime($data->date_time));
            }
            else
            {
                $x_axis[] = date("d", strtotime($data->date_time));
            }
            
            // $month[] = date("m", strtotime($data->Date));

            // y-axis of chart
            $profit[] = $data->profit;
            $impression[] = $data->impression;
            $direct_click[] = $data->direct_click;
            $clip_click[] = $data->clip_click;
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
