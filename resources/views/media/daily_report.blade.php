


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
    <script type="text/javascript" src="{{ asset('/js/dateRangePicker/monthPicker.js') }}"></script>


  <!-- default script to show latest month -->
  <script type="text/javascript">
      
      $.ajax(
          {
              type: 'get',
              url: '/daily_report/data',
              dateType: 'json',
              data: 
              {
                y_start: new Date().getFullYear(),
                y_end: new Date().getFullYear(),
                m_start: new Date().getMonth(),              
                m_end: new Date().getMonth(),
              },
              success: function(daily_report_data_json)
              {
                var daily_report_data = JSON.parse(daily_report_data_json);
                myHTML = ''
                daily_report_data.forEach(function(item, i) 
                {
                  myHTML += '<tr>' +
                            '<td>' + item['date']       + '</td>' +
                            '<td>' + item['profit']     + '</td>' +
                            '<td>' + item['impression'] + '</td>' +
                            '<td>' + item['clicks']     + '</td>' +
                            '<td>' + item['click_rate'] + '</td>' +
                            '</tr>';
                });
                $("#daily_report_table").html(myHTML);              

              },
              error: function()
              {
              console.log("發生錯誤: ");
              }
          });

  </script>


</head>




<script type="text/javascript">

  function transmit_query() 
  {
    // var query_start = get_query();
    // var query_end = get_query("show_end");

      var query_start = document.getElementById("show_start").innerHTML.split("月");
      var query_end = document.getElementById("show_end").innerHTML.split("月");
      
      // console.log(query_start);
      $.ajax(
          {
              type: 'get',
              url: '/daily_report/data',
              dateType: 'json',
              data: 
              {
                y_start: query_start[1],
                y_end: query_end[1],
                m_start: query_start[0],              
                m_end: query_end[0],
              },
              success: function(daily_report_data_json)
              {
                console.log('success')
                var daily_report_data = JSON.parse(daily_report_data_json);
                myHTML = ''
                daily_report_data.forEach(function(item, i) 
                {
                  myHTML += '<tr>' +
                            '<td>' + item['date']       + '</td>' +
                            '<td>' + item['profit']     + '</td>' +
                            '<td>' + item['impression'] + '</td>' +
                            '<td>' + item['clicks']     + '</td>' +
                            '<td>' + item['click_rate'] + '</td>' +
                            '</tr>';
                });
                $("#daily_report_table").html(myHTML);              

              },
              error: function()
              {
              console.log("發生錯誤: ");
              }
          });
  }


</script>




<body>









<div class="container">

  <div>
          <img src="{{ asset('/img/horizon_line.png') }}">
      <h4></h4>
  </div>
  <br>

  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->


    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <div id="sla-data-range" class="mrp-container nav navbar-nav">
          <span class="mrp-icon"><i class="fa fa-calendar"></i></span>
          <div class="mrp-monthdisplay">
            <span class="mrp-lowerMonth" id="show_start">1月2021</span>
            <span class="mrp-to"> to </span>
            <span class="mrp-upperMonth" id="show_end">3月2021</span>
          </div>
        <input id="date_start" type="hidden" value="201407" id="mrp-lowerDate" />
        <input id="date_end" type="hidden" value="201408" id="mrp-upperDate" />
      </div>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->


  <div>
    <select name="datatable_1_length" aria-controls="datatable_1" class="form-control input-sm input-xsmall input-inline">
      <option value="5">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="-1">All</option>
    </select>
  </div>


  <table id="daily_table" class="table" border = "1">
  <thead>
  <tr>
  <td>日期</td>
  <td>收益（含稅）</td>
  <td>露出數</td>
  <td>點擊數</td>
  <td>點擊率(%)</td>
  </tr>
  </thead>

  <tbody id="daily_report_table">
  
  </tbody>
 
  </table>

</div>



</body>



