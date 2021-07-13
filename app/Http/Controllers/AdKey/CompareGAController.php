<?php

namespace App\Http\Controllers\AdKey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompareGAController extends Controller
{
    public static function count_click()
    {

        //// count impression (計算露出)
        $os_browser_array = self::get_os_browser_type();
        $os_type = $os_browser_array[0];
        $browser_type = $os_browser_array[1];
        $client_ip = self::get_client_ip();
        $log_date = date('Y-m-d');
        $log_hour = date('H');
        $add_time = date('Y-m-d H:i:s');


        $query_impression = "INSERT INTO compareGA_log
                             SET                                  
                                 os_type   = '$os_type',
                                 ip        = '$client_ip',
                                 browser   = '$browser_type',
                                 log_date = '$log_date',
                                 log_hour = '$log_hour',
                                 add_time = '$add_time',
                            ";
        DB::connection('cloud_crescent')->insert([
            'os_type' => '$os_type',
            'ip'      => '$client_ip',
            'browser' => '$browser_type',
            'log_date'=> '$log_date',
            'log_hour'=> '$log_hour',
            'add_time'=> '$add_time'
        ]);
        

        return view('count_click');

    }


    public static function get_os_browser_type(){
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
                                '/firefox/i'           =>  'Firefox',
                                '/chrome/i'           =>  'Chrome',
                                '/OPR/i'              =>  'Opera',
                                '/Safari/i'           =>  'Safari',
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




    public static function get_client_ip(){

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

}
