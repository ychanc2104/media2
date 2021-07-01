<?php

namespace App\Http\Controllers\media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Libraries\GetData;


class HomeController extends Controller
{
    public function home() 
    {

        return view('media.home');
    }

    public function daily_report() 
    {
        // $query_start = $inputData->input('query_start');
        // $query_end = $inputData->input('query_end');

        // $y_start = strval($inputData->input('y_start'));
        // $y_end = strval($inputData->input('y_end'));
        // $m_start = strval($inputData->input('m_start'));
        // $m_end = strval($inputData->input('m_end'));
        // dd($inputData);
        // if ($query_start == null)
        // {
        //     $query_start = [3,2021];
        //     $query_end = [3,2021];
        // }
        // dd($query_end);
        // dd($query_start);
        // $query_start = [1,2021];
        // $query_end = [3,2021];
        // $daily_data = GetData::get_daily_data($y_start, $y_end, $m_start, $m_end);
        // $daily_data = GetData::get_daily_data('2021','2021','1','5');

        // dd($daily_data);
        return view('media.daily_report');
    }

    // use for transmitting to certain page and read by ajax
    public function transmit_chart_total_data(Request $inputData)
    {
        $select_mode = $inputData->input('select_mode');
        $year = $inputData->input('year');
        $month = $inputData->input('month');
        $chart_data = GetData::get_chart_data($select_mode, $year, $month);
        $total_data = GetData::get_total_data($select_mode, $year, $month);
        $year_smallest = GetData::get_year_smallest();
        $total_data->year_smallest = $year_smallest;
        $total_data->year_search = strval($year);
        $total_data->month_search = strval($month);
        $total_data->select_mode = $select_mode;

        // dd($total_data);
        return json_encode([$chart_data, $total_data]);// return[0]: chart_data, return[0]: total_data 
    }



    public function transmit_daily_report(Request $inputData) 
    {
        $y_start = $inputData->input('y_start');
        $y_end = $inputData->input('y_end');
        $m_start = $inputData->input('m_start');
        $m_end = $inputData->input('m_end');
        $n_option = $inputData->input('n_option'); // how many rows per page
        $page = $inputData->input('page');

        // dd($inputData->ajax());
        // if ($y_start == null)
        // {
        //     $y_start = 2021;
        //     $y_end = 2021;
        //     $m_start = 1;
        //     $m_end = 2;
    
        // }
        // dd($query_end);
        // dd($query_start);
        // $query_start = [1,2021];
        // $query_end = [3,2021];
        $daily_data = GetData::get_daily_data($y_start, $y_end, $m_start, $m_end);
        // $daily_data = GetData::get_daily_data('2021','2021','1','5');
        $n_data = count($daily_data);
        // dd(count($daily_data));
        $daily_data_page = GetData::paginator($daily_data, $page, $n_option);
        // dd($daily_data);


        return json_encode([$daily_data_page, $n_data]);
    }
}
?>