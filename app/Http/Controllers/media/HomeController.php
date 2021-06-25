<?php

namespace App\Http\Controllers\media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Libraries\GetData;


class HomeController extends Controller
{
    public function show() 
    {
        // $media_data = DB::select('SELECT * FROM media_data');
        $query = 'SELECT * FROM lkr_media';
        $media_data = DB::connection('test_media')->select($query);
        foreach ($media_data as $data) {
            $data->total_click = $data->direct_click + $data->clip_click;
            $data->click_rate = 100*$data->total_click/$data->impression;
        }

        return view('media.home', [
            'media_data'=>$media_data
        ]);
    }

    // use for transmitting to certain page and read by ajax
    public function transmit_chart_data() 
    {
        $chart_data = GetData::get_chart_data();

        return json_encode($chart_data);
    }


    public function transmit_total_data() 
    {
        $total_data = GetData::get_total_data();

        return json_encode($total_data);
    }

}
