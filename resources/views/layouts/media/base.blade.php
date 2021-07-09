
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
    <link rel="stylesheet" type="text/css" href="/css/media/chart_table.css" />

    
    <!-- Google Charts -->
    <!-- <script type="text/javascript" src="https://www.google.com/jsapi"></script> -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart']});
    </script>

    <!-- Default running and setting script -->
    @include('Home_js.defaultJS')

    <!-- Custom script -->
    @include('Home_js.drawJS')
    @include('Home_js.updateJS')

    <!-- dateRangePicker -->
    <!-- month Picker -->



</head>

<body style="background-color: #CDD6D5;">

    

    <div class="sidebar_base">
        
            <div class="sidebar_base_upper">
                <a href="/home"><img id="hodo_logo" src="img/master/master_logo.png"></a>
            </div>

            <li>                        
                <button class="dropdown-manu" type="button" data-bs-toggle="collapse" data-bs-target="#daily_button" aria-expanded="false" aria-controls="daily_button">
                    每日報數據總覽表 <i class="fa fa-caret-down"></i>
                </button>

                <div class="collapse" id="daily_button">
                    <a class="dropdown-item-text dropdown-manu" href="/home" >數據總覽</a>
                    <a class="dropdown-item-text dropdown-manu" href="/daily_report" >每日報表</a>
                    <a class="dropdown-item-text dropdown-manu" href="#">聯播網上檔廣告</a>
                </div>
            </li>

            <li>                        
                <button class="dropdown-manu" type="button" data-bs-toggle="collapse" data-bs-target="#adserver_button" aria-expanded="false" aria-controls="adserver_button">
                    廣告伺服器 <i class="fa fa-caret-down"></i>
                </button>
                <div class="collapse" id="adserver_button">
                    <a class="dropdown-item-text" href="adsetting">廣告上稿設定</a>
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



<script>
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
    </script>



    <script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("sidebar_words");
    var i;

    for (i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
    dropdownContent.style.display = "none";
    } else {
    dropdownContent.style.display = "block";
    }
    });
    }
    
    </script>
    <script>
    $(document).ready(function () {
  $('#increment').click(function(){
      var width = $("#email1");
      var input;
      var input = $("<input>").attr("type","text").attr("name","email[]");
      var br = $("<br>");
      width.append(br);
      width.append(input);
    });
    });
</script>

<script>
    var myApp = new function () {
this.printData = function ()
{
   var divToPrint=document.getElementById("table");
   var style = "<style>";
                style = style + "table {width: 100%;font: 17px Calibri;}";
                style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
                style = style + "padding: 2px 3px;text-align: center;}";
                style = style + "</style>";

    var win = window.open('', '', 'height=800,width=700');
    win.document.write(style);  
   win.document.write(divToPrint.outerHTML);
   win.print();
   win.close();
}}


</script>

