<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;


class GetData
{
    public static function get_chart_data() 
    {
        $query = "SELECT * FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE()";
        $media_data = DB::connection('test_media')->select($query);

        $day = [];
        // array to show (four charts)
        $profit = [];
        $impression = [];
        $direct_click = $indirect_click = $clicks = [];
        $click_rate = [];
        
        $i = 0;
        foreach ($media_data as $data) {
            // x-axis of chart
            $day[] = date("d", strtotime($data->date_time));
            // $month[] = date("m", strtotime($data->Date));

            // y-axis of chart
            $profit[] = $data->profit;
            $impression[] = $data->impression;
            $direct_click[] = $data->direct_click;
            $indirect_click[] = $data->clip_click;
            $clicks[] = $data->direct_click + $data->clip_click;
            $click_rate[] = 100*$impression[$i]/$clicks[$i];

            // counter
            $i += 1;
        }

        $chart_data = array('day'=>$day, 'profit'=>$profit, 'impression'=>$impression, 
                            'direct_click'=>$direct_click, 'indirect_click'=>$indirect_click, 'clicks'=>$clicks,
                            'click_rate'=>$click_rate);


        return $chart_data;
    }

    public static function get_total_data() 
    {
        $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
                SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate 
                FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE()";

        $total_data = DB::connection('test_media')->select($query); // size of (1,1) array

        // return index 0 because the total_data is a array of size(1,1)
        return $total_data[0];
    }



}
