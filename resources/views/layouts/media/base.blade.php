
<!doctype html>
<html>
<head>

    <title>
        @yield('title')
    </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- for css rendering -->
    @yield('cdn_css')
    <!-- for js rendering -->
    @yield('cdn_js')


    <!-- Custom CSS -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('/css/media/chart_table.css')}}" /> -->
    @include('custom_css')

    <!-- <link rel="stylesheet" type="text/css" href="../css/media/chart_table.css" /> -->

    <!-- Custom JS -->
    @yield('custom_js')



    <!-- dateRangePicker -->
    <!-- month Picker -->



</head>

<body style="background-color: #CDD6D5;">


    <div class="container profile">
        <div class="row">
                
            <div class="col-6 account">
            @if(session()->has('web_id'))
            {{ Session::get('web_id') }}
            @endif
            <!-- Username -->
            </div>

            <div class="col-4 dropdown">
                <img class="btn btn-secondary dropdown-toggle profile_logo" type="button" id="profileButton" data-bs-toggle="dropdown" aria-expanded="false" src='img/master/b2c-pic.png'>

                <ul class="dropdown-menu" style="top: 10px; left: -45px;" aria-labelledby="profileButton">
                    <li> <a class="dropdown-item" href="#">會員資料修改</a></li>
                    <li> <a class="dropdown-item" href="#">修改密碼</a></li>
                    <!-- <hr style="margin:auto;"> -->
                    <li> <a onclick="logout()" class="dropdown-item" style="cursor: pointer;">登出</a></li>
                </ul>
            </div>
            
            <div class="col-1 language">
                <img src="country/TW.imageset/TW@2x.png" style="width:20px; height: 17px;">
            </div>
        </div>
            

    </div>



    

    <div class="sidebar_base">
        
            <div class="sidebar_base_upper">
                <a href="{{ route('home') }}"><img id="hodo_logo" src="img/master/master_logo.png"></a>
            </div>

            <li>                        
                <button class="dropdown-manu" type="button" data-bs-toggle="collapse" data-bs-target="#daily_button" aria-expanded="false" aria-controls="daily_button">
                    每日報數據總覽表 <i class="fa fa-caret-down"></i>
                </button>

                <div class="collapse" id="daily_button">
                    <a class="dropdown-item-text dropdown-manu" href="{{ route('home') }}" >數據總覽</a>
                    <a class="dropdown-item-text dropdown-manu" href="{{ route('daily.report') }}" >每日報表</a>
                    <a class="dropdown-item-text dropdown-manu" href="#">聯播網上檔廣告</a>
                </div>
            </li>

            <li>                        
                <button class="dropdown-manu" type="button" data-bs-toggle="collapse" data-bs-target="#adserver_button" aria-expanded="false" aria-controls="adserver_button">
                    廣告伺服器 <i class="fa fa-caret-down"></i>
                </button>
                <div class="collapse" id="adserver_button">
                    <a class="dropdown-item-text" href="/create_ad">廣告上稿設定</a>
                    <a class="dropdown-item-text" href="admiddle" class="dropdown_list">廣告執行中</a>
                    <a class="dropdown-item-text" href="ad1" class="dropdown_list">廣告待執行</a>
                    <a class="dropdown-item-text" href="ad2" class="dropdown_list">廣告已執行</a>
                    <a class="dropdown-item-text" href="admiddle2" class="dropdown_list">廣告待審中</a>
                    <a class="dropdown-item-text" href="noad" class="dropdown_list">審核未過廣告</a>
                    <a class="dropdown-item-text" href="monthly" class="dropdown_list">每月應收</a>
                </div>
            </li>
            
            <li>

                <button class="dropdown-manu" href="setting" class="sidebar_words">設定</button>
            </li>    

        
    </div>
            
      


    <div class="content">
        @yield('content')
    </div class="content">



        
    
</body>



<!-- <script type="text/javascript">
    $(function() {

        

    $('input[name="daterange"]').daterangepicker({
        opens: 'left',
        "autoApply": true

    }, function(start, end, label) {

        var update_date_from = start.format('YYYY-MM-DD');
        var update_date_to = end.format('YYYY-MM-DD');

        console.log("A new date selection was made: " + update_date_from + ' to ' + update_date_to);

    });

    $.ajax({
              type: "GET",
              url: "",
              dataType: "json",
              data: {
                  _token: CSRF_TOKEN,
                  from_date: $.datepicker.update_date_from,
                  to_date: $.datepicker.update_date_to,
                  campaign_type: "executed"
                    }
            });

    });
    </script> -->





 <script type="text/javascript">

    function logout()
    {
        console.log('xxxxx')
        $.ajax({
            type: "GET",
            url: "/clear/session",
            dataType: "json",
            data: 
            {
                key: "web_id",
            },
            success: function()
            {
                window.location.replace('/login');
            },
            error: function() {
                window.location.replace('/login');    

            },
                    
        });

    }

    // $(document).ready(function () {

    
    // });
</script>



