
<?php

    include '/var/www/html/likr_library/DBHelper.php';

    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods:POST, GET');  
    header("Access-Control-Allow-Headers: Origin, Methods, Content-Type");
    header('Access-Control-Allow-Credentials: True');

    // lacking default ad
    echo render_ad_url();

    function render_ad_url()
    {
        //// input parameter, title, web_id, current_url and uuid(optional)
        // $data = array(
        //     'keyword' => '',
        //     'url'     => '',
        // );
        // check Authority first
        if (isset($_POST['web_id']) && isset($_POST['current_url']) && isset($_POST['state'])) // three parameters exist
        {
            $web_id = $_POST['web_id'];
            $current_url = $_POST['current_url'];
            $ad_record = DBHelper::connection('ad_record');
            $query_config = "SELECT domain, allow_regex FROM ad_keyword_config WHERE web_id='$web_id'";
            $ad_config = DBHelper::select($ad_record, $query_config)[0]; // domain
            if (empty($ad_config))
            {
                $code = '403';
                $message = 'without matched web_id';
                $result = array(
                    'code'    => $code,
                    'message' => $message,
                    'data'    => null
                );
                return json_encode($result); // early stop
            }
            $domain = $ad_config['domain']; // domain
            $allow_regex = $ad_config['allow_regex']; // allow_regex

            if (parse_url($current_url)['host'] !== $domain || !preg_match($allow_regex, parse_url($current_url)['path'])) // if not match, early return
            {
                $code = '403';
                $message = 'This url is not allowed'; // domain or path is wrong
                $result = array(
                    'code'    => $code,
                    'message' => $message,
                    'data'    => null
                );
                return json_encode($result); // early stop
            }
        }
        else // lacking one or both or three
        {
            $code = '400';
            $message = 'Please check web_id, current_url, state as input';
            $result = array(
                'code'    => $code,
                'message' => $message,
                'data'    => null
            );
            return json_encode($result); // early stop
        }


        // with authority to search keyword by title, collect content first
        if (isset($_POST['title'])) // title existing, including '', 'xxxx' any string
        {

            //// To log impression and click
            $title = $_POST['title'];
            $uuid = isset($_POST['uuid']) ? $_POST['uuid'] : '_'; // get AviviD_uuid from cookie

            $query = "SELECT meta_title, web_id, keyword_ad FROM NewsTitleKeyword WHERE meta_title='$title'";

            // choose index 0, one title map to one keyword_ad
            $ad_record = DBHelper::connection('ad_record');
            $keyword_data = DBHelper::select($ad_record, $query)[0];
            // create default ad
            $default_keyword_data = array('keyword_ad'=>'microadtw720210602645833_投資', 'web_id'=> '_');
            // replace with default keyword, if not exist
            $keyword_data = isset($keyword_data)? $keyword_data : $default_keyword_data;

            $ad_id = explode('_', $keyword_data['keyword_ad'])[0]; //get id(banner_id without _n) of ad
            $keyword = explode('_', $keyword_data['keyword_ad'])[1]; // keyword
            $web_id_backup = $keyword_data['web_id'];
            
            $query = "SELECT id, url FROM banner_data WHERE list_id='$ad_id' AND banner_status=1";

            // maybe get many urls, random choose one to put
            $crescent_hodo = DBHelper::connection('crescent_hodo');
            $id_url_data = DBHelper::select($crescent_hodo, $query);

            // return json_encode($id_url_data);

            $index_to_pick = rand(0,count($id_url_data)-1);
            // return json_encode([count($id_url_data), rand(0,count($id_url_data)-1), $index_to_pick, $id_url_data]);

            $url = $id_url_data[$index_to_pick]['url'];
            $pre_banner_id = $id_url_data[$index_to_pick]['id'];

            //// count click (計算點擊)
            //// collect data /usr/share/nginx/html/pushServer/redirect/redirect_click.php need
            //// 10 slots in total, avivid_data = [push_type, web_id, category_id, user_id, url, banner_id, time_stamp, action, is_clip, cust_push_id]
            $push_type = 1; // cluster_news_page
            $web_id = isset($_POST['web_id'])? $_POST['web_id'] : $web_id_backup; // input by media

            $category_id = 0;
            $user_id = 0;
            $url = urlencode($url);
            $banner_id = $pre_banner_id.'_'.$keyword;
            $time_stamp = 0; // not used in redirect_click.php
            $action = 'default';
            $is_clip = 10; // what type of source, 10 for keyword ad
            $cust_push_id = '0'; // unknown
            $avivid_data = (string)$push_type.','.(string)$web_id.','.(string)$category_id.','.(string)$user_id.','
                            .(string)$url.','.(string)$banner_id.','.(string)$time_stamp.','.(string)$action.','
                            .(string)$is_clip.','.$cust_push_id;
            // input parameter for redirect_click.php API
            $avivid_code = base64_encode((string)$avivid_data);
            $render_url = 'https://clk-satellite.advividnetwork.com/pushServer/redirect/redirect_click.php?avivid_code='.$avivid_code;

        }
        
        else // title did not give, don't do anything
        {
            $code = '400';
            $message = 'without sending title';
            // $keyword = '';
            // $render_url = '#';
            $result = array(
                'code'    => $code,
                'message' => $message,
                'data'    => null
            );
            return json_encode($result); // early stop
        }

        // return content or log impression
        $state = $_POST['state']; // only when state=1, return content(keyword + url)
        if ($state == 1) // return content(keyword + url)
        {
            $code = '200';
            $message = 'receive title';
            $data = array(
                'keyword' => $keyword,
                'url' => $render_url,        
            );
            $result = array(
                'code'    => $code,
                'message' => $message,
                'data'    => $data
            );
            return json_encode($result);
        }

        elseif ($state == 2) // log impression
        {
            //// count impression (計算露出)
            // $uuid = create_uuid(); // generate uuid
            $os_browser_array = get_os_browser_type();
            $os_type = $os_browser_array[0];
            $browser_type = $os_browser_array[1];
            $client_ip = get_client_ip();
            $log_date = date('Y-m-d');
            $log_hour = date('H');
            $add_time = date('Y-m-d H:i:s');

            $query_impression = "INSERT INTO impression_log
                                SET banner_id = '$banner_id',
                                    push_type = '$push_type',
                                    os_type   = '$os_type',
                                    web_id    = '$web_id',
                                    uuid      = '$uuid',
                                    ip        = '$client_ip',
                                    is_clip   = '$is_clip',
                                    url       = '_',
                                user_gcm_id = '',
                                    browser   = '$browser_type',
                                    log_date  = '$log_date',
                                    log_hour  = '$log_hour',
                                    add_time  = '$add_time'
                                ";

            $SQL_connect = DBHelper::connection('meteor_db0'); 
            DBHelper::insert($SQL_connect, $query_impression);

            $code = '200';
            $message = 'success to log impression';
            $result = array(
                'code'    => $code,
                'message' => $message,
                'data'    => null
            );
            return json_encode($result);
        }

        else // error invalid state
        {
            $code = '400';
            $message = 'invalid state';
            $result = array(
                'code'    => $code,
                'message' => $message,
                'data'    => null
            );
            return json_encode($result); // early stop
        }



        // $data = array(
        //     'keyword' => $keyword,
        //     'url' => $render_url,        
        // );
        // $result = array(
        //     'code'    => $code,
        //     'message' => $message,
        //     'data'    => $data
        // );
        // return json_encode($result);
    }



    function get_os_browser_type(){
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '_';
        $os_type  = "unknown";
        $os_array     = array(
                              '/windows/i'            =>  'Windows',
                              '/windows nt 10/i'      =>  'Windows 10',
                              '/windows nt 6.3/i'     =>  'Windows 8.1',
                              '/windows nt 6.2/i'     =>  'Windows 8',
                              '/windows nt 6.1/i'     =>  'Windows 7',
                              '/windows nt 6.0/i'     =>  'Windows Vista',
                              '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                              '/windows nt 5.1/i'     =>  'Windows XP',
                              '/windows xp/i'         =>  'Windows XP',
                              '/windows nt 5.0/i'     =>  'Windows 2000',
                              '/windows me/i'         =>  'Windows ME',
                              '/win98/i'              =>  'Windows 98',
                              '/win95/i'              =>  'Windows 95',
                              '/win16/i'              =>  'Windows 3.11',
                              '/macintosh|mac os x/i' =>  'Mac OS X',
                              '/mac_powerpc/i'        =>  'Mac OS 9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
        $browser_type = 'unknown';
        $browser_array = array(
                                '/msie/i' => 'Internet explorer',
                                '/firefox/i' => 'Firefox',
                                '/safari/i' => 'Safari',
                                '/chrome/i' => 'Chrome',
                                '/edge/i' => 'Edge',
                                '/opera/i' => 'Opera',
                                '/mobile/i' => 'Mobile browser'
                        );

        
        foreach ($os_array as $regex => $value)
        {
            if (preg_match($regex, $user_agent))
            {
                $os_type = $value;
            }
        }

        foreach ($browser_array as $regex => $value)
        {
            if (preg_match($regex, $user_agent))
            {
                $browser_type = $value;
            }
        }

        return [$os_type, $browser_type];

    }


    function get_client_ip(){

        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $strings = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $pattern = '/[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}/';
            $int = preg_match($pattern, $strings, $resultArray);
            return $resultArray[0];
        } else {
            return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '_';
        }

    }





?>


