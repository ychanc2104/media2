<html>
    <head>
         <!-- Optional theme -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.9.1.min.js" integrity="sha256-wS9gmOZBqsqWxgIVgA8Y9WcQOa7PgSIX+rPA0VL2rbQ=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link href="css/master.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <title>App Name - @yield('title')</title>
   
    </head>
    
    <body>

        <div class="container_0">
        
                <div class="background_0">
                    
                        <ul class="navbar">
                            <li class="profile_0">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="right: 45px;
                                    position: absolute;
                                    background-image: url('img/master/b2c-pic.png'); background-repeat: no-repeat;width: 100px;
                                    height: 100px;
                                    top: 15px;">
                                    </button>
                                    <!-- <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>

                                    </div> -->
                                </div>
                                <button onclick="document.getElementById('langpage').style.display='block'; document.getElementById('langpage_fade').style.display='block'" href="javascript:void(0)" class="languagebtn">
                                    <img style="margin-bottom: 55px;width: 20px;margin-right: 10px; margin-top: 20px"src="country/TW.imageset/TW@2x.png">
                                </button>
                                <div id="langpage">
                                    <p class="">Local</p>
                                    <button class="xbtn" onclick="document.getElementById('langpage').style.display='none'; document.getElementById('langpage_fade').style.display='none'" href="javascript:void(0)">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                    </button>

                                </div>
                                <div id="langpage_fade"><div>

                            </li>
                        </ul>
                            <div class="sidebar_1">
                                <img class="master_logo" src="img/master/master_logo.png">
                                <a href="pg1" class="sidebar_words1">每日報表</a>
                                <a href="pg2" class="sidebar_words2">各廣告成效查詢</a>
                            </div>
                    
                    @yield('content1')

                </div>

           
        </div>
        <!-- @yield('content1') -->
    </body>
</html>

 
 