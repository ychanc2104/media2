<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;


class GetData
{    
    // for daily report
    public static function get_daily_data($y_start, $y_end, $m_start, $m_end) 
    {
        $date_start_str = $y_start."-".$m_start."-"."1";
        $date_end_str = $y_end."-".$m_end."-"."1";

        $date_start = date('Y-m-d',strtotime($date_start_str));
        $date_end = date('Y-m-t',strtotime($date_end_str)); // ending day of a month
        
        // $date_start = date('Y-m-d', strtotime('2021-01-01'));
        // $date_end = date('Y-m-d', strtotime('2021-05-01'));

        // $query = "SELECT * FROM (SELECT  ROW_NUMBER() OVER (ORDER BY date_time) AS row_num, date_time, profit, impression, direct_click, clip_click, (direct_click+clip_click) AS clicks, 100*(direct_click+clip_click)/impression AS click_rate FROM `lkr_media`) AS newtable
        // WHERE row_num BETWEEN 1 AND 20";

        // $query = "SELECT * FROM `lkr_media` WHERE date_time BETWEEN '$date_start' AND '$date_end' ORDER BY date_time";
        $query = "SELECT DATE(date_time) AS date, profit, impression, direct_click, clip_click, (direct_click+clip_click) AS clicks, 100*(direct_click+clip_click)/impression AS click_rate FROM `lkr_media` WHERE date_time BETWEEN '$date_start' AND '$date_end' ORDER BY date_time";
        // $query = "SELECT * FROM `lkr_media` WHERE date_time BETWEEN '2021-01-01' AND '2021-05-01' ORDER BY date_time";
        // $query = "SELECT date_time, profit, impression, direct_click, clip_click, (direct_click+clip_click) AS clicks, 100*(direct_click+clip_click)/impression AS click_rate FROM `lkr_media` WHERE date_time BETWEEN '2021-01-01' AND '2021-05-01' ORDER BY date_time";

        $media_data = DB::connection('test_media')->select(DB::raw($query));
        $daily_data = self::compute_daily_data($media_data);
        // dd($daily_data_page);


        return $daily_data;
    }
        

    // for four Google Charts
    public static function get_chart_data($select_mode, $year, $month) 
    {
        $web_id = 'upmedia';
        // $select_mode=1.'default', 2.'year', 3.'month'
        if ($select_mode == "year")
        {
            
            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, SUM(profit) AS profit, SUM(impression) AS impression, SUM(click) as clicks
                        FROM dsp_likrPush_report_daily WHERE YEAR(log_date)='$year' AND web_id='$web_id' GROUP BY month";
            $media_data_1 = DB::connection('crescent_media')->select($query_1);

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, SUM(pay) AS profit, SUM(impression) AS impression, 
                        SUM(clip_click) AS clip_click, SUM(direct_click) AS direct_click, SUM(click) as clicks
                        FROM daily_report_real WHERE YEAR(date_time)='$year' AND web_id='$web_id' GROUP BY MONTH(date_time)";
            $media_data_2 = DB::connection('crescent_media')->select($query_2);

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE YEAR(data_time)='$year' AND web_id='$web_id' GROUP BY MONTH(data_time)";
            $media_data_3 = DB::connection('crescent_ad_host')->select($query_3);

            // merge all array
            $media_data = array_merge($media_data_1, $media_data_2, $media_data_3);
            $chart_data = self::compute_chart_data($select_mode, $media_data);
            // dd($chart_data);

        }
        // month case
        else if ($select_mode == "month")
        {

            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, profit, impression, click as clicks FROM dsp_likrPush_report_daily 
            WHERE YEAR(log_date)='$year' AND MONTH(log_date)='$month' AND web_id='$web_id'";
            $media_data_1 = DB::connection('crescent_media')->select($query_1);

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, pay AS profit, impression, clip_click, direct_click, click as clicks
                        FROM daily_report_real WHERE YEAR(date_time)='$year' AND MONTH(date_time)='$month' AND web_id='$web_id'";
            $media_data_2 = DB::connection('crescent_media')->select($query_2);

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, revenue AS profit FROM streaming_profit_daily_report 
                        WHERE YEAR(data_time)='$year' AND MONTH(data_time)='$month' AND web_id='$web_id'";
            $media_data_3 = DB::connection('crescent_ad_host')->select($query_3);

            // merge all array
            $media_data = array_merge($media_data_1, $media_data_2, $media_data_3);
            $chart_data = self::compute_chart_data($select_mode, $media_data);
            // dd($chart_data);

        }
        // default case for showing latest 7 days
        else 
        {
            // $query = "SELECT date_time, profit as profit, impression as impression, direct_click as direct_click, 
            //          clip_click as clip_click, (direct_click+clip_click) as clicks, 100*(direct_click+clip_click)/impression as click_rate
            //          FROM lkr_media WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 day) AND CURDATE()";
            // $media_data = DB::connection('test_media')->select($query);
            // $chart_data = self::compute_chart_data($select_mode, $media_data);


            // dsp_likrPush_report_daily from crescent_media
            $query_1 = "SELECT log_date AS date_time, profit, impression, click as clicks FROM dsp_likrPush_report_daily 
                        WHERE log_date BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 day) AND CURDATE() AND web_id='$web_id'";
            $media_data_1 = DB::connection('crescent_media')->select($query_1);
            // dd($media_data_1);

            // daily report real from crescent_media
            $query_2 = "SELECT date_time, pay AS profit, impression, clip_click, direct_click, click as clicks
                        FROM daily_report_real WHERE date_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 day) AND CURDATE() AND web_id='$web_id'";
            $media_data_2 = DB::connection('crescent_media')->select($query_2);

            // streaming daily report from crescent_ad_host
            $query_3 = "SELECT data_time AS date_time, SUM(revenue) AS profit FROM streaming_profit_daily_report 
                        WHERE data_time BETWEEN DATE_ADD(CURDATE(), INTERVAL -6 day) AND CURDATE() AND web_id='$web_id' group by day(data_time)";
            $media_data_3 = DB::connection('crescent_ad_host')->select($query_3);

            $media_data = array_merge($media_data_1, $media_data_2, $media_data_3);

            $chart_data = self::compute_chart_data($select_mode, $media_data);

        }
        // dd($chart_data);
        return $chart_data;
        
    }
    // for four statistical values
    public static function get_total_data($select_mode, $year, $month) 
    {
        $web_id = 'upmedia';

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
        
            // $total_data_all = array_merge($total_data_1, $total_data_2, $total_data_3);

            // $total_profit = $total_impression = $total_click = $total_click_rate = 0;
            
            // foreach ($total_data_all as $data)
            // {
            //     $total_profit += (isset($data->profit)? (int)$data->profit : 0); // add zero, if data not existing
            //     $total_impression += (isset($data->impression)? (int)$data->impression : 0); // add zero, if data not existing
            //     $total_click += (isset($data->clicks)? (int)$data->clicks : 0); // add zero, if data not existing
            // }
            // $total_click_rate = number_format(round(100*$total_click/$total_impression, 3), 3) . '%';

            // dd($total_data);
            

            // dd($total_data);

            // $query = "SELECT SUM(profit) as total_profit, SUM(impression) as total_impression, 
            //         SUM(direct_click+clip_click) as total_click, 100*SUM(direct_click+clip_click)/SUM(impression) as total_click_rate
            //         FROM lkr_media WHERE YEAR(date_time) =:year";

            // $total_data = DB::connection('test_media')->select($query, ['year' => $year]);
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


        $total_data_all = array_merge($total_data_1, $total_data_2, $total_data_3);

        $total_profit = $total_impression = $total_click = $total_click_rate = 0;
            
        foreach ($total_data_all as $data)
        {
            $total_profit += (isset($data->profit)? (int)$data->profit : 0); // add zero, if data not existing
            $total_impression += (isset($data->impression)? (int)$data->impression : 0); // add zero, if data not existing
            $total_click += (isset($data->clicks)? (int)$data->clicks : 0); // add zero, if data not existing
        }
        $total_click_rate = number_format(round(100*$total_click/$total_impression, 3), 3) . '%';


        $year_smallest = self::get_year_smallest();

        $total_data = array('total_profit'=>$total_profit, 'total_impression'=>$total_impression,
                            'total_click'=>$total_click, 'total_click_rate'=>$total_click_rate, 
                            'year_smallest'=>$year_smallest);

        return $total_data;
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
        // dd($year_smallest_1[0]);
        $year_smallest = min($year_smallest_1, $year_smallest_2, $year_smallest_3)[0]->year_smallest;
        // dd($year_smallest);

        return $year_smallest;
    }

    public static function remove_zero($x)
    {
        return ($x !== 0);
    }  

    // Make data from SQL query more structurized
    public static function compute_chart_data($select_mode, $media_data) 
    {
        switch($select_mode)
        {
            case 'year':
                $x_lim = 12;
                $symbol = 'm';
                break;
            case 'month':
                $x_lim = (int)date("t", strtotime($media_data[0]->date_time));
                $symbol = 'd';
                break;
            default:
                $x_lim = 31;
                $symbol = 'd';
        }
        // $x_lim = 12;
        $x_axis = array_fill(0,$x_lim, 0);
        // $month = array_fill(0,12, 0);
        $profit = $impression = $clip_click = array_fill(0,$x_lim, 0);
        $direct_click = $clicks = $click_rate = array_fill(0,$x_lim, 0);
        foreach ($media_data as $data)
        {
            // choose index to be added according to its month or day.
            $index = (int)date($symbol, strtotime($data->date_time))-1;
            if ($select_mode == 'year'||$select_mode == 'month')
            {
                $x_axis[$index] = $index+1;

            }
            else // 7-day case to prevent 1/31 in front of 7/1, re-order 7-days
            {
                $x_order = (int)date('m', strtotime($data->date_time))*31 + (int)date('d', strtotime($data->date_time));
                $x_axis[$x_order] = $x_axis[$index];
                unset($x_axis[$index]);
                $x_axis[$index] = $index+1;

            }

            $profit[$index] += (int)$data->profit;
            $impression[$index] += (isset($data->impression)? (int)$data->impression : 1); // add 0 if attr not existing
            $clip_click[$index] += (isset($data->clip_click)? (int)$data->clip_click : 1); // add 0 if attr not existing
            $direct_click[$index] += (isset($data->direct_click)? (int)$data->direct_click : 1); // add 0 if attr not existing
            $clicks[$index] += (isset($data->clicks)? (int)$data->clicks : 1); // add 0 if attr not existing
        }

        // bug here
        $x_axis = array_values(array_filter($x_axis,"self::remove_zero"));
        for ($i=0; $i < count($impression); $i++)
        {
            $click_rate[$i] = ($impression[$i] !== 0? 
                                    round(100*$clicks[$i]/$impression[$i],3) 
                                    : 0); // if True, choose front statement
        }

        // dd(array_filter($profit,"self::remove_zero"));
        
        $profit = array_values(array_filter($profit,"self::remove_zero"));
        $impression = array_values(array_filter($impression,"self::remove_zero"));
        $clip_click = array_values(array_filter($clip_click,"self::remove_zero"));
        $direct_click = array_values(array_filter($direct_click,"self::remove_zero"));
        $clicks = array_values(array_filter($clicks,"self::remove_zero"));
        $click_rate = array_values(array_filter($click_rate,"self::remove_zero"));

        $x_axis = array_slice($x_axis,0,count($click_rate));
        $direct_click = array_slice($direct_click,0,count($click_rate));


        $chart_data = array('x_axis'=>$x_axis, 'profit'=>$profit, 'impression'=>$impression, 
        'direct_click'=>$direct_click, 'clip_click'=>$clip_click, 'clicks'=>$clicks,
        'click_rate'=>$click_rate);

        // dd($chart_data);



        // $x_axis = [];
        // // array to show (four charts)
        // $profit = [];
        // $impression = [];
        // $direct_click = $clip_click = $clicks = [];
        // $click_rate = [];
        // $i = 0;
        // foreach ($media_data as $data) {
        //     // x-axis of chart
        //     // year case
        //     if ($select_mode == "year")
        //     {
        //         $x_axis[] = date("m", strtotime($data->date_time));
        //     }
        //     else if ($select_mode == "month")
        //     {
        //         $x_axis[] = date("d", strtotime($data->date_time));
        //     }
        //     // default is shown latest 7 days
        //     else
        //     {
        //         $x_axis[] = date("d", strtotime($data->date_time));

        //     }
        //     // y-axis of chart
        //     $profit[] = (int)$data->profit;
        //     $impression[] = (int)$data->impression;
        //     $direct_click[] = (int)$data->direct_click;
        //     $clip_click[] = (int)$data->clip_click;
        //     $clicks[] = $data->direct_click + $data->clip_click;
        //     $click_rate[] = round(100*$clicks[$i]/$impression[$i], 3);

        //     // counter
        //     $i += 1;
        // }

        // $chart_data = array('x_axis'=>$x_axis, 'profit'=>$profit, 'impression'=>$impression, 
        //                 'direct_click'=>$direct_click, 'clip_click'=>$clip_click, 'clicks'=>$clicks,
        //                 'click_rate'=>$click_rate);
        return $chart_data;

    }


    // Make data from SQL query structurize
    public static function compute_daily_data($daily_data) 
    {
        foreach ($daily_data as $data) {
            // $data->clicks = $data->direct_click + $data->clip_click;
            // $data->click_rate = number_format(round(100*$data->clicks/$data->impression,3),3)."%";
            // $data->date = date("Y-m-d", strtotime($data->date_time));

            $data->click_rate = number_format(round($data->click_rate,3),3)."%";
        }

        return $daily_data;

    }

    // custom-made paginator
    public static function paginator($data, $page, $n_option)
    {
        $n_data = (int)count($data);
        $page = (int)$page;
        
        if ($n_option == 'All' || $n_option == '選擇')
        {
            $n_option = $n_data;
        }
        else
        {
            $n_option = (int)$n_option;
        }

        $n_page = (int)ceil($n_data/$n_option); // total pages

        $index_range = range(($page-1)*$n_option, min($page*$n_option-1, $n_data-1));
        $keys_page = array_combine($index_range, $index_range);// build an array with keys are indexes to be paginate
        $data_page = array_values(array_intersect_key($data, $keys_page)); // get paginated data from index_range, only get value (with bug if not using array_values, keys missing at page1)
        return $data_page;
        
    } 

}
