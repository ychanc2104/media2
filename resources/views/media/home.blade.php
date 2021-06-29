@extends('layouts.media.base')

@section('content')


<script type="text/javascript">


  
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
      <!-- week -->
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
      <!-- <div class="container"> -->

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