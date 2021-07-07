<?php

namespace App\Http\Controllers\media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Libraries\GetData;


class DailyReportController extends Controller
{
    public function daily_report() 
    {

        return view('media.daily_report');
    }

    public function transmit_daily_report(Request $inputData) 
    {
        $y_start = $inputData->input('y_start');
        $y_end = $inputData->input('y_end');
        $m_start = $inputData->input('m_start');
        $m_end = $inputData->input('m_end');
        $n_option = $inputData->input('n_option'); // how many rows per page
        $page = $inputData->input('page');

        $daily_data = GetData::get_daily_data($y_start, $y_end, $m_start, $m_end);
        
        // $daily_data = GetData::get_daily_data('2021','2021','1','5');
        $n_data = count($daily_data['date']);
        $daily_data_page = GetData::paginator($daily_data, $page, $n_option, $n_data);
        return json_encode([$daily_data_page, $n_data]);
    }
}
