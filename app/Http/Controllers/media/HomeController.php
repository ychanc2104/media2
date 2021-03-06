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
        return view('media/home');
    }

    // use for transmitting to certain page and read by ajax
    public function transmit_chart_total_data(Request $inputData)
    {
        $select_mode = $inputData->input('select_mode');
        $year = $inputData->input('year');
        $month = $inputData->input('month');
        $chart_data = GetData::get_chart_data($select_mode, $year, $month);
        $total_data = GetData::get_total_data($select_mode, $year, $month);
        // dd($total_data);
        // $year_smallest = GetData::get_year_smallest();
        // array_merge($total_data, $year_smallest);
        // dd($year_smallest);
        
        // $total_data->year_smallest = ['year'=>2000];
        // dd($total_data);
        // $total_data->year_search = strval($year);
        // $total_data->month_search = strval($month);
        // $total_data->select_mode = $select_mode;
        return json_encode([$chart_data, $total_data]);// return[0]: chart_data, return[0]: total_data

    }




}
