<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;
use Session;


class GetData
{    
    // for daily report
    public static function get_daily_data($y_start, $y_end, $m_start, $m_end) 
    {   
        // get web_id from previous login cookie
        $web_id = Session::get('web_id');
        $date_start_str = $y_start."-".$m_start."-"."1";
        $date_end_str = $y_end."-".$m_end."-"."1";

        $date_start = date('Y-m-d',strtotime($date_start_str));
        $date_end = date('Y-m-t',strtotime($date_end_str)); // ending day of a month

        // dsp_likrPush_report_daily from crescent_media
        $query_1 = "SELECT log_date AS date_time, profit, impression, click as clicks FROM dsp_likrPush_report_daily 
                    WHERE log_date BETWEEN '$date_start' AND '$date_end' AND web_id='$web_id' ORDER BY log_date ASC";

        // daily report real from crescent_media
        $query_2 = "SELECT date_time, pay AS profit, impression, clip_click, direct_click, click as clicks FROM daily_report_real 
                    WHERE date_time BETWEEN '$date_start' AND '$date_end' AND web_id='$web_id' ORDER BY date_time ASC";

        // streaming daily report from crescent_ad_host
        $query_3 = "SELECT data_time AS date_time, revenue AS profit FROM streaming_profit_daily_report 
                    WHERE data_time BETWEEN '$date_start' AND '$date_end' AND web_id='$web_id' ORDER BY data_time ASC";

        $media_data_1 = DB::connection('crescent_media')->select($query_1);
        $media_data_2 = DB::connection('crescent_media')->select($query_2);
        $media_data_3 = DB::connection('crescent_ad_host')->select($query_3);
        $media_data = array_merge($media_data_1, $media_data_2, $media_data_3);

        $daily_data = self::click_rate_to_str(self::compute_chart_data('month', $media_data));

        return $daily_data;
    }
        

    // for four Google Charts
    public static function get_chart_data($select_mode, $year, $month) 
    {
        // $web_id = 'upmedia';
        $web_id = Session::get('web_id');

        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {
            
            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, SUM(profit) AS profit, SUM(impression) AS impression, SUM(click) as clicks
                        FROM dsp_likrPush_report_daily WHERE YEAR(log_date)='$year' AND web_id='$web_id' GROUP BY month";

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, SUM(pay) AS profit, SUM(impression) AS impression, 
                        SUM(clip_click) AS clip_click, SUM(direct_click) AS direct_click, SUM(click) as clicks
                        FROM daily_report_real WHERE YEAR(date_time)='$year' AND web_id='$web_id' GROUP BY MONTH(date_time)";

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE YEAR(data_time)='$year' AND web_id='$web_id' GROUP BY MONTH(data_time)";

        }
        // month case
        else if ($select_mode == "month")
        {

            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, profit, impression, click as clicks FROM dsp_likrPush_report_daily 
            WHERE YEAR(log_date)='$year' AND MONTH(log_date)='$month' AND web_id='$web_id'";

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, pay AS profit, impression, clip_click, direct_click, click as clicks
                        FROM daily_report_real WHERE YEAR(date_time)='$year' AND MONTH(date_time)='$month' AND web_id='$web_id'";

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, revenue AS profit FROM streaming_profit_daily_report 
                        WHERE YEAR(data_time)='$year' AND MONTH(data_time)='$month' AND web_id='$web_id'";

        }
        // default case for showing latest 7 days
        else 
        {
            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, profit, impression, click as clicks FROM dsp_likrPush_report_daily 
                        WHERE log_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE() AND web_id='$web_id'";

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, pay AS profit, impression, clip_click, direct_click, click as clicks
                        FROM daily_report_real WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE() AND web_id='$web_id'";

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE data_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE() AND web_id='$web_id' group by day(data_time)";

        }

        // collect three tables into one table
        $media_data_1 = DB::connection('crescent_media')->select($query_1);
        $media_data_2 = DB::connection('crescent_media')->select($query_2);
        $media_data_3 = DB::connection('crescent_ad_host')->select($query_3);
        $media_data = array_merge($media_data_1, $media_data_2, $media_data_3);
        $chart_data = self::compute_chart_data($select_mode, $media_data);

        // dd($chart_data);
        return $chart_data;
        
    }

    // for four statistical values
    public static function get_total_data($select_mode, $year, $month) 
    {
        // $web_id = 'upmedia';
        $web_id = Session::get('web_id');

        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {
            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, SUM(profit) AS profit, SUM(impression) AS impression, SUM(click) as clicks
            FROM dsp_likrPush_report_daily WHERE YEAR(log_date)='$year' AND web_id='$web_id'";
            $total_data_1 = DB::connection('crescent_media')->select($query_1);

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, SUM(pay) AS profit, SUM(impression) AS impression, 
                        SUM(clip_click) AS clip_click, SUM(direct_click) AS direct_click, SUM(click) as clicks
                        FROM daily_report_real WHERE YEAR(date_time)='$year' AND web_id='$web_id'";
            $total_data_2 = DB::connection('crescent_media')->select($query_2);

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE YEAR(data_time)='$year' AND web_id='$web_id'";
            $total_data_3 = DB::connection('crescent_ad_host')->select($query_3);

        }
        // month case
        else if ($select_mode == "month")
        {
            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, SUM(profit) AS profit, SUM(impression) AS impression, SUM(click) as clicks
            FROM dsp_likrPush_report_daily WHERE YEAR(log_date)='$year' AND MONTH(log_date)='$month' AND web_id='$web_id'";
            $total_data_1 = DB::connection('crescent_media')->select($query_1);

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, SUM(pay) AS profit, SUM(impression) AS impression, 
                        SUM(clip_click) AS clip_click, SUM(direct_click) AS direct_click, SUM(click) as clicks
                        FROM daily_report_real WHERE YEAR(date_time)='$year' AND MONTH(date_time)='$month' AND web_id='$web_id'";
            $total_data_2 = DB::connection('crescent_media')->select($query_2);

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE YEAR(data_time)='$year' AND MONTH(data_time)='$month' AND web_id='$web_id'";
            $total_data_3 = DB::connection('crescent_ad_host')->select($query_3);
        
        }

        // default case for showing latest 7 days
        else 
        {
            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, SUM(profit) AS profit, SUM(impression) AS impression, SUM(click) as clicks
            FROM dsp_likrPush_report_daily WHERE log_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE() AND web_id='$web_id'";
            $total_data_1 = DB::connection('crescent_media')->select($query_1);

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, SUM(pay) AS profit, SUM(impression) AS impression, 
                        SUM(clip_click) AS clip_click, SUM(direct_click) AS direct_click, SUM(click) as clicks
                        FROM daily_report_real WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE() AND web_id='$web_id'";
            $total_data_2 = DB::connection('crescent_media')->select($query_2);

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE data_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -7 day) AND CURDATE() AND web_id='$web_id'";
            $total_data_3 = DB::connection('crescent_ad_host')->select($query_3);

        }

        // connect three tables
        $total_data_all = array_merge($total_data_1, $total_data_2, $total_data_3);

        // collect three tables with same date
        $total_profit = $total_impression = $total_click = $total_click_rate = 0;
        foreach ($total_data_all as $data)
        {
            $total_profit += (isset($data->profit)? (int)$data->profit : 0); // add zero, if data not existing
            $total_impression += (isset($data->impression)? (int)$data->impression : 0); // add zero, if data not existing
            $total_click += (isset($data->clicks)? (int)$data->clicks : 0); // add zero, if data not existing
        }
        $total_click_rate = number_format(round(100*$total_click/$total_impression, 3), 3) . '%';

        // get the smallest year in DB tables
        $year_smallest = self::get_year_smallest();
        // build array
        $total_data = array('total_profit'=>$total_profit, 'total_impression'=>$total_impression,
                            'total_click'=>$total_click, 'total_click_rate'=>$total_click_rate, 
                            'year_smallest'=>$year_smallest);

        return $total_data;
    }



    // Make data from SQL query more structurized
    public static function compute_chart_data($select_mode, $media_data) 
    {
        // in year case, use 'm'(month) to be index, and others use 'd'(day)
        $symbol =($select_mode == 'year'? 'm' : 'd');
        // max index
        $x_lim = 13*31; 
        // number of days in that month
        $n_day_of_month = (int)date("t", strtotime($media_data[0]->date_time));
        // initialize array, max range to be store
        $date = array_fill(0,$x_lim, 0);
        $x_axis = array_fill(0,$x_lim, 0);
        $profit = $impression = $clip_click = array_fill(0,$x_lim, 0);
        $direct_click = $clicks = $click_rate = array_fill(0,$x_lim, 0);
        // collect data
        foreach ($media_data as $data)
        {
            // choose index to be added according to its month or day.
            $day = (int)date('d', strtotime($data->date_time));
            $month = (int)date('m', strtotime($data->date_time));
            if ($select_mode == 'year') // in year case, month is the index
            {
                $index = $month;
            }
            else // in month or 7-days case, (month*n_day_of_month + day) is the index
            {
                $index = $month*$n_day_of_month + $day;
            }

            // add to that key(index) to collect data with same date
            $date[$index] = $data->date_time;
            $x_axis[$index] = (int)date($symbol, strtotime($data->date_time));
            $profit[$index] += (int)$data->profit; // all tables with attr. "profit"
            $impression[$index] += (isset($data->impression)? (int)$data->impression : 0); // add 0 if attr not existing
            $clip_click[$index] += (isset($data->clip_click)? (int)$data->clip_click : 0); // add 0 if attr not existing
            $direct_click[$index] += (isset($data->direct_click)? (int)$data->direct_click : 0); // add 0 if attr not existing
            $clicks[$index] += (isset($data->clicks)? (int)$data->clicks : 0); // add 0 if attr not existing

        }
        // bug here, to be refined, remove 0
        for ($i=0; $i < count($impression); $i++)
        {
            $click_rate[$i] = ($impression[$i] !== 0? 
                                    round(100*$clicks[$i]/$impression[$i],3) 
                                    : 0); // if True, choose front statement
        }

        $date = array_values(array_filter($date,"self::remove_zero"));
        $x_axis = array_values(array_filter($x_axis,"self::remove_zero"));
        $profit = array_values(array_filter($profit,"self::remove_zero"));
        $impression = array_values(array_filter($impression,"self::remove_zero"));
        $clip_click = array_values(array_filter($clip_click,"self::remove_zero"));
        $direct_click = array_values(array_filter($direct_click,"self::remove_zero"));
        $clicks = array_values(array_filter($clicks,"self::remove_zero"));
        $click_rate = array_values(array_filter($click_rate,"self::remove_zero"));

        // $x_axis = array_slice($x_axis,0,count($click_rate));
        // $direct_click = array_slice($direct_click,0,count($click_rate));
        // 

        // build array to be transmitted
        $chart_data = array('date'=>$date, 'x_axis'=>$x_axis, 'profit'=>$profit, 'impression'=>$impression, 
        'direct_click'=>$direct_click, 'clip_click'=>$clip_click, 'clicks'=>$clicks,
        'click_rate'=>$click_rate);

        return $chart_data;

    }


    // Make click_rate in data to be string type with 3 digits
    public static function click_rate_to_str($daily_data) 
    {
        for ($i=0; $i < count($daily_data['date']); $i++) 
        {
            $daily_data['click_rate'][$i] = number_format(round($daily_data['click_rate'][$i], 3), 3)."%";
        }
        return $daily_data;
    }





    // For rendering all years in DB
    public static function get_year_smallest() 
    {
        $web_id = 'upmedia';

        // dsp_likrPush_report_daily from crescent_media
        $query_1 = "SELECT MIN(YEAR(log_date)) as year_smallest FROM dsp_likrPush_report_daily WHERE web_id='$web_id'";
        $year_smallest_1 = DB::connection('crescent_media')->select($query_1);

        // daily report real from crescent_media
        $query_2 = "SELECT MIN(YEAR(date_time)) as year_smallest FROM daily_report_real WHERE web_id='$web_id'";
        $year_smallest_2 = DB::connection('crescent_media')->select($query_2);

        // streaming daily report from crescent_ad_host
        $query_3 = "SELECT MIN(YEAR(data_time)) as year_smallest FROM streaming_profit_daily_report WHERE web_id='$web_id'";
        $year_smallest_3 = DB::connection('crescent_ad_host')->select($query_3);

        $year_smallest = min($year_smallest_1, $year_smallest_2, $year_smallest_3)[0]->year_smallest;

        return $year_smallest;
    }

    // use for array_filter
    public static function remove_zero($x)
    {
        return ($x !== 0);
    }  


    // custom-made paginator
    public static function paginator($data, $page, $n_option, $n_data)
    {
        $page = (int)$page;
        // in All and default case, show all data, otherwise show number of option
        $n_option = ($n_option == 'All' || $n_option == '選擇'? (int)$n_data : (int)$n_option);   

        // get data index to be transmitted
        $n_page = (int)ceil($n_data/$n_option); // total pages
        $index_range = range(($page-1)*$n_option, min($page*$n_option-1, $n_data-1));
        $keys_page = array_combine($index_range, $index_range);// build an array with keys are indexes to be paginate
        
        // $data_page = array_values(array_intersect_key($data, $keys_page)); // get paginated data from index_range, only get value (with bug if not using array_values, keys missing at page1)
        
        // choose data in clicked page and remove keys
        $date = array_values(array_intersect_key($data['date'], $keys_page));
        $profit = array_values(array_intersect_key($data['profit'], $keys_page));
        $impression = array_values(array_intersect_key($data['impression'], $keys_page));
        $clicks = array_values(array_intersect_key($data['clicks'], $keys_page));
        $click_rate = array_values(array_intersect_key($data['click_rate'], $keys_page));
        // build array
        $data_page = array('date'=>$date, 'profit'=>$profit, 'impression'=>$impression, 
                            'clicks'=>$clicks, 'click_rate'=> $click_rate);

        return $data_page;
        
    } 

}
