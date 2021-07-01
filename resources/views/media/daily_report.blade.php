

<!doctype html>
<html>
<head>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('/css/dateRangePicker/monthPicker.css')}}" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="{{ asset('/js/dateRangePicker/monthPicker.js') }}"></script> -->

  <!-- default running script-->
  @include('DailyReport_js.defaultJS')

  <!-- Month Picker script-->
  @include('DailyReport_js.monthPickerJS')

  <!-- Paginator script -->
  @include('DailyReport_js.paginatorJS')


  <style type="text/css">
    .page-link{
      cursor: pointer;
    }
  </style>

</head>







<body>

<div class="container">
  <div class="row">

    <div>
            <img src="{{ asset('/img/horizon_line.png') }}">
        <h4></h4>
    </div>
    <br>

    <div>
      <!-- Brand and toggle get grouped for better mobile display -->

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div id="sla-data-range" class="mrp-container nav navbar-nav">
            <span class="mrp-icon"><i class="fa fa-calendar"></i></span>
            <div class="mrp-monthdisplay">
              <span class="mrp-lowerMonth" id="show_start">xxxxx</span>
              <span class="mrp-to"> to </span>
              <span class="mrp-upperMonth" id="show_end">xxxxx</span>
            </div>
          <input id="date_start" type="hidden" value="201407" id="mrp-lowerDate" />
          <input id="date_end" type="hidden" value="201408" id="mrp-upperDate" />
        </div>

      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <select id="n_option" class="form-control" width="200" style="width: 200px">
            <option class="placeholder" selected disabled value="-1">選擇</option>
            <option onclick="transmit_query(1)" value="5">5</option>
            <option onclick="transmit_query(1)" value="10">10</option>
            <option onclick="transmit_query(1)" value="15">15</option>
            <option onclick="transmit_query(1)" value="20">20</option>
            <option onclick="transmit_query(1)" value="-1">All</option>
          </select>
        </div>
        <div class="col-md-4">
          <h4 id="page_indicator">目前有30筆資料，目前在第1頁，共有1頁</h4>
        </div>
      </div>
    </div>



    <table id="daily_table" class="table" border = "1">
    <thead>
    <tr>
    <td><b>日期       </b></td>
    <td><b>收益（含稅）</b></td>
    <td><b>露出數     </b></td>
    <td><b>點擊數     </b></td>
    <td><b>點擊率(%)  </b></td>
    </tr>
    </thead>
    <tbody id="daily_report_table">
    </tbody>
    </table>
    

    <!-- page url -->
    <div class="col align-self-center">
      <nav aria-label="Page navigation">
        <ul onclick="" id="page_navigator" class="pagination">
          <!-- place to display page navigator by js -->
        </ul>
      </nav>
    </div>

  </div> <!-- /row -->

</div> <!-- /container -->



</body>


<script type="text/javascript">

</script>
