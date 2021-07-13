
@extends('layouts.media.base')


@section('cdn_css')
@include('cdn_js_css.home_css')
@stop

@section('cdn_js')
@include('cdn_js_css.home_js')
@stop

@section('title')
Overview
@stop



@section('custom_js')
<!-- Default running and setting script -->
@include('Home_js.defaultJS')
<!-- Custom script -->
@include('Home_js.drawJS')
@include('Home_js.updateJS')
@stop



@section('content')

<div>

  <!-- take session -->
  <!-- @if(session()->has('web_id'))
  <p>Login Success</p>
  @endif -->


	<!-- <div> -->
		<div class="overview">數據總覽</div>
    <hr style="border: 0;height: 5px;background-color: black ;margin: 10px;"/>

    <!-- date picker -->
    <div class="container" style="margin: 0 10px 10px 0px">
      <div class="row row-cols-auto">
        <div class="col">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;時間
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li id='year' onclick="show_date_manu(this.id, 'div_filter_year')"><a id="drop_item" class="dropdown-item">年份</a></li>
              <li id='month' onclick="show_date_manu(this.id, 'div_filter_month')"><a id="drop_item" class="dropdown-item">月份</a></li>
              <li id='default' onclick="return_data_select(this.id, 1)"><a id="drop_item" class="dropdown-item" style="cursor: pointer;">近七日</a></li>
            </ul>
          </div>
        </div>

        <!-- do not display -->
        <!-- year -->
        <div id="div_filter_year" class="col" style="display: none;">
          <div class="dropdown">
              <button id="year_picker" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
              <button id="month_picker" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                選擇月份
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li id="month_li"><a class="dropdown-item"></a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>    

	<!-- </div> -->

  <!-- <div style="height: 80vh; background-color: #2F4F4F ;"> -->
  <div style="height: 80vh; width: 80vw; background-color: white;">

	  <div class="row" style="margin: 0 0vw 0 0;">
      <!-- likr title -->
        <div class="tab_title">
          Likr推播
        </div>

      <!-- 報表tabs與圖 -->
      <!-- for control tabs -->
      <div class="container">

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
  <!-- </div> -->
</div>

@stop