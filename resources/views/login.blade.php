@extends('layouts.app')

@section('title', 'Login')



@section('content')
<div class="container">
    <div>
        <img class="header_label" src="img/master/header_label.png">
        <div class="backstage">經銷商廣告後台</div>
    </div>
    <div class="profile">
        <!-- <img style="height: 150px; width: 150px;" src="img/master/people_icon.png"> -->

        <form action="/post-login" method="post">
            @csrf
            <span class="login_accout_form_span"><input type="text" class="login_input_style" name="email" placeholder=" 請輸入帳號"></span>
            <span class="login_accout_form_span"><input type="password" class="login_input_style" name="password" placeholder=" 請輸入密碼"></span>
        
            <div class="phoneno">忘記密碼請撥打(02)2585-3361聯繫客服</div>
        
            <div><button class="loginbutton" type="submit">登入</button></div>
        </form>


        <!-- <div><button class="loginbutton" href="javascript:void(0)" type="button" style="margin-top:10px;" >Register</button></div>
        


        <div id="register_windowfade"></div>
       
        <div class="flag">
            <img class="lang" src="country/TW.imageset/TW@2x.png">
            <a href="" style="display:inline-block;font-size: smaller;color: darkturquoise; text-decoration: none;">中文</a>
        </div>
        <img class="logo" src="img/master/login_logo.png"> -->
    </div>  
</div>

@endsection