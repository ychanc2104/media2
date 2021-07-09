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
        //// input parameters
        //// media should input two parameters
        $title = $inputData->input('title');
        $web_id = $inputData->input('web_id');
        // $uuid = $inputData->input('uuid');

        $query = "SELECT meta_title, web_id, keyword_ad FROM NewsTitleKeyword WHERE meta_title='$title'";

        // choose index 0, one title map to one keyword_ad
        $keyword_data = DB::connection('ad_record')->select($query)[0];

        $ad_id = explode('_', $keyword_data->keyword_ad)[0]; //get id(banner_id without _n) of ad
        $keyword = explode('_', $keyword_data->keyword_ad)[1]; // keyword
        $web_id_backup = $keyword_data->web_id;
        // $ad_id = 'adhub20191031524906';
        
        $query = "SELECT id, url FROM banner_data WHERE list_id='$ad_id' AND banner_status=1";

        // maybe get many urls, random choose one to put
        $id_url_data = DB::connection('crescent_hodo')->select($query);
        $index_to_pick = (int)rand(0,count($id_url_data)-1);

        $url = $id_url_data[$index_to_pick]->url;
        $pre_banner_id = $id_url_data[$index_to_pick]->id;

        //// collect data /usr/share/nginx/html/pushServer/redirect/redirect_click.php need
        //// 10 slots in total, avivid_data = [push_type, web_id, category_id, user_id, url, banner_id, time_stamp, action, is_clip, cust_push_id]
        $push_type = 1; // cluster_news_page
        $web_id = ($inputData->input('web_id')!==null? $inputData->input('web_id') : $web_id_backup); // input by media
        $category_id = 0;
        $user_id = 0;
        $url = urlencode($url);
        $banner_id = $pre_banner_id.'_'.$keyword;
        $time_stamp = 0; // not used in redirect_click.php
        $action = 'default';
        $is_clip = 10; // what type of source
        $cust_push_id = '0'; // unknown
        $avivid_data = (string)$push_type.','.(string)$web_id.','.(string)$category_id.','.(string)$user_id.','
                        .(string)$url.','.(string)$banner_id.','.(string)$time_stamp.','.(string)$action.','
                        .(string)$is_clip.','.$cust_push_id;
        // input parameter for redirect_click.php API
        $avivid_code = base64_encode((string)$avivid_data);
        // dd($banner_id);
        $render_url = 'https://clk-satellite.advividnetwork.com/pushServer/redirect/redirect_click.php?avivid_code='.$avivid_code;


        return json_encode([$render_url, $keyword]);

    }


}
