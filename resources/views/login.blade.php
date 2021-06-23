@extends('layouts.app')

@section('title', 'Login')



@section('content')
<div class="container">
    <div>
        <img class="header_label" src="img/master/header_label.png">
        <div class="backstage">經銷商廣告後台</div>
    </div>
    <div class="profile">
        <img style="height: 150px; width: 150px;" src="img/master/people_icon.png">
        <span class="login_accout_form_span"><input type="text" class="login_input_style" name="email" placeholder=" 請輸入帳號"></span>
        <span class="login_accout_form_span"><input type="password" class="login_input_style" name="password" placeholder=" 請輸入密碼"></span>
       
        <div class="phoneno">忘記密碼請撥打(02)2585-3361聯繫客服</div>
       
        <div><button class="loginbutton" type="submit" href="">登入</button></div>
        <div><button class="loginbutton" href="javascript:void(0)" type="button" onclick="document.getElementById('register_window').style.display='block'; document.getElementById('register_windowfade').style.display='block'" style="margin-top:10px;" >Register</button></div>
        <div id="register_window">
            <p class="subtitle1">Create yout Likr account</p>
            <div class="input_info">
                <input type="text" class="fill_form" name="username" placeholder="Username" style="margin-top:30px;"></input>
                <input class="fill_form" type="password" name="password" placeholder="Password"></input>
                <input class="fill_form" type="password" name="password" placeholder="Confirm Password"></input>
                <input class="fill_form" type="text" name="" placeholder="Company Name"></input>
                <input class="fill_form" type="text" name="" placeholder="Contact Tel. No."></input>
                <input class="fill_form" type="text" name="email" placeholder="Contact Email"></input>
                <input class="fill_form" type="text" name="" placeholder="Register Website (ie. https://www.likr.com) "></input>
                <input class="fill_form" type="text" name="" placeholder="login.tax_id"></input>

                <p class="note">1.Please remove any code from 3rd party push notification service before installation</p>
                <p class="note">2.Current subscribers with a 3rd party push notification service provider will be automatically migrated to LirK system after installation.</p>
                <button type="submit" href="" class="submit_formbtn">Submit</button>
            </div>

        </div>
        <div id="register_windowfade"></div>
       
        <div class="flag">
            <img class="lang" src="country/TW.imageset/TW@2x.png">
            <a href="" style="display:inline-block;font-size: smaller;color: darkturquoise; text-decoration: none;">中文</a>
        </div>
        <img class="logo" src="img/master/login_logo.png">
    </div>  
</div>
@endsection