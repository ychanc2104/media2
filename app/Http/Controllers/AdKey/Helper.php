<?php
/*
|--------------------------------------------------------------------------
| likr共用helper
|--------------------------------------------------------------------------
|
| 這裡存放所有likr所需共用的function
| 欲修改helper請先修改master之文件在同步至各台server
| 
|--------------------------------------------------------------------------
| 修改記錄
|--------------------------------------------------------------------------
| 2017/06/23 York write_log
| 2017/06/27 York write_log換成likr_log
| 2017/06/29 Nathan ,Add error auto send mail
| 2017/06/30 York likr_log 陣列支援中文
| 2017/07/03 Heat 新增likr_escape, likr_error_response
| 2017/07/03 York 新增verify_webuserid, verify_category_id
| 2017/07/04 York 重新定義function 名稱
| 2017/07/06 York 新增get_category_children_str_likr
| 2017/07/14 York get_category_array_likr
| 2017/08/07 York 靜態物件化(暫時將寄信功能移除)
| 2017/08/09 York 增加靜態變數document_root, 加入各種DB include
| 2017/08/15 Heat 新增create_insert_sql
| 2017/08/17 York 新增csv匯出
| 2017/08/17 York 新增error_shotdown
*/
class Helper
{
    /**
     * @author  2017/08/09 York
     * @var     $document_root
     * @example include "/var/www/html/likr_library/Helper";
     * @example define('ROOT_PATH',Helper::$document_root);
     * @example include (ROOT_PATH . "likr_library/db_connect_subscribe.php");
     */
    public static $document_root = '/var/www/html/';
    public static function get_document_root()
    {
        return self::$document_root;
    }
    
    /**
     * @author  2017/06/27 York
     * @todo    寫log 
     * @param   string $fileName 
     * @param   string $contentType
     * @param   string $contentData
     * @example Helper::log(basename(__FILE__, '.php'),"log","web_id is undefined");
     * @example Helper::log(basename(__FILE__, '.php'),"log",array("web_id"=>"demo", "category"=>"20170706001000"));
     */

    public static function log($fileName, $contentType, $contentData)
    {
        //設定時區
        date_default_timezone_set("Asia/Taipei");
        //轉換陣列成json格式
        if(is_array($contentData))
        {
            array_walk_recursive($contentData, function(&$value, $key) 
            {
                if(is_string($value))$value = urlencode($value);
            });
            $contentData = urldecode(json_encode($contentData, JSON_FORCE_OBJECT));
        }
        //開啟檔案
        $txt = fopen(dirname(dirname(__FILE__))."/likr_log/{$fileName}_{$contentType}.log", "a");
        //撰寫responseData
        fwrite($txt, "\r\n[".date("Y/m/d H:i:s")."]-$contentData");
        //關閉檔案
        fclose($txt);
        //return
        return "done";
    }

    /**
     * @author  2017/08/17 York
     * @todo    寫csv
     * @param   string $fileName 
     * @param   string $Type
     * @param   array $contentData
     * @example $response = array($web_id, $category_id, $webuserid, $os_type, $browser_type);
     * @example Helper::csv("2017-08-17", "impression", $response);
     */

    public static function csv($fileName, $Type, $contentData)
    {
        //宣告控自串
        $csv_str = "";
        //依照陣列組成csv格式字串
        foreach ($contentData as $value )
        {
            $csv_str = $csv_str . "," . $value;
        }
        //去除第一個逗號
        $csv_str = substr($csv_str,1);
        //開啟檔案
        $txt = fopen(dirname(dirname(__FILE__))."/likr_csv/{$fileName}_{$Type}.csv", "a");
        //撰寫responseData
        fwrite($txt, "\r\n".$csv_str);
        //關閉檔案
        fclose($txt);
        //return
        return "done";
    }

    /**
     * @author  2017/07/03 Heat
     * @todo    欲跳脫字元(防止sql injection)
     * @param   string $str
     * @return  string
     * @example escape_str_likr($url);
     */
    public static function escape_str($str)
    {
        return mysql_real_escape_string(trim($str));
    }

    /**
     * @author  2017/07/03 York
     * @todo    驗證 webuserid 格式
     * @param   string $webuserid
     * @return  boolean
     * @example $webuserid = (Helper::verify_webuserid($webuserid)) ? $webuserid : response_error_likr("2","webuserid");
     */
    public static function verify_webuserid($webuserid)
    {
        //webuserid正規表示式
        $webuserid_pattern = '/^[a-zA-z0-9]{8}-[a-zA-z0-9]{4}-[a-zA-z0-9]{4}-[a-zA-z0-9]{4}-[a-zA-z0-9]{12}$/';
        //比對webuserid
        $webuserid_boolean = (preg_match($webuserid_pattern, $webuserid)) ? 1 : 0;
        return $webuserid_boolean;
    }

    /**
     * @author  2017/07/03 York
     * @todo    驗證 category_id 格式
     * @param   string $category_id
     * @return  boolean
     * @example (Helper::verify_category_id($category_id)) ? $category_id : response_error_likr("2","category_id");
     */
    public static function verify_category_id($category_id)
    {
        //category_id正規表示式
        $category_id_pattern = '/^(2)[0-9]{13}$/';
        //比對category_id
        $category_id_boolean = (preg_match($category_id_pattern, $category_id)) ? 1 : 0;
        return $category_id_boolean;
    }

    /**
     * @author  2017/07/06 York
     * @todo    取得所有子節點(包含自己)(用來放在SQL 查詢子句category IN ($category_str))
     * @param     string $web_id
     * @param     string $category_id
     * @return  str 
     * @example $category_str = Helper::get_category_children_str("demo", "20170616000029");
     *          $query = "SELECT * FROM `web_gcm_reg` WHERE `web_id` = 'demo' AND `category` IN ($category_str)";
     */
    public static function get_category_children_str($web_id, $root_id)
    {
        //載入資料庫
        include self::$document_root . "/likr_library/db_connect_subscribe.php";

        //撈取所有這個web_id的父子關係
        $select_category = "SELECT * FROM all_website_category WHERE `web_id` = '{$web_id}'";
        $select_category_data = mysql_query($select_category, $connect_sub) or die(mysql_error());
        $result_num = mysql_num_rows($select_category_data);

        //查詢結果拿這個web_id所有父子關係表
        $tree_temp = array();
        if(!empty($result_num))
        {
            while ($category_row = mysql_fetch_assoc($select_category_data))
            {
                $c_id = $category_row['category_id'];
                $c_pid = $category_row['category_pid'];
                array_push($tree_temp,array("category_id" => $c_id, "category_pid" => $c_pid));
            }
        }

        //取得所有子節點
        $all_child = "";
        $all_child = self::get_children($tree_temp, $root_id);

        //回傳所有子節點
        return $all_child;
    }
    public static function get_children($tree, $root_id)
    {

        $temp = "'".$root_id."'";

        foreach($tree as $key => $value)
        {   
            //宣告暫存字串
            $c_id = $value['category_id'];
            $c_pid = $value['category_pid'];

            if($c_pid == $root_id)
            {
                //關鍵遞迴
                $temp = $temp.",".self::get_children($tree, $c_id);
                unset($value);
            }
        }
        //回傳字串
        return $temp;
    }

    /**
     * @author  2017/07/07 York
     * @todo    驗證 email 格式
     * @param     string $email
     * @return  boolean
     * @example $email = (Helper::verify_email($email)) ? $email : response_error_likr("2","email");
     */
    public static function verify_email($email)
    {
        //email正規表示式
        $email_pattern = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
        //比對email
        $email_boolean = (preg_match($email_pattern, $email)) ? 1 : 0;
        return $email_boolean;
    }

    /**
     * @author  2017/07/07 York
     * @todo    驗證 url 格式
     * @param     string $url
     * @return  boolean
     * @example $url = (Helper::verify_url($url)) ? $url : response_error_likr("2","url");
     */
    public static function verify_url($url)
    {
        //url正規表示式
        $url_pattern = "/\b(?:(?:https?|ftp|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";

        //比對email
        $url_boolean = (preg_match($url_pattern, $url)) ? 1 : 0;
        return $url_boolean;
    }

    /**
     * @author  2017/07/14 York
     * @todo    取得所有父節點(包含自己)
     * @param   string $web_id
     * @param   array $category_id_array
     * @return  array
     * @example $array = Helper::get_category_array("heat",array("20170606000005", "20170619000002"));
     */
    public static function get_category_array($web_id, $category_id_array)
    {
        //載入資料庫
        include self::$document_root. "/likr_library/db_connect_subscribe.php";

        //撈取所有這個web_id的父子關係
        $select_category = "SELECT * FROM all_website_category WHERE `web_id` = '{$web_id}'";
        $select_category_data = mysql_query($select_category, $connect_sub) or die(mysql_error());
        $result_num = mysql_num_rows($select_category_data);

        //查詢結果拿這個web_id所有父子關係表
        $tree_temp = array();
        if(!empty($result_num))
        {
            while ($category_row = mysql_fetch_assoc($select_category_data))
            {
                $c_id = $category_row['category_id'];
                $c_pid = $category_row['category_pid'];
                array_push($tree_temp,array("category_id" => $c_id, "category_pid" => $c_pid));
            }
        }

        $all_category_str = "";
        //依照category_id_array一個一個抓父節點
        foreach($category_id_array as $key => $value)
        {
            //宣告暫存字串
            $c_id = $value;
            //取得所有父節點
            $all_category = "";
            $all_category = self::get_category_recursive($tree_temp, $c_id);
            $all_category_str = $all_category_str . "," . $all_category;
        }
        //字串轉陣列
        $all_category_array = explode(",",$all_category_str);
        //去重複
        $all_category_array = array_unique($all_category_array);
        //刪除_
        $all_category_array = array_flip($all_category_array);
        unset($all_category_array['_']);
        $all_category_array = array_flip($all_category_array);

        //回傳所有父節點
        return $all_category_array;
    }
    public static function get_category_recursive($tree, $category_id)
    {

        $temp = $category_id;

        foreach($tree as $key => $value)
        {   
            //宣告暫存字串
            $c_id = $value['category_id'];
            $c_pid = $value['category_pid'];

            if($c_id == $category_id)
            {
                //關鍵遞迴
                $temp = $temp.",".self::get_category_recursive($tree, $c_pid);
            }
        }
        //回傳字串
        return $temp;
    }

    /**
     * @author  2017/08/15 Heat
     * @todo    產生insert sql code 
     * @param   String $tablename 資料表名稱
     * @param   Array  $data
     * @return  String
     * @example Helper::create_insert_sql('user_data', array('name' => 'heat'));
     */
    public static function create_insert_sql($tablename, $data)
    {
        $keys = array_keys($data);
        $values = array();
        for ($i = 0; $i < count($keys); ++$i)
        {
            array_push($values, "'".$data[$keys[$i]]."'");
        }
        return "INSERT INTO $tablename (".implode(",", $keys).") VALUES (".implode(",", $values).")";
    }

    /**
     * @author    2017/08/31 York
     * @todo      紀錄錯誤並關閉程式
     * @param     String      $file_name  資料表名稱
     * @param     String      $type       錯誤類型(1:沒收到 2:驗證錯誤 3:查詢不到東西 4:mysql error)
     * @param     String      $error_msg  錯誤訊息
     * @param     Boolean     $exit       是否結束程式(預設不關閉)
     * @example   Helper::error_shotdown(basename(__FILE__, '.php'),  "1", "web_is", TURE);
     * @example   Helper::error_shotdown(basename(__FILE__, '.php'),  "1", "web_id");
     */
    public static function error_shotdown($file_name, $type, $error_msg, $exit = FALSE)
    {
        //整理錯誤訊息
        $response = array(
            "status"            => $type,
            "resText"           => $error_msg,
        );
        //編寫錯誤
        self::log($file_name, "error", $response);
        if( $exit ) exit();
    }
}
?>
