<?php

namespace App\Http\Controllers\media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function show()
    {
        $media_data = DB::select('select * from media_data');
        foreach ($media_data as $data) {
            $data->total_clicks = $data->direct_clicks + $data->direct_clicks;
            $data->click_rate = 100*$data->total_clicks/$data->exposures;
        }

        return view('media.home', [
            'media_data'=>$media_data
        ]);
    }

    public function get_chart()
    {
        $media_data = DB::select('select * from media_data');
        $day = [];
        $incomes = [];

        foreach ($media_data as $data) {
            // $month[] = date("m", strtotime($data->Date));
            $day[] = date("d", strtotime($data->Date));

            $incomes[] = $data->incomes;

            // $chart_data->month = date("m", strtotime($data->Date));
            // $chart_data->incomes = $data->incomes;

            // $data->total_clicks = $data->direct_clicks + $data->direct_clicks;
            // $data->click_rate = 100*$data->total_clicks/$data->exposures;
        }
        $chart_data = array('day'=>$day, 'incomes'=>$incomes);

        return json_encode($chart_data);
    }
}
