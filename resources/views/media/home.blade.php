@extends('layouts.media.base')


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

    
  




 

<div class="portlet light">
	<div>
		<h4>@lang('default.data_overview')</h4>
		<hr style="border: 0;height: 1px;background-color: #a7b9c6;margin: 0px;"/>
	</div>
	<br>
  <!-- date picker -->

  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;時間
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li><a class="dropdown-item" href="#">年份</a></li>
      <li><a class="dropdown-item" href="#">月份</a></li>
      <li><a class="dropdown-item" href="#">週次</a></li>
    </ul>
  </div>

  <!-- do not display -->
  <div class="btn-group" id="div_filter_year" style="display: none;">
    <span class="date_range" class="pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="filter">@lang('default.year_select')</span>
      <b class="caret"></b>
    </span>
    <ul id="filter_year" class="dropdown-menu">
    </ul>
  </div>



  <div class="btn-group" id="div_filter_month" style="display: none;">
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

    <div class="btn-group" id="div_filter_week" style="display: none;">
      <span class="date_range" class="pull-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="filter">@lang('default.week_select')</span>
			  <b class="caret"></b>
      </span>
      <ul id="filter_week" class="dropdown-menu" style="height:200px;overflow:auto;"></ul>
    </div>

    <div style="margin-top: 20px;" id="creat_table_div"></div>

	  <div class="row">
      <!-- likr title -->

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 product_tabs">
        <ul class="">
          <li class="col-12 col-lg-2 product_tab_active">
            <div id="likr_tab">
              <div class="tab_title">Likr推播</div>
            </div>
          </li>
        </ul>
		  </div>
      <!-- 報表tabs與圖 -->
      <div class="col-12 likr">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 likr_chart">
          <ul class="nav nav-tabs nav-fill">        
            <li class="active nav-item  col-12 col-lg-2">              
              <div class="new_tab selected" style="border-top-color: #4267b8;">
                <div class="tab_title">總收益（含稅）NT$：</div>             
                <!-- <div style="padding-left: 20px;">NT$</div> -->
                <div id="likr_tab_total_profit"></div>
              </div>         
              <a data-toggle="tab" href="#incomes" style="background-color: #426481;">@lang('default.total_revenue')</a>
            </li>

            <li class="nav-item  col-12 col-lg-2">
              <div class="new_tab" style="border-top-color: #6bc0b8;">                    
                <div class="tab_title">總露出：</div>
                <div id="likr_tab_total_impression"></div>
              </div>
              <a style="background-color: #426481;" data-toggle="tab" href="#exposures">zzz@lang('default.total_impression')</a>
            </li>

            <li class="nav-item  col-12 col-lg-2">
              <div class="new_tab" style="border-top-color: #ff9011;">
                <div class="tab_title">總點擊：</div>
                <div id="likr_tab_total_click"></div>
              </div>
              <a style="background-color: #426481;" data-toggle="tab" href="#direct_clicks#indirect_clicks">zzzz@lang('default.total_click')</a>
            </li>

            <li class="nav-item  col-12 col-lg-2">
              <div class="new_tab" style="border-top-color: #f0c875;">
                <div class="tab_title">點擊率%：</div>
                <div id="likr_tab_total_click_rate"></div>
              </div>
              <a style="background-color: #426481;" data-toggle="tab" href="#clicks_rate">zzzzzz@lang('default.click_through_rate')</a>
            </li>
          </ul>

        </div>

      </div>

      <!-- place to show charts -->

      <div id="chart_div"></div>


    </div>

  </div>

</div>
