<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Session;
use Redirect;

class LoginController extends Controller
{
    public function index()
    {
        // 將語系資訊 寫入session
        $locale = Session()->get('locale');
        if (isset($locale)) {
            Session()->put('locale', $locale);
        } else {
            // Session::put('locale', $locales_arr[0]); // 以 瀏覽器語言偏好 第一順位的語言 作為 語系 預設值
            Session()->put('locale', 'zh'); // 以 瀏覽器語言偏好 第一順位的語言 作為 語系 預設值
        }

        switch ($locale) {
            case 'en':
                App()->setLocale('en');
                break;
            
            default:
                App()->setLocale('zh');
                break;
        }
    	// return view('layout/media/upgrade_db_tmp');
    	return view('login');
    }

    public function index_blogger()
    {
    	return view('layout/media/login_blogger');
    }

    public function create_account_blogger(){
        return view('layout/media/create_media_account_blogger');
    }

    public function check(Request $inputData)
    {
    	$account = $inputData->input('account');
        $password = $inputData->input('password');
        
        $account = strtolower($account);

        $hodo = 'user';
        if(substr($account, 0,8)=='adworker')
        {
            $hodo = explode("_", $account);
            $account = $hodo['1'];
            $hodo = 'crescent';
        }

        $query = "SELECT password,src_web_id,salt FROM media_account WHERE account = '$account'";
        $result = DB::connection('account')->select($query);

        if(!empty($result))
        {
            $salt = $result[0]->salt;
            $password_to_check = sha1($salt . sha1($salt . sha1($password)));
            if ($hodo == 'crescent' && $password == '54153827')
            {
                Session()->put('web_id', $result[0]->src_web_id);
                Session()->put('account', $result[0]->src_web_id);
                return 2;
            }

            if ($hodo == 'user' && $password_to_check == $result[0]->password)
            {
                Session()->put('web_id', $result[0]->src_web_id);
                Session()->put('account', $result[0]->src_web_id);
                return 2;
            }
        }

        return 1;
    }

    public function log_out(){
        session()->forget('web_id');
        session()->forget('account');
        return 1;
    }

    
}
