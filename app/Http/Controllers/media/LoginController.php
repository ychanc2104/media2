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
        $account = $inputData->input('email');
        $password = $inputData->input('password');

        $query = "SELECT src_web_id, password, salt FROM `media_account` WHERE account='$account'";
        $media_account = DB::connection('account')->select($query)[0];
        $salt = $media_account->salt;

        $pwd_confirm = sha1($salt . sha1($salt . sha1($password)));
        $is_pwd_correct = ($media_account->password == $pwd_confirm);
        // dd([$pwd_confirm, $media_account->password]);

        if (!$is_pwd_correct)
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
        else
        {
            Session::put('web_id', $media_account->src_web_id);
            Session::put('account', $media_account->src_web_id);

            return redirect()->intended('/home');
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
