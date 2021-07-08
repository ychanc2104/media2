<?php

namespace App\Http\Controllers\AdKey;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class AdKeyController extends Controller
{
    public function index(){

        return view('ad_demo');
    }



    public static function render_ad_url(Request $inputData)
    {

        $title = $inputData->input('title');
        // $title = '協助促成口罩外交 趙怡翔告別華府返台 - 政治';

        $query = "SELECT meta_title, web_id, keyword_ad FROM NewsTitleKeyword WHERE meta_title='$title'";

        $keyword_data = DB::connection('ad_record')->select($query)[0];

        $ad_id = explode('_', $keyword_data->keyword_ad)[0]; //get id of ad
        $keyword = explode('_', $keyword_data->keyword_ad)[1];
        // dd($ad_id);
        
        $query = "SELECT url FROM banner_data WHERE list_id='$ad_id' AND banner_status=1";

        $url = DB::connection('crescent_hodo')->select($query)[0]->url;


        return json_encode([$url, $keyword]);

    }


}
