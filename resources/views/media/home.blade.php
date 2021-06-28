@extends('layouts.media.base')

@section('content')
<!-- <div id="chart_div"></div> -->


    <!-- <table class="table" border = "1">
    <tr>
    <td>Id</td>
    <td>Date</td>
    <td>Total incomes</td>
    <td>Total exposures</td>
    <td>Total clicks</td>
    <td>Click rate (%)</td>
    </tr>
    @foreach ($media_data as $data)
    <tr>
    <td>{{ $data->id }}</td>
    <td>{{ $data->date_time }}</td>
    <td>{{ $data->profit }}</td>
    <td>{{ $data->impression }}</td>
    <td>{{ $data->total_click }}</td>
    <td>{{ $data->click_rate }}</td>
    </tr>
    @endforeach
    </table> -->







<script type="text/javascript">

  function return_data_select(clicked_id, clicked_value) 
  {
    // we set clicked_id as select_mode use for determining filtering mode,
    // clicked_value as number of year or month
    var year = clicked_value;
    $.ajax({
        type: 'get',
        url: '/home/get_chart_total_data',
        dateType: 'json',
        data: 
        {
          select_mode: clicked_id,
          year: year,
		    },
        success: function(chart_total_data_json)
        {
          change_4div_value(JSON.parse(chart_total_data_json)[1])
          // draw_4_charts(clicked_id, clicked_value)
          var chart_data = JSON.parse(chart_total_data_json)[0]
          // console.log(chart_data)
          show_chart(chart_data, ['profit'], ['總收益（含稅）'], 'tab_total_profit')
          show_chart(chart_data, ['impression'], ['總露出'], 'tab_total_impression')
          show_chart(chart_data, ['direct_click', 'clip_click', 'clicks'], ['直推點擊', '夾報點擊', '總點擊'], 'tab_total_click')
          show_chart(chart_data, ['click_rate'], ['點擊率'], 'tab_total_click_rate')

        }
    });
  }


  function show_div(id) 
  {
    var x = document.getElementById(id);
    if (x.style.display === "none")
    {
      x.style.display = "block";
    }
    else
    {
      x.style.display = "none";
    }
  }

  function show_date_manu(select_mode, id) 
  {
    // get chart data from url:/home/get_chart
    $.ajax(
      {
        type: 'get',
        url: '/home/get_total_data',
        dateType: 'json',
        success: function(total_data_json)
        {
          show_div(id) // display that div(year, month or week) first
          
          $(document).ready(function(){
            var myHTML = '';
            if (select_mode == 'year')
            {              
              // for selecting year
              var total_data = JSON.parse(total_data_json)
              var year_now = new Date().getFullYear();
              var year_smallest = total_data['year_smallest']
              for (var i = 0; i < year_now-year_smallest+1; i++) {
                myHTML += '<li id="year" value='+(year_now-i)+' onClick="return_data_select(this.id, this.value)"><a id="drop_item" class="dropdown-item">' + (year_now-i) + '</a></li>';
              }
              $("#year_li").html(myHTML);
            }
            else if (select_mode == 'month')
            {
              // for selecting month
              for (var i = 1; i < 13; i++) {
                myHTML += '<li id="month" value='+(i)+' onClick="return_data_select(this.id, this.value)"><a id="drop_item" class="dropdown-item">' + (i) + '月</a></li>';
              }
              $("#month_li").html(myHTML);
            }


            // else
            // {
            //   // for selecting year
            //   var total_data = JSON.parse(total_data_json)
            //   var year_now = new Date().getFullYear();
            //   var year_smallest = total_data['year_smallest']
            //   for (var i = 0; i < year_now-year_smallest+1; i++) {
            //     myHTML += '<li id="year" value='+(year_now-i)+' onClick="return_data_select(this.id, this.value)"><a id="drop_item" class="dropdown-item">' + (year_now-i) + '</a></li>';
            //   }
            //   $("#year_li").html(myHTML);
            // }

          });
        },
        error: function()
        {
          console.log("發生錯誤: ");
        }
      });
  }
  

</script>




<div class="container">
	<div>
		<h4>數據總覽</h4>
		<hr style="border: 0;height: 1px;background-color: #a7b9c6;margin: 0px;"/>
	</div>
	<br>
  <!-- date picker -->
  <div class="container">
    <div class="row row-cols-auto">
      <div class="col">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;時間
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li id='year' onclick="show_date_manu(this.id, 'div_filter_year')"><a id="drop_item" class="dropdown-item">年份</a></li>
            <li id='month' onclick="show_date_manu(this.id, 'div_filter_month')"><a id="drop_item" class="dropdown-item">月份</a></li>
            <li onclick="show_div('div_filter_week')"><a id="drop_item" class="dropdown-item" style="cursor: pointer;">任意區間</a></li>
          </ul>
        </div>
      </div>

      <!-- do not display -->
      <!-- year -->
      <div id="div_filter_year" class="col" style="display: none;">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              選擇年份
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li id="year_li"><a class="dropdown-item"></a></li>
            </ul>
          </div>
      </div>
      <!-- month -->
      <div id="div_filter_month" class="col" style="display: none;">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              選擇月份
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li id="month_li"><a class="dropdown-item"></a></li>
            </ul>
          </div>
      </div>

      <!-- <div id="div_filter_month" class="col" style="display: none;">
        <div class="btn-group">
            <span class="date_range" class="pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="filter">@lang('default.month_select')</span>
          <b class="caret"></b>
            </span>
            <ul id="filter_month" class="dropdown-menu" style="height:200px;overflow:auto;">
              <li><a onclick="updateChart('1','month',`@lang('default.month_jan')`);">@lang('default.month_jan')</a></li>
              <li><a onclick="updateChart('2','month',`@lang('default.month_feb')`);">@lang('default.month_feb')</a></li>
              <li><a onclick="updateChart('3','month',`@lang('default.month_mar')`);">@lang('default.month_mar')</a></li>
              <li><a onclick="updateChart('4','month',`@lang('default.month_apr')`);">@lang('default.month_apr')</a></li>
              <li><a onclick="updateChart('5','month',`@lang('default.month_may')`);">@lang('default.month_may')</a></li>
              <li><a onclick="updateChart('6','month',`@lang('default.month_jun')`);">@lang('default.month_jun')</a></li>
              <li><a onclick="updateChart('7','month',`@lang('default.month_jul')`);">@lang('default.month_jul')</a></li>
              <li><a onclick="updateChart('8','month',`@lang('default.month_aug')`);">@lang('default.month_aug')</a></li>
              <li><a onclick="updateChart('9','month',`@lang('default.month_sep')`);">@lang('default.month_sep')</a></li>
              <li><a onclick="updateChart('10','month',`@lang('default.month_oct')`);">@lang('default.month_oct')</a></li>
              <li><a onclick="updateChart('11','month',`@lang('default.month_nov')`);">@lang('default.month_nov')</a></li>
              <li><a onclick="updateChart('12','month',`@lang('default.month_dec')`);">@lang('default.month_dec')</a></li>
          </ul>
        </div>
      </div> -->

      <div id="div_filter_week" class="col" style="display: none;">
        <div class="btn-group">
          <span class="date_range" class="pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="filter">@lang('default.week_select')</span>
            <b class="caret"></b>
          </span>
          <ul id="filter_week" class="dropdown-menu" style="height:200px;overflow:auto;"></ul>
        </div>
        <div id="creat_table_div"></div>
      </div>
    </div>
  </div>

  <div class="container">
	  <div class="row">
      <!-- likr title -->
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product_tabs">
        <ul>
          <li class="col-12 col-lg-2 product_tab_active">
            <div id="likr_tab">
              <div style="margin: 20px 0 0 0;" class="tab_title">Likr推播</div>
            </div>
          </li>
        </ul>
		  </div>



      <!-- 報表tabs與圖 -->
      <!-- for control tabs -->
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button id="tab_total_attr" style="border-top-color: #4267b8;" class="nav-link active" id="tab_total_profit-tab" data-bs-toggle="tab" data-bs-target="#tab_total_profit" type="button" role="tab" aria-controls="tab_total_profit" aria-selected="true">
            總收益（含稅）NT$：
            <!-- total value -->
            <div id="likr_tab_total_profit"></div>
          </button>
          
        </li>
        <li class="nav-item" role="presentation">
          <button id="tab_total_attr" style="border-top-color: #6bc0b8;" class="nav-link" id="tab_total_impression-tab" data-bs-toggle="tab" data-bs-target="#tab_total_impression" type="button" role="tab" aria-controls="tab_total_impression" aria-selected="false">
            總露出：
            <!-- total value -->
            <div id="likr_tab_total_impression"></div>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button id="tab_total_attr" style="border-top-color: #ff9011;" class="nav-link" id="tab_total_click-tab" data-bs-toggle="tab" data-bs-target="#tab_total_click" type="button" role="tab" aria-controls="tab_total_click" aria-selected="false">
            總點擊：
            <!-- total value -->
            <div id="likr_tab_total_click"></div>
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button id="tab_total_attr" style="border-top-color: #f0c875;" class="nav-link" id="tab_total_click_rate-tab" data-bs-toggle="tab" data-bs-target="#tab_total_click_rate" type="button" role="tab" aria-controls="tab_total_click_rate" aria-selected="false">
            點擊率%：
            <!-- total value -->
            <div id="likr_tab_total_click_rate"></div>
          </button>
        </li>
      </ul>
      <!-- Google Charts below -->
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="tab_total_profit" role="tabpanel" aria-labelledby="tab_total_profit-tab"></div>
        <div class="tab-pane fade" id="tab_total_impression" role="tabpanel" aria-labelledby="tab_total_impression-tab"></div>
        <div class="tab-pane fade" id="tab_total_click" role="tabpanel" aria-labelledby="tab_total_click-tab"></div>
        <div class="tab-pane fade" id="tab_total_click_rate" role="tabpanel" aria-labelledby="tab_total_click_rate-tab"></div>
      </div>


    </div>
  </div>

</div>

@stop